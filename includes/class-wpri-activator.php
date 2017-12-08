<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		# Create the standard pages for wpri.
		WPRI_Pages::create_pages();

		# Create the tables for wpri.
        $first_install = WPRI_Database::create_tables();
        if ($first_install == 1) {
			# If the tables are fresh, populate them with standard data.
            WPRI_Database::populate_tables();
        }

        flush_rewrite_rules();

	}

}
