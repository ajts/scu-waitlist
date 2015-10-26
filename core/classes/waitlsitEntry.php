<?php 
// Holds all necessary inputs for a waitlist entry. Handles reading and writing to files.
class WaitlistEntry {
	private $firstName;
	private $lastName;
	private $email;
	private $reason;
	private $department;
	private $course;
	private $section;
	
	// creates a WaitlistEntry object. All parameters should be strings.
	// $firstName: first name of student
	// $lastName: last of student
	// $email: email of student
	// $reason: reason student wishes to be placed on waitlist
	// $department: four letter abbreviation of departments (computer engineering -> COEN, coen)
	// $course: two-three digit number for the course (12, 20, 174, etc.)
	// $section: five digit number designating a section number for a course
	public function __construct($firstName, $lastName, $email, $reason, $department, $course, $section) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->reason = $reason;
		$this->department = $department;
		$this->course = $course;
		$this->section = $section;
	}
	
	// Saves an entry to the appropiate file 
	public function save() {
		$file_path = "../storage/". $this->department . ".csv";
		$fp = fopen($file_path, 'a');
		// lock file for write
		if(flock($fp, LOCK_EX)) {
			// write entire line before releasing lock
			set_file_buffer($fp, 0);
			fwrite($fp, $this->toCsv());
			flock($fp, LOCK_UN);
		}
		else
			error_log("could not obtain lock for " . $this->department . " file.");
		fclose($fp);
	}
	
	// Returns a valid row for a csv file with the following headers:
	// department course, section, firstName lastName, email, reason
	// ex: COEN 174, 12345, John Doe, john@scu.edu, need for graduation
	private function toCsv() {
		return $this->department . " " . $this->course . "," . 
			$this->section . "," . 
			$this->firstName . " " . $this->lastName . "," .
			$this->email . "," .
			$this->reason . ",\n";
	}
}
?>