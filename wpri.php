<?php




/**
 * The plugin bootstrap file
 *
 *
 * @link              https://github.com/zafeirakopoulos/wpri
 * @since             0.0.1
 * @package           wpri
 *
 * @wordpress-plugin
 * Plugin Name:       Research Institute
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A plugin turning WordPress to a research institute management website.
 * Version:           0.0.1
 * Author:            Zafeirakis Zafeirakopoulos
 * Author URI:        http://zaf.zafeirakopoulos.info
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpri
 * Domain Path:       /languages
 */

 define( 'WPRI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_DEBUG', true );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * To be deactivated in production.
 */
$GLOBALS['wpdb']->show_errors();


/**
 * Include dependencies
 */



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpri-activator.php
 */
function activate_wpri() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpri-activator.php';
	WPRI_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpri-deactivator.php
 */
function deactivate_wpri() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpri-deactivator.php';
	WPRI_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpri' );
register_deactivation_hook( __FILE__, 'deactivate_wpri' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpri.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpri() {

	$plugin = new WPRI();
	$plugin->run();

}
run_wpri();
