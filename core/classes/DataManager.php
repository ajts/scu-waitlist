<?php 
class DataManager implements SplObserver {
	private $department;
	
	public function save($department) {
		$file_path = "../storage/". $department . ".csv";
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
	
	public function getData($department) {
		$file_path = "../storage/waitlists/".$department . ".csv";
		$fp = fopen($file_path, "r");
		// lock file for reading
		if(flock($fp, LOCK_SH)) {
			// write entire line before releasing lock
			set_file_buffer($fp, 0);
			$data = file_get_contents($fp);
			flock($fp, LOCK_UN);
		}
		else
			error_log("could not obtain lock for " . $this->department . " file.");
		fclose($fp);
		return $data;
	}
}
?>