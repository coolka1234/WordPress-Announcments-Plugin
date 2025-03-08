<?php
/**
 * Plugin Name: announcments_plugin
 * Description: Insert your news before a post.
 * Version: 1.0
 * Author: Krzysztof Kulka, Tomasz Milewski
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
function ap_admin_actions(){ 
    add_options_page("Announcements Post", "Announcements", 'manage_options', "ap_anon", "ap_admin_page_anon"); 
} 

function ap_admin_page(){
?>
  <h1>Announcements Plugin</h1>
<?php
}
function ap_admin_page_anon(){ 
	$amount = get_option('amount') ?? 0;
	$opAnon = array();

    if(isset($_POST['ap_do_change'])){
		if($_POST['ap_do_change'] == 'Y'){ 
			$amount = $_POST['amount']; 

			for ($i=1; $i<=$amount; $i++) {
				$opAnon[$i] = wp_kses_post($_POST['ap_announcements'.$i] ?? '');
				update_option('ap_announcements'.$i, $opAnon[$i]);
			}
			echo '<div class="notice notice-success is dismissible"><p>Settings saved.</p></div>'; 
			update_option('amount', $_POST['amount']);
		}
    } 

	for ($i=1; $i<=$amount; $i++) {
		$opAnon[$i] = get_option('ap_announcements'.$i);
	}

   ?>
    <div class="wrap">
        <h1>Announcements</h1>
        <form name="ap_form" method="post">
			<label for="amount">Amount:</label>
			<input type="number" name="amount" id="amount" min="0" max="10" value="<?php echo $amount; ?>">    
			<div class="announcements-wrapper">
				<input type="hidden" name="ap_do_change" value="Y">
				<?php for($i=1; $i<=$amount; $i++): ?>
					<textarea type="text" name="<?= 'ap_announcements'.$i?>" cols="60" rows="6"><?= $opAnon[$i] ?></textarea>
				<?php endfor ?>
			</div>
			<?php
			if(isset($_POST['number']) && $_POST['number'] != "") {
				$number = $_POST['number'];
				if($number <= $amount) {
					$settings = array(
						'textarea_rows' => 6,
						'media_buttons' => true,
						'textarea_name' => 'ap_announcements'.$number
					);	
					wp_editor($opAnon[$number], 'ap_announcements_editor'.$number, $settings);
				}
			}
			?>
			<h1>Choose announcement to change:</h1>
			<input type="number" name="number" id="number" min="1" max="<?= $amount ?>" value="<?= ($number <= $amount) ? $number : '' ?>">
			<?php submit_button( 'Submit' );?>
        </form>
    </div>
<?php
}   
	
function ap_add_announcements($content){ 
	if ( is_single() ) {
		$rand_number = rand(1, get_option('amount'));
		$content = get_option('ap_announcements'.$rand_number) . $content;
	}
	return $content;
} 

function ap_register_styles_css(){ 
    wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . '/css/style.css' );
} 

add_action('init', 'ap_register_styles_css'); 
add_action('admin_menu', 'ap_admin_actions'); 
add_filter('the_content', "ap_add_announcements"); 

?>
