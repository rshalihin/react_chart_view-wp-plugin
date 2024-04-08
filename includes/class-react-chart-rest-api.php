<?php
/**
 * Handles for REST operations.
 *
 * @package view-chart-react
 */

/**
 * REST API handler class.
 */
class React_Chart_Rest_API {

	/**
	 * Run the class.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'mrs_react_chart_rest_api_render' ) );
	}

	/**
	 * REST API render.
	 */
	public function mrs_react_chart_rest_api_render() {

		register_rest_route(
			'mrsrc/v1',
			'/info/',
			array(
				array(
					'method'              => 'GET',
					'callback'            => array( $this, 'get_react_chart_rest_api_info' ),
					'permission_callback' => array( $this, 'get_react_chart_rest_api_permissions' ),
				),
			)
		);

		register_rest_route(
			'mrsrc/v1',
			'/last-n-days/(?P<days>\d+)/',
			array(
				array(
					'method'              => 'GET',
					'callback'            => array( $this, 'get_react_chart_rest_api_last_n_days_data' ),
					'permission_callback' => array( $this, 'get_react_chart_rest_api_n_days_data_permissions' ),
				),
			)
		);
	}

	/**
	 * Check permissions
	 *
	 * @return bool
	 */
	public function get_react_chart_rest_api_permissions() {
		return true;
	}

	/**
	 * Get data from database and return array as json.
	 *
	 * @return array
	 */
	public function get_react_chart_rest_api_info() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mrs_chart_table';
		$sql        = "SELECT * FROM $table_name";
		$results    = $wpdb->get_results( $wpdb->prepare( $sql ), ARRAY_A );
		return $results;
	}

	/**
	 * Check permissions
	 *
	 * @return bool
	 */
	public function get_react_chart_rest_api_n_days_data_permissions() {
		return true;
	}

	/**
     * Get data from database and return array as json.
     *
     * @return array
     */
	public function get_react_chart_rest_api_last_n_days_data( $request ) {
		$days = $request['days'];
		return $this->get_react_chart_rest_api_data( $days );
	}

	/**
     * Get data from database and return array as json.
     *
     * @return array
     */
	public function get_react_chart_rest_api_data( $days ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mrs_chart_table';
		$query        = "SELECT * FROM $table_name WHERE dateT >= DATE_SUB( NOW(), INTERVAL $days DAY )";
		$results    = $wpdb->get_results( $wpdb->prepare( $query ), ARRAY_A );
		return $results;
	}
}

new React_Chart_Rest_API();
