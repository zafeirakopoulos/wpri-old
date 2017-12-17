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
		wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );

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
		wp_register_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ));
	  	wp_enqueue_script( 'bootstrap_js' );

		wp_register_script( 'sortable_js', 'http://cdn.jsdelivr.net/npm/sortablejs@1.6.1/Sortable.min.js');
		wp_enqueue_script( 'sortable_js' );

		wp_enqueue_script( 'jquery');

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpri-admin.js', array( 'jquery' ), $this->version, false);
		wp_enqueue_script($this->plugin_name);
		wp_localize_script( $this->plugin_name, "wpri", array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
			'session_url' => site_url()."/session"
			)
		);


	}

	/**
	 * Register custom user fields related to academic capacity.
	 *
	 * @since    1.0.0
	 */
	public function member_fields( $user )
	{
		error_log($user->ID);
	    echo '<h3>Office and Contact</h3>';
		echo '<table class="form-table">';
	 	echo '<tr>';
		echo '<th><label">Office</label></th>';
		echo '<td><textarea id="office" name="office" cols="10" rows="1">'.get_user_meta($user,'office',true).'</textarea>';
		echo '<span class="description">Your office number.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Phone</label></th>';
		echo '<td><textarea id="phone" name="phone" cols="10" rows="1">'.get_user_meta($user,'phone',true).'</textarea>';
		echo '<span class="description">Your phone number</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">Website</label></th>';
		echo '<td><textarea id="website" name="website" cols="10" rows="1">'.get_user_meta($user,'website',true).'</textarea>';
		echo '<span class="description">Your website</span>';
		echo '</td></tr>';

	    echo '</table>';


	    echo '<h3>Academic Profile</h3>';
	    echo '<table class="form-table">';
		echo '<tr>';
		echo '<th><label>Academic Title</label></th>';
		echo '<td>';
		echo '<select name="title">';
			foreach ( WPRI_Database::get_all("title") as $title ) {
				echo '<option value='.$title["id"]. ' ' . ( $title["id"] == get_user_meta($user,'title',true)? 'selected ' : ' ') .'>'.$title["title"].'</option>';
			}
		echo '</select>';
		echo '<span class="description"></span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label>Position</label></th>';
		echo '<td>';
		echo '<select name="position">';
			foreach ( WPRI_Database::get_all("position") as $position ) {
				echo '<option value='.$position["id"]. ' ' . ( $position["id"] == get_user_meta($user,'position',true)? 'selected ' : ' ') .'>'.$position["position"].'</option>';
			}
		echo '</select>';
		echo '<span class="description"></span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label>Advisor</label></th>';
		echo '<td>';
		echo '<select name="advisor">';
			foreach ( WPRI_Database::get_all("member") as $member ) {
				echo '<option value='.$member["id"]. ' ' . ( $member["id"] == get_user_meta($user,'advisor',true)? 'selected ' : ' ') .'>'.$member["name"].'</option>';
			}
		echo '<option value=-1>Other</option>';
		echo '</select>';
		echo '<span class="description"> </span>';
		echo '</td></tr>';
	    echo '</table>';



	    echo '<h3>Education</h3>';

	    echo '<h2>Undergraduate</h2>';
	    echo '<table class="form-table">';
		echo '<th><label">Title</label></th>';
		echo '<td><textarea id="bs_title" name="bs_title" cols="70" rows="1">'. get_user_meta($user,'bs_title',true) .'</textarea>';
		echo '<span class="description">BSc, BA, etc.</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">University</label></th>';
		echo '<td><textarea id="bs_inst" name="bs_uni" cols="70" rows="1">'. get_user_meta($user,'bs_inst',true) .'</textarea>';
		echo '<span class="description">Write uni.</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">Program</label></th>';
		echo '<td><textarea id="bs_inst" name="bs_prog" cols="70" rows="1">'. get_user_meta($user,'bs_prog',true) .'</textarea>';
		echo '<span class="description">Write program.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Year</label></th>';
		echo '<td><textarea id="bs_year" name="bs_year" cols="4" rows="1">'. get_user_meta($user,'bs_year',true) .'</textarea>';
		echo '<span class="description">Graduation year</span>';
		echo '</td></tr>';
	 	echo '<tr>';
	    echo '</table>';


	    echo '<h2>Masters</h2>';
	    echo '<table class="form-table">';
		echo '<th><label">Title</label></th>';
		echo '<td><textarea id="ms_title" name="ms_title" cols="70" rows="1"></textarea>';
		echo '<span class="description">MSc, MBA, etc .</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">University</label></th>';
		echo '<td><textarea id="ms_inst" name="ms_uni" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write uni/dept name.</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">Program</label></th>';
		echo '<td><textarea id="bs_inst" name="ms_prog" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write program.</span>';
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
		echo '<th><label">Title</label></th>';
		echo '<td><textarea id="phd_title" name="phd_title" cols="70" rows="1"></textarea>';
		echo '<span class="description">Dr. or PhD .</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">University</label></th>';
		echo '<td><textarea id="phd_inst" name="phd_uni" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write uni/dept name.</span>';
		echo '</td></tr>';
		echo '<tr>';
		echo '<th><label">Program</label></th>';
		echo '<td><textarea id="bs_inst" name="phd_prog" cols="70" rows="1"></textarea>';
		echo '<span class="description">Write program.</span>';
		echo '</td></tr>';
	 	echo '<tr>';
		echo '<th><label">Year</label></th>';
		echo '<td><textarea id="phd_year" name="phd_year" cols="4" rows="1"></textarea>';
		echo '<span class="description">Graduation year</span>';
		echo '</td></tr>';
	 	echo '<tr>';
	    echo '</table>';
	}

	/**
	 * Save the custom user fields.
	 *
	 * @since    1.0.0
	 */
	public function save_member_fields( $user_id )
	{
	    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }else{

		if(isset($_POST['office']) && $_POST['office'] != ""){
		    update_user_meta( $user_id, 'office', $_POST['office'] );
		}

		if(isset($_POST['phone']) && $_POST['phone'] != ""){
		    update_user_meta( $user_id, 'phone', $_POST['phone'] );
		}

		if(isset($_POST['website']) && $_POST['website'] != ""){
		    update_user_meta( $user_id, 'website', $_POST['website'] );
		}

		if(isset($_POST['title']) && $_POST['title'] != ""){
		    update_user_meta( $user_id, 'title', $_POST['title'] );
		}

		if(isset($_POST['position']) && $_POST['position'] != ""){
		    update_user_meta( $user_id, 'position', $_POST['position'] );
		}

		if(isset($_POST['advisor']) && $_POST['advisor'] != ""){
		    update_user_meta( $user_id, 'advisor', $_POST['advisor'] );
		}

		if(isset($_POST['bs_title']) && $_POST['bs_title'] != ""){
		    update_user_meta( $user_id, 'bs_title', $_POST['bs_title'] );
		}
		if(isset($_POST['bs_uni']) && $_POST['bs_uni'] != ""){
		    update_user_meta( $user_id, 'bs_uni', $_POST['bs_uni'] );
		}
		if(isset($_POST['bs_prog']) && $_POST['bs_prog'] != ""){
			update_user_meta( $user_id, 'bs_prog', $_POST['bs_prog'] );
		}

		if(isset($_POST['bs_year']) && $_POST['bs_year'] != ""){
		    update_user_meta( $user_id, 'bs_year', $_POST['bs_year'] );
		}

		if(isset($_POST['ms_title']) && $_POST['ms_title'] != ""){
		    update_user_meta( $user_id, 'ms_title', $_POST['ms_title'] );
		}
		if(isset($_POST['ms_uni']) && $_POST['ms_uni'] != ""){
		    update_user_meta( $user_id, 'ms_uni', $_POST['ms_uni'] );
		}
		if(isset($_POST['ms_prog']) && $_POST['ms_prog'] != ""){
			update_user_meta( $user_id, 'ms_prog', $_POST['ms_prog'] );
		}
		if(isset($_POST['ms_year']) && $_POST['ms_year'] != ""){
		    update_user_meta( $user_id, 'ms_year', $_POST['ms_year'] );
		}

		if(isset($_POST['phd_title']) && $_POST['phd_title'] != ""){
			update_user_meta( $user_id, 'phd_title', $_POST['phd_title'] );
		}
		if(isset($_POST['phd_uni']) && $_POST['phd_uni'] != ""){
		    update_user_meta( $user_id, 'phd_uni', $_POST['phd_uni'] );
		}
		if(isset($_POST['phd_prog']) && $_POST['phd_prog'] != ""){
			update_user_meta( $user_id, 'phd_prog', $_POST['phd_prog'] );
		}
		if(isset($_POST['phd_year']) && $_POST['phd_year'] != ""){
		    update_user_meta( $user_id, 'phd_year', $_POST['phd_year'] );
		}

		if(isset($_POST['projects[]']) && $_POST['projects[]'] != ""){
		    update_user_meta( $user_id, 'projects[]', $_POST['projects[]'] );
		}
	    }
	}

	/**
	 * Add menu pages
	 *
	 * @since    1.0.0
	 */
	public function settings_menu() {
		function wpri_settings_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Research Institute</h2>';
			echo '<div class="wrap wpa">';

			// If POST for adding
			if( isset( $_POST['type']) && $_POST['type'] == 'add_member') {
				$u_query = new WP_User_Query( array('include' => array($_POST["user"])));
				$user = $u_query->results;
				$new_member_id = WPRI_Database::add_member(array(
					'user' => $_POST["user"],
					'name' => WPRI_Database::get_field("user","user_nicename",$_POST["user"]),
					'role' => $_POST["role"]
				));
				if($new_member_id) {
					echo "<div class='updated'><p><strong>Added.</strong></p></div>";
				} else {
			    	echo "<div class='error'><p>Unable to add.</p></div>";
				}
			}

			// If POST for deleting
			if( isset( $_POST['type']) && $_POST['type'] == 'delete_member' ) {
				$declarations = WPRI_Declarations::get_declarations();

				$result = WPRI_Database::delete_record($_POST['member_id'],$declarations["member"]);
				if($result) {
					echo "<div class='updated'><p><strong>Deleted.</strong></p></div>";
				} else {
			    	echo "<div class='error'><p>Unable to delete.</p></div>";
				}
			}

			echo '<h3> Existing members: </h3>';
			$all_members = WPRI_Database::get_all("member");
			echo '<table>';
		 	foreach ( $all_members as $member ) {
				echo '<form name="delete_member" method="post" action="">';
				echo '<tr>';
				echo '<td><label>' . $member["name"] . '</label></td>';
				// TODO get_member_name (from user)
				echo '<td> <input type="submit" name="delete_button' . $member["id"]  . '" value="Delete" class="button" />';
		    	echo '<input type="hidden" name="type" value="delete_member" />';
		   		echo '<input type="hidden" name="member_id" value=' . $member["id"] . '/></td>';
				echo '</tr>';
				echo '</form>';
		    }
			echo '</table>';


			echo '<h3> Add member </h3>';
			echo '<form name="add_member" method="post" action="">';
			echo '<table class="form-table">';
			$user_query = new WP_User_Query(array( 'role__not_in' => '' ) );
			$users = $user_query->results;
			echo '<tr>';
			echo '<th><label>User</label></th>';
			echo '<td>';
			echo '<select name="user">';
				foreach ( $users as $user ) {
					echo '<option value='.$user->ID.'>'.$user->display_name.'</option>';
				}
			echo '</select>';
			echo '<span class="description">Choose a user.</span>';
			echo '</td></tr>';

			// Change this to access rights (instead of position)
			$roles = WPRI_Database::get_all("role");

			echo '<tr>';
			echo '<th><label>Role</label></th>';
			echo '<td>';
			echo '<select name="role">';
			foreach ( $roles as $role ) {
					echo '<option value='.$role["id"].'>'.$role["role"].'</option>';
				}
			echo '</select>';
			echo '<span class="description">Choose a role.</span>';
			echo '</td></tr>';

			// $positions = WPRI_Database::get_all("position");
			// echo '<tr>';
			// echo '<th><label>Position</label></th>';
			// echo '<td>';
			// echo '<select name="position">';
			// foreach ( $positions as $position ) {
			// 		echo '<option value='.$position["id"].'>'.$position["position"].'</option>';
			// 	}
			// echo '</select>';
			// echo '<span class="description">Choose a role.</span>';
			// echo '</td></tr>';

		    echo '<td><input type="submit" name="add_button" value="Add" class="button-secondary" />';
		    echo '<input type="hidden" name="type" value="add_member" /></td>';
		    echo '</tr>';
			echo '</table>';
			echo '</form>';

			echo '</div>';
			echo '</div>';
		}

		add_menu_page( 'Research Institute Management', 'Research Institute', 'manage_options', 'wpri-settings-menu','wpri_settings_management');
	}


	public function settings_locale_menu() {
		function wpri_settings_locale_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Locale Options</h2>';
			WPRI_Admin::simple_setting_form('locale');
			echo '</div>';
		}
		add_submenu_page( 'wpri-settings-menu','Locale Management','Locales' ,  'manage_options', 'wpri-settings-locale' , 'wpri_settings_locale_management');
	}

	public function settings_institute_info_menu() {
		function wpri_settings_institute_info_management() {
			echo '<div class="wrap">';
			echo '<h2>Institute Info Management</h2>';
			WPRI_Admin::setting_form('institute_info');
			echo '</div>';
		}

		add_submenu_page( 'wpri-settings-menu', 'Institute Info Management','Institute Info' , 'manage_options', 'wpri-settings-institute-info' , 'wpri_settings_institute_info_management');
	}

	public function settings_title_menu() {
		function wpri_settings_title_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Academic Titles</h2>';
			WPRI_Admin::setting_form('title');
			echo '</div>';
		}

		add_submenu_page( 'wpri-settings-menu', 'Academic Titles Management','Academic Titles' , 'manage_options', 'wpri-settings-title' , 'wpri_settings_title_management');
	}


	public function settings_position_menu() {
		function wpri_settings_position_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Positions</h2>';
			WPRI_Admin::setting_form('position');
			echo '</div>';
		}
		add_submenu_page( 'wpri-settings-menu', 'Positions Management','Positions' , 'manage_options', 'wpri-settings-position' , 'wpri_settings_position_management');
	}


	public function settings_agency_menu() {
		function wpri_settings_agency_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Funding Agencies</h2>';
			WPRI_Admin::setting_form('agency');
			echo '</div>';
		}
		add_submenu_page( 'wpri-settings-menu', 'Funding Agencies Management','Funding Agencies' , 'manage_options', 'wpri-settings-agency' , 'wpri_settings_agency_management');
	}

	public function settings_position_requirements_menu() {
		function wpri_settings_position_requirements_management() {
			echo '<div class="wrap">';
			echo '<h2>Manage Positions Requirements</h2>';
			WPRI_Admin::setting_form('position_requirement');
			echo '</div>';
		}
		add_submenu_page( 'wpri-settings-menu', 'Positions Requirements Management','Position Requirements' , 'manage_options', 'wpri-settings-position-requirements' , 'wpri_settings_position_requirements_management');
	}


