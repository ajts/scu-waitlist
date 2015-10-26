<?php 
// A collection of waitlistEntries. Handles reading and writing to files
class Waitlist {
	private $entries;
	private $department;
	
	public function __construct($department, $entries = null) {
		$this->department = $department;
		$this->entries = $entries;
	}
	
	// return information associated with viewing a waitlist
	public function get();
}
?>