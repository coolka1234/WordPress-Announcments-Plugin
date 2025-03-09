<?php
/**
 * Plugin Name: announcements_plugin
 * Description: Insert your news before a post.
 * Version: 1.0
 * Author: Krzysztof Kulka, Tomasz Milewski
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

function ap_admin_actions() {
    add_options_page("Announcements Settings", "Announcements", 'manage_options', "ap_anon", "ap_admin_page_anon");
}

function ap_admin_page_anon() {
    $amount = get_option('amount') ?? 0;
    $opAnon = array();

    if (isset($_POST['ap_do_change']) && $_POST['ap_do_change'] == 'Y') {
        $amount = $_POST['amount'];
        for ($i = 1; $i <= $amount; $i++) {
            $opAnon[$i] = wp_kses_post($_POST['ap_announcements' . $i] ?? '');
            update_option('ap_announcements' . $i, $opAnon[$i]);
        }
        update_option('amount', $amount);
        echo '<div class="onSave"><p>Settings saved.</p></div>';
    }

    for ($i = 1; $i <= $amount; $i++) {
        $opAnon[$i] = get_option('ap_announcements' . $i);
    }
    ?>
    <div class="wrap">
        <h1>Announcements Settings</h1>
        <form name="ap_form" method="post">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" min="0" max="5" value="<?php echo $amount; ?>">
            <div class="wrap">
                <input type="hidden" name="ap_do_change" value="Y">
                <?php for ($i = 1; $i <= $amount; $i++):
                    $settings = array(
                        'textarea_name' => 'ap_announcements' . $i,
                        'media_buttons' => true,
                        'editor_height' => 200,
                        'tinymce'       => true,
                    );
                ?>
                    <h3>Announcement <?php echo $i; ?></h3>
                    <?php wp_editor($opAnon[$i], 'ap_announcements_editor' . $i, $settings); ?>
                <?php endfor; ?>
            </div>
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    <div class="info">
        <p>Plugin created by Krzysztof Kulka and Tomasz Milewski</p>
    </div>
    <?php
}

function ap_add_announcements($content) {
    if (is_single()) {
        $amount = get_option('amount');
        if ($amount > 0) {
            $rand_number = rand(1, $amount);
            $announcement = get_option('ap_announcements' . $rand_number);
            $content = '<div class="announcement">' . $announcement . '</div>' . $content;
        }
    }
    return $content;
}

function ap_register_styles_css() {
    wp_enqueue_style('announcements-style', plugin_dir_url(__FILE__) . 'css/style.css');
} 

add_action('init', 'ap_register_styles_css');
add_action('admin_menu', 'ap_admin_actions');
add_filter('the_content', 'ap_add_announcements');

?>
