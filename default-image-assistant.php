<?php

/**
 * Plugin Name: Default Image Assistant
 * Description: Manage and assign default featured images for each post type with a visual media selector.
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Version: 1.0
 * Author: Xiangxu
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: default-image-assistant
 *
 */
if (!defined('ABSPATH')) exit;

define('DEFAIMAS_VERSION', '1.0.0');

/**
 * Add settings page
 */
add_action('admin_menu', function () {
    add_options_page(
        'Default Image Assistant',
        'Default Image Assistant',
        'manage_options',
        'default-image-assistant',
        'defaimas_settings_page'
    );
});

/**
 * Enqueue media uploader script
 */
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'settings_page_default-image-assistant') return;

    wp_enqueue_media();
    wp_enqueue_script(
        'defaimas-admin-js',
        plugin_dir_url(__FILE__) . 'default-image-assistant.js',
        ['jquery'],
        DEFAIMAS_VERSION,
        true
    );
    wp_enqueue_style(
        'dia-admin-css',
        plugin_dir_url(__FILE__) . 'default-image-assistant.css',
        [],
        DEFAIMAS_VERSION,
    );
});

/**
 * Register settings
 */
add_action('admin_init', function () {
    register_setting('defaimas_settings_group', 'defaimas_default_images', [
        'sanitize_callback' => 'defaimas_sanitize_default_images'
    ]);
});

/**
 * Sanitization callback
 */
function defaimas_sanitize_default_images($input)
{
    $sanitized = [];

    foreach ($input as $ptype => $id) {
        $sanitized[sanitize_key($ptype)] = intval($id);
    }

    return $sanitized;
}

/**
 * Settings page HTML
 */
function defaimas_settings_page()
{
    $post_types = get_post_types(['public' => true], 'objects');
    $post_types = array_filter($post_types, function ($type) {
        return $type->name !== 'attachment';
    });
    $defaults = get_option('defaimas_default_images', []); ?>

    <div class="wrap">
        <h1>Default Image Assistant</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('defaimas_settings_group');
            do_settings_sections('defaimas_settings_page');
            ?>
            <div class="defaimas-card-container">
                <?php foreach ($post_types as $type):
                    $id = isset($defaults[$type->name]) ? $defaults[$type->name] : '';
                    $img = $id ? wp_get_attachment_image($id, 'medium') : '<em class="defaimas-no-image">No Image</em>';
                ?>
                    <div class="defaimas-card">
                        <h3><?php echo esc_html($type->labels->name); ?>
                            <br><code><?php echo esc_html($type->name); ?></code>
                        </h3>

                        <div class="defaimas-preview" data-ptype="<?php echo esc_attr($type->name); ?>">
                            <?php
                            $img = $id ? wp_get_attachment_image($id, 'thumbnail') : '<em class="defaimas-no-image">No Image</em>';
                            echo wp_kses_post($img);
                            ?>
                        </div>

                        <div class="defaimas-button-group">
                            <button type="button"
                                class="button button-primary defaimas-select"
                                data-ptype="<?php echo esc_attr($type->name); ?>">
                                Select Image
                            </button>

                            <button type="button"
                                class="button defaimas-remove-image"
                                data-ptype="<?php echo esc_attr($type->name); ?>">
                                Remove
                            </button>
                        </div>

                        <input type="hidden"
                            name="defaimas_default_images[<?php echo esc_attr($type->name); ?>]"
                            id="defaimas-input-<?php echo esc_attr($type->name); ?>"
                            value="<?php echo esc_attr($id); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }

/**
 * Front-end: apply default featured images
 */
add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if ($html) return $html;

    $post_type = get_post_type($post_id);
    $defaults = get_option('defaimas_default_images', []);

    if (isset($defaults[$post_type]) && intval($defaults[$post_type]) > 0) {
        $img_id = intval($defaults[$post_type]);
        return wp_get_attachment_image($img_id, $size, false, $attr);
    }

    return $html;
}, 10, 5);
