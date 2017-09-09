<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPRI_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wpri';
		$this->version = '0.0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WPRI_Loader. Orchestrates the hooks of the plugin.
	 * - WPRI_i18n. Defines internationalization functionality.
	 * - WPRI_Admin. Defines all hooks for the admin area.
	 * - WPRI_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpri-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpri-public.php';

		$this->loader = new WPRI_Loader();


		/**
		 * The class responsible for database functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-database.php';


		/**
		 * The class responsible for defining the projects functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-project.php';


		/**
		 * The class responsible for defining the publications functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-publication.php';


		/**
		 * The class responsible for defining the shortcodes functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-shortcodes.php';

		/**
		 * The class responsible for the template loader
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpri-template-loader.php';

		/**
		 * The class responsible template loading extending the previous one
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-template-loader.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WPRI_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WPRI_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WPRI_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_project = new WPRI_Project( $this->get_plugin_name(), $this->get_version() );
		$plugin_publication = new WPRI_Publication( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_locale_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_title_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_position_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_agency_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_admin, 'settings_member_menu' );



		$this->loader->	add_action( 'admin_menu', $plugin_project, 'project_menu' );
		$this->loader->	add_action( 'admin_menu', $plugin_publication, 'publication_menu' );



		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'save_member_fields' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'save_member_fields' );
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'member_fields' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'member_fields' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WPRI_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		$this->loader->add_filter( 'template_include',$plugin_public, 'faculty_page_template', 99 );
		$this->loader->add_filter( 'template_include',$plugin_public, 'member_page_template', 99 );
		$this->loader->add_filter( 'template_include',$plugin_public, 'project_page_template', 99 );
		$this->loader->add_filter( 'template_include',$plugin_public, 'projects_page_template', 99 );
		$this->loader->add_filter( 'template_include',$plugin_public, 'header_template', 99 );

		$this->wpri_load_templates();

		$plugin_shortcodes = new WPRI_Shortcodes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('init', $plugin_shortcodes, 'shortcodes_init');

	}

	function wpri_load_templates() {

		$template_loader = new WPRI_Template_Loader;

		ob_start();
		$template_loader->get_template_part( 'content', 'header-bte' );
		$template_loader->get_template_part( 'content', 'footer-bte' );
		return ob_get_clean();

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPRI_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
