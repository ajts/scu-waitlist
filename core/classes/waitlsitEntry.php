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
	private $dataManager;
	
	// creates a WaitlistEntry object. All parameters should be strings.
	// $firstName: first name of student
	// $lastName: last of student
	// $email: email of student
	// $reason: reason student wishes to be placed on waitlist
	// $department: four letter abbreviation of departments (computer engineering -> COEN, coen)
	// $course: four letter abbreviation of department with two-three digit number for the course (COEN 12, COEN 20, COEN 174, etc.)
	// $section: five digit number designating a section number for a course
	public function __construct($firstName, $lastName, $email, $reason, $department, $course, $section) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->reason = $reason;
		$this->department = $department;
		$this->course = $course;
		$this->section = $section;
		$this->dataManager = new DataManager($department);
		
	}
	
	// Saves an entry to the appropiate file 
	public function save() {
		$this->dataManager->save($this->department);
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