<?php
  $resp = file_get_contents("https://www.udacity.com/public-api/v0/courses");
  $json_response = json_decode($resp, true);
  $course_list = array("Software Engineering", "Data Science", "Web Development", "Android", "Georgia Tech Masters in CS");
  $course_list_sw = array();
  $course_list_ds = array();
  $course_list_wd = array();
  $course_list_an = array();
  $course_list_ms = array();
  $tracks_dict = array();
  foreach ($json_response["courses"] as $course) {
    $tracks = $course["tracks"];
	foreach ($tracks as $track) {
		if ($track == "Software Engineering") {
			$course_level = "Course Level: ".strtoupper($course["level"]);
			$temp = array();
			array_push($temp, $course["title"], $course["homepage"], $course_level);
			array_push($course_list_sw, $temp);
			$tracks_dict["Software Engineering"] = $course_list_sw;
			unset($temp);
			}
			
		if ($track == "Data Science") {
			$course_level = "Course Level: ".strtoupper($course["level"]);
			$temp = array();
			array_push($temp, $course["title"], $course["homepage"], $course_level);
			array_push($course_list_ds, $temp);
			$tracks_dict["Data Science"] = $course_list_ds;
			unset($temp);
			} 
			
		if ($track == "Web Development") {
			$course_level = "Course Level: ".strtoupper($course["level"]);
			$temp = array();
			array_push($temp, $course["title"], $course["homepage"], $course_level);
			array_push($course_list_wd, $temp);
			$tracks_dict["Web Development"] = $course_list_wd;
			unset($temp);
			}
			
		if ($track == "Android") {
			$course_level = "Course Level: ".strtoupper($course["level"]);
			$temp = array();
			array_push($temp, $course["title"], $course["homepage"], $course_level);
			array_push($course_list_an, $temp);
			$tracks_dict["Android"] = $course_list_an;
			unset($temp);
			}
			
		if ($track == "Georgia Tech Masters in CS") {
			$course_level = "Course Level: ".strtoupper($course["level"]);
			$temp = array();
			array_push($temp, $course["title"], $course["homepage"], $course_level);
			array_push($course_list_ms, $temp);
			$tracks_dict["Georgia Tech Masters in CS"] = $course_list_ms;
			unset($temp);
			}
		}
  }
  echo "<div style='display:none;' id ='udacityCourses'>";//
  foreach ($course_list as $course) {
	$details = $tracks_dict[$course];
	$course1 = str_replace(" ","_",$course);
	echo "<div id ='".$course1."'>";
	echo "<div class='courseName'><h2 class='headerStyle'>Recommended courses</h2></div>";
	echo "<div class='courseList'>";
	$i = 0;
	
	foreach ($details as $detail) {
		echo "<div class='courseSubName'><h3><a target='_blank' href='".$detail[1]."'>",$detail[0], "</h3></a><span>".$detail[2]."</span></div>";
		#foreach ($detail as $course_info) {
		#	echo $course_info, "<br>";
		#	}
		}
	echo "</div>";
	echo "</div>";
	}
  echo "</div>";
?>