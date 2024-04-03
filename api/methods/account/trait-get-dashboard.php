<?php

trait GetDashboard {

	// method to get dashboard
	public function getDashboard() {

		$this->onBoard = false;

		$this->uid = $_SESSION['uid'];
		// check database for onboarding details
		$stmt = $this->connection->prepare("SELECT * FROM kyc WHERE uid = ?");
		if(!$stmt) { // failed to prepare statement
			// create error report
		}
		// bind parameters
		$stmt->bind_param("s", $this->uid);
		if(!$stmt) { // failed to bind parameters
			// create error report
		}
		// execute query
		$stmt->execute();
		if(!$stmt) { // failed to execute query
			// create error report
		}
		$result = $stmt->get_result();
		if(!$result) { // failed to get result
			// create error report
		}
		if($result->num_rows > 0) {
			// found uid in user table, continue to check data
			$row = $result->fetch_assoc();
			if(!$row) { // failed to fetch row
				// create error report
			}

		} else {
			// uid does not exist in user table.
			// create error report
		}

		$this->onBoardingStep = 'step1';
	}

}

?>