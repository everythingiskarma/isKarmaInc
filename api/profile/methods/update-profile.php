<?php 

trait UpdateProfile {

	public function updateProfile() {

		try {
			$stmt = $this->connection->prepare("UPDATE kyc SET firstname = ?,lastname = ?,cc = ?, cn = ?,dc = ?,mobile = ?,gender = ?,dob = ? WHERE uid = ?");
			if (!$stmt) { // failed to prepare statement
				// create error report
			}
			$stmt->bind_param('ssssssiss', $this->firstname, $this->lastname, $this->cc, $this->cn, $this->dc, $this->mobile, $this->gender, $this->dob, $this->sessionUID);
			if (!$stmt) { // failed to bind parameters
				// create error report
			}
			$stmt->execute();
			if (!$stmt) { // failed to execute statement
				// create error report
			}

			$p = 1;
			// prepare statement
			$stmt = $this->connection->prepare("UPDATE 
		address SET `type` = ?, `label` = ?, `address` = ?, `country` = ?, `state` = ?, `city` = ?, `zip` = ? 
		WHERE `uid` = ? AND `priority` = ?");

			if (!$stmt) { // failed to prepare statement
				// create error report
			}
			$stmt->bind_param('isssssssi', $this->type, $this->label, $this->address, $this->country, $this->state, $this->city, $this->zip, $this->sessionUID, $p);
			if (!$stmt) { // failed to bind param
				// create error report
			}
			$stmt->execute();
			if (!$stmt) { // failed to execute statement
				// create error report
			}

		} catch (Exception $e) {
			// create error report
			$this->report[] = array(
				'api' => 'Profile',
				'response' => 'profile-update-failed',
				'result' => false,
				'message' => '<e><b class="icon-error"></b>' . $e->getMessage() . '</e>'
			);
			return false;
		}

		$this->report[] = array(
			'api' => 'Profile',
			'response' => 'profile-updated-successfully',
			'result' => true,
			'message' => '<s><b class="icon-done-all"></b>Your profile has been successfully updated!</s>'
		);
	}
}
?>
