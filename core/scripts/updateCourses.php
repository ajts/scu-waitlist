<?php
// compare today's date to date courses were last modified
// demo values of now
// fall quarter
// $now = new DateTime("2015-05-23");

// winter quarter
// $now = new DateTime("2015-11-09");

// spring quarter
// $now = new DateTIme("2015-02-15");
$file_path = "../storage/courses/engr.ser";
$fp = fopen($file_path, "r")

// $now = new DateTime();
$modified = new DateTime("@".filemtime($file_path));
$created = new DateTime("@".filectime($file_path));
$diff = $now->diff($modified);
$curr_year = intval($now->format("y"));
$curr_month = intval($now->format('m'));

// month that quarter's classes should appear
$winter_start = 11;
$spring_start = 2;
$fall_start = 5;

// value added to reach year for term value in query
$offset = 21;

// winter term range. 11, 12, 1
if($curr_month >= $winter_start || $curr_month < $spring_start) {
	$quarter = "20";
	if($curr_month == 11 || $curr_month == 12)
		$curr_year += 1;
}
// spring term range. 2, 3, 4
else if($curr_month >= $spring_start && $curr_month < $fall_start)
	$quarter = "40";
// fall term range. 5, 6, 7, 8, 9, 10
else {
	$quarter = "00";
	$curr_year += 1;
}
$year = $curr_year + $offset;

// tests
echo "now: " . $now->format("m/d/y, H:i:s") . "<br/>";
echo "modified: " . $modified->format("m/d/y, H:i:s") . "<br/>";
echo '"created": ' . $created->format("m/d/y, H:i:s") . "<br/>";
echo $diff->h . ":" . $diff->i . ":" . $diff->s . "<br/>";
echo $year.$quarter . "<br/>";

// return;
// If it has been over an hour since the course list was last updated, 
// update the course list
// if($now->diff($modified)->h < 1) { 
// 	echo "Not running query";
// 	return;
// }
// pick term depending on the date.
// Winter: [November, Feburary)
// Spring: [February, May)
// Fall: [May, November) 
$term = $year.$quarter;
$courseArray = array();
$wsdl = 'http://cms01.scu.edu/docs/ws/catalog/project.cfc?wsdl';
$client = new SoapClient($wsdl);

$args = array();
$results = $client->__soapCall('qSchools', $args);
$schools = $results->data;

$schoolid = "EGR";
//echo "$schoolid\n";

$args = array('schoolid' => $schoolid);
// get all subjects (AMTH, COEN, MECH, etc.) associated with a school (Engineering, Business, etc.) 
$results = $client->__soapCall('qSubjects', $args);
$subjects = $results->data;

foreach($subjects as $subject) {
	$subjectid = $subject[0];

	$args = array('subjectid' => $subjectid, 'term' => $term);
	// get all courses associate with a subject
	$results = $client->__soapCall('qCourses', $args);
	$courses = $results->data;
	//print_r($results->columnList);

	foreach ($courses as $course) {
		// only return undergradute courses
		// is there a query associated with this field?
		if($course[0] != "UGRD")
			continue;
		$courseid = $course[5];
		$args = array('courseid' => $courseid, 'term' => $term);
		// get all classes associated with a course for that term
		$results = $client->__soapCall('qCourse', $args);
		$classes = $results->data;
		foreach($classes as $class) {
			$courseArray[$subjectid][$course[3]][] = $class[0];
		}
	}
	$courseArray["quarter"] = $term;
}
print_r($courseArray);
// serialize array and write to file
// $fp = fopen($file_path, "w");
// if(flock($fp, LOCK_EX)) {
// 	set_file_buffer($fp, 0);
// 	fwrite($fp, serialize($courseArray));
// 	flock($fp, LOCK_UN);
// }
// else 
// 	error("could not acquire lock for engr course file");
?>
