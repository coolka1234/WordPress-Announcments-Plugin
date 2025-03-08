<?php
/**
 * Plugin Name: announcments_plugin
 * Description: Insert your news before a post.
 * Version: 1.0
 * Author: Krzysztof Kulka, Tomasz Milewski
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
function naph_admin_actions(){ 
    add_options_page("Announcements Post", "Announcements", 'manage_options', "naph_anon", "naph_admin_page_anon"); 
} 

function naph_admin_page(){
?>
  <h1>Newly Added Post Highlighter</h1>
<?php
}
