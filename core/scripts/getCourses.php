<?php
$school = "EGR";
$subject = "CENG";
$ch = curl_init("http://www.scu.edu/courseavail/search/index.cfm?fuseAction=search&StartRow=1&EndRow=1000&MaxRow=1000&term=3700&acad_career=ugrad&school=".$school."&subject=".$subject."&catalog_num=&instructor_name1=&days1=&start_time1=&start_time2=&header=no&footer=no");
$file = fopen("../storage/courses/" . strtolower($subject) . ".csv", "w");
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

$results = curl_exec($ch);
$dom = new DOMDocument();
$dom->loadHTML($results);

$csvLine = "";
$courses = array();
$stuff = $dom->getElementsByTagName('tr');
foreach($stuff as $row) {
	for($i = 0; $i < 4; $i++) {
		// need this check, returns empty text nodes if left out
		if($row->childNodes->item($i)->hasChildNodes() && trim($row->childNodes->item($i)->nodeValue) != "") {
			$csvLine .= trim(str_replace(",", ".", $row->childNodes->item($i)->nodeValue));
			if($i < 2)
				$csvLine .= ",";
		}
	}
	// create course object, serialize
	echo fwrite($file, $csvLine."\n");
	$csvLine = "";
}
curl_close($ch);
fclose($file);
?>