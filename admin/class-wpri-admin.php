<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wpri
 * @subpackage wpri/admin
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpri-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpri-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function member_fields( $user ) 
	{ 

	    echo '<h3>Office</h3>';

	    echo '<h3>Academic Profile</h3>';

	    echo '<table class="form-table">';

		$title_table_name = $GLOBALS['wpdb']->prefix . "wpri_title" ;
		$titles = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $title_table_name );

		echo '<tr>';
		echo '<th><label>Academic Title</label></th>';
		echo '<td>';
		echo '<select name="title">';
			foreach ( $titles as $title ) {
				echo '<option value='.$title->id. ' ' . ( $title->id == get_usermeta($user,'title')? 'selected ' : ' ') .'>'.$title->name.'</option>';
			}
		echo '</select>';
		echo '<span class="description"></span>';
		echo '</td></tr>';



		$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
		$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );

		echo '<tr>';
		echo '<th><label>Advisor</label></th>';
		echo '<td>';
		echo '<select name="advisor">';
			foreach ( $members as $member ) {
				echo '<option value='.$member->id. ' ' . ( $member->id == get_usermeta($user,'advisor')? 'selected ' : ' ') .'>'.$member->username.'</option>';
			}
		echo '</select>';
		echo '<span class="description"> </span>';
		echo '</td></tr>';
	    
	    echo '</table>';


	    echo '<h3>Projects</h3>';

	    echo '<table class="form-table">';


	 	$project_table_name = $GLOBALS['wpdb']->prefix . "wpri_project" ;
		$projects = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $project_table_name );

		echo '<tr>';
		echo '<th><label">Projects</label></th>';
		echo '<td><select size="4" multiple="multiple" name="projects[]">';
			foreach ( $projects as $project ) {
			echo '<option value='.$project->id. ' ' . ( $project->id == get_usermeta($user,'project')? 'selected ' : ' ') .'>'.$project->title.'</option>';
			}
		echo '</select>';
		echo '<span class="description">Choose projects you participate.</span>';
		echo '</td></tr>';

	    echo '</table>';


	    echo '<h3>Education</h3>';

	    echo '<h2>Undergraduate</h2>';
	    echo '<table class="form-table">';
	 	echo '<tr>';
		echo '<th><label">Institution</label></th>';
		echo '<td><textarea id="bs_inst" name="bs_inst" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write uni/dept name.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Year</label></th>';
		echo '<td><textarea id="bs_year" name="bs_year" cols="4" rows="1"></textarea>';
		echo '<span class="description">Graduation year</span>';
		echo '</td></tr>';
	 	echo '<tr>';
	    echo '</table>';


	    echo '<h2>Masters</h2>';
	    echo '<table class="form-table">';
	 	echo '<tr>';
		echo '<th><label">Institution</label></th>';
		echo '<td><textarea id="ms_inst" name="ms_inst" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write uni/dept name.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Year</label></th>';
		echo '<td><textarea id="ms_year" name="ms_year" cols="4" rows="1"></textarea>';
		echo '<span class="description">Graduation year</span>';
		echo '</td></tr>';
	 	echo '<tr>';
	    echo '</table>';


	    echo '<h2>PhD</h2>';
	    echo '<table class="form-table">';
	 	echo '<tr>';
		echo '<th><label">Institution</label></th>';
		echo '<td><textarea id="phd_inst" name="phd_inst" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write uni/dept name.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Year</label></th>';
		echo '<td><textarea id="phd_year" name="phd_year" cols="4" rows="1"></textarea>';
		echo '<span class="description">Graduation year</span>';
		echo '</td></tr>';
	 	echo '<tr>';
	    echo '</table>';
	}


	public function save_member_fields( $user_id ) 
	{
	    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }else{

		if(isset($_POST['title']) && $_POST['title'] != ""){
		    update_usermeta( $user_id, 'title', $_POST['title'] );
		}

		if(isset($_POST['advisor']) && $_POST['advisor'] != ""){
		    update_usermeta( $user_id, 'advisor', $_POST['advisor'] );
		}

		if(isset($_POST['bs_inst']) && $_POST['bs_inst'] != ""){
		    update_usermeta( $user_id, 'bs_inst', $_POST['bs_inst'] );
		}

		if(isset($_POST['bs_year']) && $_POST['bs_year'] != ""){
		    update_usermeta( $user_id, 'bs_year', $_POST['bs_year'] );
		}

		if(isset($_POST['ms_inst']) && $_POST['ms_inst'] != ""){
		    update_usermeta( $user_id, 'ms_inst', $_POST['ms_inst'] );
		}

		if(isset($_POST['ms_year']) && $_POST['ms_year'] != ""){
		    update_usermeta( $user_id, 'ms_year', $_POST['ms_year'] );
		}
		if(isset($_POST['phd_inst']) && $_POST['phd_inst'] != ""){
		    update_usermeta( $user_id, 'phd_inst', $_POST['phd_inst'] );
		}

		if(isset($_POST['phd_year']) && $_POST['phd_year'] != ""){
		    update_usermeta( $user_id, 'phd_year', $_POST['phd_year'] );
		}

		if(isset($_POST['projects[]']) && $_POST['projects[]'] != ""){
		    update_usermeta( $user_id, 'projects[]', $_POST['projects[]'] );
		}
	    }
	}


}
