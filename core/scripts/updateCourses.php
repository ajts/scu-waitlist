<?php
// run this script hourly(?) to update list of courses
$term = "3700";
$courseArray = array();
$wsdl = 'http://cms01.scu.edu/docs/ws/catalog/project.cfc?wsdl';
$client = new SoapClient($wsdl);

$args = array();
$results = $client->__soapCall('qSchools', $args);
$schools = $results->data;


$schoolid = "EGR";
echo "$schoolid\n";

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
}
// print_r($courseArray);
// serialize array and write to file
$fp = fopen("../storage/courses/engr.ser", "w");
if(flock($fp, LOCK_EX)) {
	set_file_buffer($fp, 0);
	fwrite($fp, serialize($courseArray));
	flock($fp, LOCK_UN);
}
else 
	error("could not acquire lock for engr course file");
?>
