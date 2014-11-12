<?php
  $resp = file_get_contents("https://api.coursera.org/api/catalog.v1/courses?fields=targetAudience,video,language&includes=categories");
  $json_response = json_decode($resp, true);
  $course_list = $json_response["elements"];
  $track_list = array("Software Engineering", "Artificial Intelligence", "Theory", "Systems and Security");
  $track_dict = [1 => "Theory", 11 => "Systems and Security", 12 => "Software Engineering", 17 => "Artificial Intelligence"];
  $course_level_dict = [0 => "BEGINNER", 1 => "INTERMEDIATE", 2 => "ADVANCED", 3 => "ADVANCED"];
  $course_list_sw = array();
  $course_list_th = array();
  $course_list_ss = array();
  $course_list_ai = array();
  $tracks_dict = array();

  foreach ($course_list as $course) {
	if ($course["language"] != "en") {
		continue;
		}
		
	$links = $course["links"];
	
	if (!($links)) {
		continue;
		}
		
	if (!($links["categories"])) {
		continue;
		}
	
	$category_list = $links["categories"];
	
	if (in_array(1, $category_list, true)) {
		if (!(array_key_exists('targetAudience', $course))) {
			$course_level = "Course Level: ".$course_level_dict[0];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_th, $course_title, $course_link, $course_level);
			$tracks_dict["Theory"] = $course_list_th;
			}
			
		else {
			$course_level = "Course Level: ".$course_level_dict[$course["targetAudience"]];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_th, $course_title, $course_link, $course_level);
			$tracks_dict["Theory"] = $course_list_th;
			}
			
		}
		
	if (in_array(11, $category_list, true)) {
		if (!(array_key_exists('targetAudience', $course))) {
			$course_level = "Course Level: ".$course_level_dict[0];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_ss, $course_title, $course_link, $course_level);
			$tracks_dict["Systems and Security"] = $course_list_ss;
			}
			
		else {
			$course_level = "Course Level: ".$course_level_dict[$course["targetAudience"]];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_ss, $course_title, $course_link, $course_level);
			$tracks_dict["Systems and Security"] = $course_list_ss;
			}
			
		}
		
	if (in_array(12, $category_list, true)) {
		if (!(array_key_exists('targetAudience', $course))) {
			$course_level = "Course Level: ".$course_level_dict[0];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_sw, $course_title, $course_link, $course_level);
			$tracks_dict["Software Engineering"] = $course_list_sw;
			}
			
		else {
			$course_level = "Course Level: ".$course_level_dict[$course["targetAudience"]];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_sw, $course_title, $course_link, $course_level);
			$tracks_dict["Software Engineering"] = $course_list_sw;
			}
			
		}
		
	if (in_array(17, $category_list, true)) {
		if (!(array_key_exists('targetAudience', $course))) {
			$course_level = "Course Level: ".$course_level_dict[0];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_ai, $course_title, $course_link, $course_level);
			$tracks_dict["Artificial Intelligence"] = $course_list_ai;
			}
			
		else {
			$course_level = "Course Level: ".$course_level_dict[$course["targetAudience"]];
			$course_title = $course["name"];
			$course_link = "https://www.youtube.com/watch?v=".$course["video"];
			array_push($course_list_ai, $course_title, $course_link, $course_level);
			$tracks_dict["Artificial Intelligence"] = $course_list_ai;
			}
			
		}
	}
		
	foreach ($track_list as $track) {
	$details = $tracks_dict[$track];
	echo "======================<br>";
	echo $track, "<br>";
	echo "======================<br>";
	echo "<br>";
	$i = 0;
	foreach ($details as $detail) {
		echo $detail, "<br>";
		$i = $i + 1;
		if ($i%3 == 0) {
			echo "<br>";
		}
		}
	echo "<br>";
	}
?>