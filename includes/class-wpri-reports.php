<?php

/**
 * Declarations of entities and relations.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * FDeclarations of entities and relations.
 *
 * FDeclarations of entities and relations.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Report {


	public static function wpri_reports() {
		$callback = function() {
			?>
			<br>
			<h1>Reports</h1>
			<br>
			<h2>annual</h2>

				<h3>Institute</h3>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=0&report=projects&year=19"'> 2017</button></div>
					</div>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=1&year=17&report=projects"'> Projects</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=1&year=17&report=publications"'> Publications</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=1&year=17&report=courses"'> Courses</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=1&year=17&report=students"'> Students</button></div>
					</div>

				<h3>Personal</h3>
					<div class='row'>
					<?php foreach (WPRI_Database::get_all("member") as $member){
						echo "<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = \"../report?type=personal&annual=1&year=17&report=general&id=".$member["id"]."\"'>".$member["name"]."</button></div>";
					}
					?>
					</div>
			<br>
			<h2>Total</h2>

				<h3>Institute</h3>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=0&report=projects"'> Projects</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=0&report=publications"'> Publications</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=0&report=courses"'> Courses</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?type=institute&annual=0&report=students"'> Students</button></div>
					</div>

				<h3>Personal</h3>
					<div class='row'>
					<?php foreach (WPRI_Database::get_all("member") as $member){
						echo "<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = \"../report?type=personal&annual=0&report=projects&id=".$member["id"]."\"'>".$member["name"]."</button></div>";
					}
					?>
					</div>
			<br>
			<h2>Other</h2>
				<div class='row'>
				<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?report=special"'> Special report</button></div>
				</div>

			<?php };
		add_menu_page( "Reports Management", "Reports", "manage_options", "wpri-reports-menu",$callback);
	}


	public  function download_report_page_template( $template ) {

		if ( is_page("report") ) {
			$template = dirname( __FILE__ ) . '/report.php';
		}
		return $template;
	}
}
