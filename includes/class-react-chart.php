<?php
/**
 * Plugin main class file.
 *
 * @package view-chart-react
 */

/**
 * Plugin Main Class.
 */
class React_Chart {

	/**
	 * Main class constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'react_chart_view_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'react_chart_view_admin_enqueue_scripts' ) );
	}

	/**
	 * Declare singleton instance.
	 *
	 * @return React_Chart
	 */
	public static function react_chart_init() {
		$instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function react_chart_view_init() {
		add_action( 'wp_dashboard_setup', array( $this, 'react_chart_view_dashboard_setup' ) );
		require_once VCWR_PATH . 'includes/class-react-chart-rest-api.php';
	}

	/**
	 * Add dashboard widget.
	 *
	 * @return void
	 */
	public function react_chart_view_dashboard_setup() {
		wp_add_dashboard_widget(
			'react_chart_view',
			__( 'View React Chart', 'view-react-chart' ),
			array( $this, 'react_chart_view_dashboard_widget' )
		);
	}

	/**
	 * Render dashboard widget.
	 *
	 * @return void
	 */
	public function react_chart_view_dashboard_widget() {
		echo '<div id="mrs-dashboard-widget"></div>';
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function react_chart_view_admin_enqueue_scripts() {
		wp_enqueue_script( 'react_chart_view_script', VCWR_URL . 'dist/bundle.js', array( 'jquery', 'wp-element' ), wp_rand(), true );
		wp_localize_script(
			'react_chart_view_script',
			'mrsReactChartView',
			array(
				'apiUrl' => home_url( '/wp-json' ),
				'_nonce' => wp_create_nonce( 'mrs_react_chart_view_rest_api' ),
			)
		);
	}



}
