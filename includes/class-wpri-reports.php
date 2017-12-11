<?php
include_once("xlsxwriter.class.php");

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
			<h2>Annual</h2>

				<h3>Institute</h3>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=0&report=projects&y=17"'> 2017</button></div>
					</div>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=1&y=0&report=projects"'> Projects</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=1&y=0&report=publications"'> Publications</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=1&y=0&report=courses"'> Courses</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=1&y=0&report=students"'> Students</button></div>
					</div>

				<h3>Personal</h3>
					<div class='row'>
					<?php foreach (WPRI_Database::get_all("member") as $member){
						echo "<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = \"../report?personal=1&annual=1&y=17&report=general&id=".$member["id"]."\"'>".$member["name"]."</button></div>";
					}
					?>
					</div>
			<br>
			<h2>Total</h2>

				<h3>Institute</h3>
					<div class='row'>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=0&report=projects"'> Projects</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=0&report=publications"'> Publications</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=0&report=courses"'> Courses</button></div>
					<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = "../report?personal=0&annual=0&report=students"'> Students</button></div>
					</div>

				<h3>Personal</h3>
					<div class='row'>
					<?php foreach (WPRI_Database::get_all("member") as $member){
						echo "<div class='col-xs-12 col-md-6 col-lg-3'><button class='btn btn-primary' style='width:50%;margin-top:10px' onclick='window.location.href = \"../report?personal=1&annual=0&report=general&id=".$member["id"]."\"'>".$member["name"]."</button></div>";
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

	public static function write_project_sheet($personal, $annual, $year, $id){

	    $projects=  WPRI_Database::get_all("project");
	    $title=" ";
	    $status=" ";
	    $agency=" ";
	    $budget=0;
	    $member=" ";
	    $collaborators=" ";

		$rows = array();

	    foreach($projects as $project){
			$add = (!$personal);

	        $start = new DateTime($project["startdate"]);
	        $end = new DateTime($project["enddate"]);

	        if (!$annual || (($start->format('y')<= $year) && ($end->format('y')>= $year))) {
	            $title=$project["official_title"];
	            $status=   WPRI_Database::get_record("status",$project["status"])["status"];
	            $agencies = WPRI_Database::get_relation("project","agency", $project["id"],"");
	            $agency= array();
	            foreach($agencies as $agenci){
	                array_push($agency, WPRI_Database::get_record("agency",$agenci["agency"])["agency"] );
	            }
	            $agency = join(",", $agency);
	            $budget=$project["budget"];

	            $members = WPRI_Database::get_double_relation("project","member", "projectrole", $project["id"],"","");
	            $member= array();
	            foreach($members as $membr){
	                $mem = WPRI_Database::get_record("member",$membr["member"]);
					if ($membr["id"]==$id){
						$add = true;
					}
	                $pr = WPRI_Database::get_record("projectrole",$membr["projectrole"]);
	                array_push($member,$mem["name"]." (".$pr["projectrole"].")");
	            }
	            $member = join(",", $member);

	            $collaborators = WPRI_Database::get_double_relation("project","collaborator", "projectrole", $project["id"],"","");
	            $collaborator= array();
	            foreach($collaborators as $collaborato){
	                $col = WPRI_Database::get_record("collaborator",$collaborato["collaborator"]);
	                $pr = WPRI_Database::get_record("projectrole",$collaborato["projectrole"]);
	                array_push($collaborator,$collaborato["name"]." (".$pr["projectrole"].")");
	            }
	            $collaborator = join(",", $collaborator);
				if ($add){
					$rows[] = array($title,$status,$agency,$budget,$member,$collaborator);
				}

	        }
	    }
		return $rows;
	}

	public static function write_publications_sheet( $personal, $annual, $year, $id){


	   $publications=  WPRI_Database::get_all("publication");
	   $title=" ";
	   $pubtype=" ";
	   $member=" ";
	   $authors=" ";
	   $year=" ";
	   $venue=" ";

	   $rows = array();

	   foreach($publications as $publication){
		   $add = (!$personal);

		   if (!$annual || ($start->format('y')== $year)) {
			   $title=$publication["title"];
			   $authors=$publication["authors"];
  			   $year=$publication["pubdate"];
			   $pubtype=   WPRI_Database::get_record("pubtype",$publication["pubtype"])["pubtype"];

			   $members = WPRI_Database::get_relation("publication","member", $publication["id"],"");
			   $member= array();
			   foreach($members as $membr){
				   $mem = WPRI_Database::get_record("member",$membr["member"]);
				   if ($membr["id"]==$id){
					   $add = true;
				   }
				   array_push($member,$mem["name"]);
			   }
			   $member = join(",", $member);

			   $venue=" ";


			   if ($add){
				   $rows[] = array(	$title,$pubtype,$member,$authors,$year,$venue);
			   }

		   }
	   }
	   return $rows;
	}

	public static function write_students_sheet($personal, $annual, $year, $id){
	}

	public static function write_courses_sheet( $personal, $annual, $year, $id){
	}
}