/**********************************************************
**  Settings pages helper functions
**********************************************************/

	/**
	 * Register a non-translatable field.
	 *
	 * @since    1.0.0
	 */
	public static function simple_setting_form($setting_name) {
	 	$table_name = $GLOBALS['wpdb']->prefix . 'wpri_' . $setting_name ;
		echo '<div class="wrap wpa">';

		// If POST for adding
		if( isset( $_POST['type']) && $_POST['type'] == 'add_' . $setting_name ) {
			$GLOBALS['wpdb']->insert( $table_name , array( $setting_name => $_POST["setting_name"] ) );
			if($GLOBALS['wpdb']->insert_id) {
				?>
		    <div class="updated"><p><strong>Added.</strong></p></div>
		        <?php
			} else {
				?>
		    <div class="error"><p>Unable to add.</p></div>
		    <?php
			}
		}

		// If POST for deleting
		if( isset( $_POST['type']) && $_POST['type'] == 'delete_' . $setting_name ) {
			$result = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare( "DELETE FROM " . $table_name . " WHERE id = %d", $_POST['setting_id'] ) );
			if($result) {
				?>
		    <div class="updated"><p><strong>Deleted.</strong></p></div>
		        <?php
			} else {
				?>
		    <div class="error"><p>Unable to delete.</p></div>
		    <?php
			}
		}


		echo '<h3> Existing ' . $setting_name . ': </h3>';

		echo '<ul>';
		$all_entries = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $table_name );
	 	foreach ( $all_entries as $dbitem ) {
			echo '<form name="delete_$setting_name" method="post" action="">';
			echo '<li><label for="delete_button' . $dbitem->id  . '">' . $dbitem->$setting_name . ': </label>';
			echo ' <input type="submit" name="delete_button' . $dbitem->id  . '" value="Delete" class="button" />';
	    	echo '<input type="hidden" name="type" value="delete_' . $setting_name . '" />';
	   		echo '<li><input type="hidden" name="setting_id" value=' . $dbitem->id . '/></li>';
			echo '</form>';
	    }
		echo '</ul>';


		echo '<form name="add_$setting_name" method="post" action="">';
		echo '<ul>';
		echo '<li><label for="setting_name">New ' . $setting_name . ': </label>';
		echo '<textarea id="setting_name" name="setting_name" cols="60" rows="1"></textarea> ';
	    echo '<input type="submit" name="add_button" value="Add" class="button-secondary" /></li>';
	    echo '<li><input type="hidden" name="type" value="add_' . $setting_name . '" /></li>';
		echo '</ul>';
		echo '</form>';


		echo '</div>';
	}

	/**
	 * Register translatable field.
	 *
	 * @since    1.0.0
	 */
	public static function setting_form($setting_name) {
	 	$table_name = $GLOBALS['wpdb']->prefix . 'wpri_' . $setting_name ;
		$locale_table_name = $GLOBALS['wpdb']->prefix . 'wpri_locale';
		$locales = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $locale_table_name );
		$mixed_table_name = $GLOBALS['wpdb']->prefix . 'wpri_locale_'  . $setting_name ;

		echo '<div class="wrap wpa">';

		// If POST for adding
		if( isset( $_POST['type']) && $_POST['type'] == 'add_' . $setting_name ) {
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => $_POST["setting_name"] ) );
			echo $GLOBALS['wpdb']->insert_id ;
			$new_id = $GLOBALS['wpdb']->insert_id;
			if($GLOBALS['wpdb']->insert_id) {
				?>
		    <div class="updated"><p><strong>Added.</strong></p></div>
		        <?php
			} else {
				?>
		    <div class="error"><p>Unable to add.</p></div>
		    <?php
			}
	 		foreach ( $locales as $locale ) {
				$GLOBALS['wpdb']->insert( $mixed_table_name , array(
					'locale' => $locale->id,
					$setting_name => $new_id,
					'name' => $_POST["setting_name_" . $locale->id],
				));
			}

		}

		// If POST for deleting
		if( isset( $_POST['type']) && $_POST['type'] == 'delete_' . $setting_name ) {
	 		foreach ( $locales as $locale ) {
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
					"DELETE FROM $mixed_table_name WHERE $setting_name = %d", $_POST['setting_id']
				));
			}
			$result = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
				"DELETE FROM " . $table_name . " WHERE id = %d", $_POST['setting_id']
				));
			if($result) {
				?>
		    <div class="updated"><p><strong>Deleted.</strong></p></div>
		        <?php
			} else {
				?>
		    <div class="error"><p>Unable to delete.</p></div>
		    <?php
			}
		}


		echo '<h3> Existing ' . $setting_name . ': </h3>';

		$all_entries = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $table_name );
		echo '<table>';
	 	foreach ( $all_entries as $dbitem ) {
			echo '<form name="delete_$setting_name" method="post" action="">';
			echo '<tr>';
			echo '<td><label>' . $dbitem->name . ': </label></td>';
			echo '<td> <input type="submit" name="delete_button' . $dbitem->id  . '" value="Delete" class="button" />';
	    	echo '<input type="hidden" name="type" value="delete_' . $setting_name . '" />';
	   		echo '<input type="hidden" name="setting_id" value=' . $dbitem->id . '/></td>';
			echo '</tr>';
			echo '</form>';
	    }
		echo '</table>';

		echo '<h3> Add new ' . $setting_name . ' key: </h3>';
		echo '<form name="add_$setting_name" method="post" action="">';
		echo '<table>';
		echo '<tr>';
		echo '<td><label>New ' . $setting_name . ': </label></td>';
		echo '<td><textarea id="setting_name" name="setting_name" cols="60" rows="1"></textarea></td> ';
		echo '</tr>';
	 	foreach ( $locales as $locale ) {
			echo '<tr>';
			echo '<td><label>' . $locale->locale . ': </label></td>';
			echo '<td><textarea id="setting_name_' . $locale->id . '" name="setting_name_' . $locale->id . '" cols="60" rows="1"></textarea></td>';
			echo '</tr>';
		}
	    echo '<tr>';
	    echo '<td><input type="submit" name="add_button" value="Add" class="button-secondary" />';
	    echo '<input type="hidden" name="type" value="add_' . $setting_name . '" /></td>';
	    echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';
	}
}
