<?php 
// A collection of waitlistEntries. Handles reading and writing to files
class Waitlist {
	private $department;
	private $dataManager;
	
	public function __construct($department, $entries = null) {
		$this->department = $department;
		$this->dataManager = new DataManager();
	}
	
	// return information associated with viewing a waitlist
	public function get() {
		$this->dataManager->getData($this->department);
	}
}
?>