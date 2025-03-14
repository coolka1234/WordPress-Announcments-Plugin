# Announcements Plugin

## Description
The Announcements Plugin allows WordPress administrators to insert news or announcements before a post. This plugin randomly selects an announcement from the saved list and displays it on single post pages.

## Features
- Allows administrators to define up to 5 announcements.
- Uses the WordPress editor to format announcements.
- Randomly selects and displays an announcement before a post's content.
- Includes an admin settings page for easy management.

## Installation
1. Download the plugin files and upload them to the `/wp-content/plugins/announcements_plugin` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to `Settings > Announcements` to configure the plugin.

## Usage
1. In the WordPress admin panel, go to `Settings > Announcements`.
2. Set the number of announcements you want to display (up to 5).
3. Enter the announcements using the built-in WordPress editor.
4. Save the settings.
5. The plugin will randomly display one of the saved announcements before each post.

## Hooks & Filters
- `add_action('admin_menu', 'ap_admin_actions')` - Adds the announcements settings page to the admin menu.
- `add_filter('the_content', 'ap_add_announcements')` - Appends a random announcement before post content.
- `add_action('init', 'ap_register_styles_css')` - Enqueues custom CSS for the plugin.

## License
This plugin is licensed under the GPL v2 or later. See [GNU GPL v2 License](https://www.gnu.org/licenses/gpl-2.0.html) for details.

## Authors
- Krzysztof Kulka
- Tomasz Milewski

