<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://shehab24.github.io/portfolio/
 * @since             1.0.0
 * @package           Post_Words_Counter
 *
 * @wordpress-plugin
 * Plugin Name:       Post Words Counter
 * Plugin URI:        https://wordpress.org/plugins/post-words-counter/
 * Description:       This plugin counts all words into a post and shows the total words and reading time in the post's contents 
 * Version:           1.0.1
 * Author:            Shehab Mahamud
 * Author URI:        https://shehab24.github.io/portfolio/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-words-counter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC'))
{
	die;
}

if (!defined('ABSPATH'))
	exit;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('POST_WORDS_COUNTER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-post-words-counter-activator.php
 */
function pstwc_post_words_counter_activate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-post-words-counter-activator.php';
	PSTWC_Post_Words_Counter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-post-words-counter-deactivator.php
 */
function pstwc_post_words_counter_deactivate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-post-words-counter-deactivator.php';
	PSTWC_Post_Words_Counter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'pstwc_post_words_counter_activate');
register_deactivation_hook(__FILE__, 'pstwc_post_words_counter_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-post-words-counter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function pstwc_post_words_counter_run()
{

	$plugin = new PSTWC_Post_Words_Counter();
	$plugin->run();

}
pstwc_post_words_counter_run();
