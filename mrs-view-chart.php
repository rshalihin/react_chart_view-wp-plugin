<?php
/**
 * View Chart With React.
 *
 * @package           view-chart-react
 * @author            Md. Readush Shalihin <r.shalihin143@gmail.com>
 * @copyright         2019 SapphireIT
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       View Chart With React
 * Plugin URI:        https://example.com/plugin-name
 * Description:       It show a react chart in WordPress dashboard via rest api.
 * Version:           0.1.0
 * Requires at least: 5.3
 * Requires PHP:      7.2
 * Author:            Md. Readush Shalihin
 * Author URI:        https://facebook.com/rshalihin
 * Text Domain:       view-chart-react
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'VCWR_VERSION' ) ) {
	define( 'VCWR_VERSION', '0.1.0' );
}
if ( ! defined( 'VCWR_PATH' ) ) {
	define( 'VCWR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'VCWR_URL' ) ) {
	define( 'VCWR_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'VCWR_DIR' ) ) {
	define( 'VCWR_DIR', plugin_dir_url( __DIR__ ) );
}

/**
 * Store plugin version and install time in database.
 *
 * @return void
 */
function activate_react_chart_view() {
	$install = get_option( 'react_chart_view_install' );
	if ( ! $install ) {
		update_option( 'react_chart_view_install', time() );
	}
	update_option( 'react_chart_view_version', VCWR_VERSION );

	global $wpdb;
	$prefix           = $wpdb->prefix;
	$table_name       = $prefix . 'mrs_chart_table';
	$charset_collate  = $wpdb->get_charset_collate();
	$create_table_sql = "CREATE TABLE IF NOT EXISTS {$table_name} ( `id` INT(11) NOT NULL AUTO_INCREMENT , `uv` INT(11) NOT NULL , `pv` INT(11) NOT NULL , `amt` INT(11) NOT NULL , `dateT` DATE NOT NULL , PRIMARY KEY (`id`)) $charset_collate;";

	if ( ! function_exists( 'dbDelta' ) ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	}
	dbDelta( $create_table_sql );

	$insert_query = 'INSERT into ' . $table_name . " (name,uv,pv,amt,dateT) VALUES 
    ('Page A',4000,2000,2400,'2023-03-01'),
    ('Page B',2000,4000,3000,'2023-03-13'),
    ('Page C',6000,3000,2000,'2023-02-6'),
    ('Page D',1000,2000,5000,'2023-03-1'),
    ('Page E',6000,1000,4000,'2023-02-16')
    ";

	$wpdb->query( $insert_query );
}

register_activation_hook( __FILE__, 'activate_react_chart_view' );


if ( ! function_exists( 'run_mrs_view_chart' ) ) {
	/**
	 * Call main class instance.
	 *
	 * @return React_Chart
	 */
	function run_mars_view_chart() {
		require_once VCWR_PATH . 'includes/class-react-chart.php';
		$plugin_initiate = new React_Chart();
		return $plugin_initiate::react_chart_init();
	}
}
run_mars_view_chart();
