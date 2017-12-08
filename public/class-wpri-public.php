<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wpri
 * @subpackage wpri/public
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 wp_register_style('jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
 	     wp_enqueue_style( 'jquery-ui' );
		 wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
		 wp_enqueue_style( 'wpri', plugin_dir_url( __FILE__ ) . 'css/wpri-public.css' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */



		 wp_register_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ));
		 wp_enqueue_script( 'bootstrap_js' );

 	 	wp_register_script( 'sortable_js', 'http://cdn.jsdelivr.net/npm/sortablejs@1.6.1/Sortable.min.js');
		wp_enqueue_script( 'sortable_js' );

		wp_enqueue_script( 'jquery');

		// wp_localize_script( $this->plugin_name, 'wpri_ajax', array(
		// 	'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
		// 	'session_url' => site_url()."/session"
		// 	)
		// );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpri-public.js', array( 'jquery' ));
		wp_enqueue_script($this->plugin_name);
		wp_localize_script( $this->plugin_name, "wpri", array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
			'session_url' => site_url()."/session"
			)
		);



	}


	public function page_template( $template ) {

		if ( is_page() ) {
			$template = dirname( __FILE__ ) . '/templates/page.php';
		}
	    return $template;
	}
	public function front_page_template( $template ) {

		if ( is_front_page() ) {
			$template = dirname( __FILE__ ) . '/templates/front-page.php';
		}
	    return $template;
	}

	public function single_template( $template ) {

		if ( is_single() ) {
			$template = dirname( __FILE__ ) . '/templates/page.php';
		}
	    return $template;
	}

	public function session_page_template( $template ) {

		if ( is_page("session") ) {
			$template = dirname( __FILE__ ) . '/templates/wpri-session.php';
		}
	    return $template;
	}



	public function WPRIStartSession() {
		if(!session_id()) {
			session_start();
		}
	}

	public function WPRIEndSession() {
		session_destroy ();
	}


}
