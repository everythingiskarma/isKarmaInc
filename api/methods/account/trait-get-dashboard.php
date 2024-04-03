<?php

trait GetDashboard
{

	// method to get full dashboard from all tables
	public function getFullDashboard()
	{
		$this->onBoard = false;
		$this->onBoardingStep = 'step1';
		$this->uid = $_SESSION['uid'];
		// check database for onboarding details
		$stmt = $this->connection->prepare("SELECT * FROM kyc WHERE uid = ?");
		if (!$stmt) { // failed to prepare statement
			// create error report
		}
		// bind parameters
		$stmt->bind_param("s", $this->uid);
		if (!$stmt) { // failed to bind parameters
			// create error report
		}
		// execute query
		$stmt->execute();
		if (!$stmt) { // failed to execute query
			// create error report
		}
		$result = $stmt->get_result();
		if (!$result) { // failed to get result
			// create error report
		}
		if ($result->num_rows > 0) {
			// found uid in user table, continue to check data
			$row = $result->fetch_assoc();
			if (!$row) { // failed to fetch row
				// create error report
			}
			// Retrieve user information
			$fn = $row['firstname'];
			$ln = $row['lastname'];
			$cc = $row['cc']; // get country code
			$cn = $row['cn']; // get country name
			$dc = $row['dc']; // get dial code
			$mo = $row['mobile']; // get mobile number

			// Check if all required fields are filled
			if (!empty($fn) && !empty($ln) && !empty($cc) && !empty($cn) && !empty($dc) && !empty($mobile)) {
				// All required fields are filled

				// Proceed to check step 2 info
				$gen = $row['gender'];
				$dob = $row['dob'];

				// Close result set and statement
				$result->close();
				$stmt->close();

				if(!emptry($gen) && !emptry($dob)) {
					// step 2 complete, proceed to step 3 (check address information)
					$p = 1;
					$stmt = $this->connection->prepare("SELECT * FROM address WHERE uid = ? AND primary = ?");
					if(!$stmt) { // failed to prepare query
						// create error report
					}
					$stmt->bind_param('si', $this->uid, $p);
					if(!$stmt) { // failed to bind params
						// create error report
					}
					$stmt->execute();
					if(!$stmt) { // failed to execute statement
						// create error report
					}
					$result->$stmt->get_results();
					if(!$result) { // failed to get results
						// create error report
					}
					if($result->num_rows > 0) {
						// found at least 1 uid entry in address table, proceed to get primary address
						$row = $results->fetch_assoc();
						if(!row) { // failed to fetch row
							// create error report
						} else {
							// found a primary address, continue to fetch address details
							$type = $row['type']; // address type home/office/other
							$label = $row['label']; // nickname to identify individual addresses
							$address = $row['address']; // full street address
							$country = $row['country']; // country of the address
							$state = $row['state']; // state of the address
							$city = $row['city']; // city of the address
							$zip = $row['zip']; // zip code of the address

							
							if(!empty($type) && !empty($label) && !empty($address) && !empty($country) && !empty($state) && !empty($city) && !empty($zip)) {
								// all fields have values, continue to load full dashboard
								// create success report
								$this->report[] = array(
									'api' => 'account',
									'action' => 'dashboard',
									'result' => true,
									'message' => '',
									'dashboard' => true,
									'fn' => $fn,
									'ln' => $ln,
									'cc' => $cc,
									'cn' => $cn,
									'dc' => $dc,
									'mo' => $mo,
									'gen' => $gen,
									'dob' => $dob,
									'type' => $type,
									'label' => $label,
									'address' => $address,
									'country' => $country,
									'state' => $state,
									'city' => $city,
									'zip' => $zip
								);

							} else {
								// Some required fields are empty

								// create success report
								$this->report[] = array(
									'api' => 'account',
									'action' => 'dashboard',
									'result' => true,
									'message' => '',
									'step' => 'step3',
									'fn' => $fn,
									'ln' => $ln,
									'cc' => $cc,
									'cn' => $cn,
									'dc' => $dc,
									'mo' => $mo,
									'gen' => $gen,
									'dob' => $dob,
									'type' => $type,
									'label' => $label,
									'address' => $address,
									'country' => $country,
									'state' => $state,
									'city' => $city,
									'zip' => $zip
								);
								// Set onboarding step to step 3
								$this->onBoardingStep = 'step3';
							}


						}

					} else { // uid entry doesn't exist in address table
						// create error report
					}

				} else {
					// Some required fields are empty
					// Set onboarding step to step 2
					$this->onBoardingStep = 'step2';
					// create success report
					$this->report[] = array(
						'api' => 'account',
						'action' => 'dashboard',
						'result' => true,
						'message' => '',
						'dashboard' => true,
						'fn' => $fn,
						'ln' => $ln,
						'cc' => $cc,
						'cn' => $cn,
						'dc' => $dc,
						'mo' => $mo,
						'gen' => $gen,
						'dob' => $dob,
						'type' => $type,
						'label' => $label,
						'address' => $address,
						'country' => $country,
						'state' => $state,
						'city' => $city,
						'zip' => $zip
					);


				}
				
			} else {
				// create success report
				$this->report[] = array(
					'api' => 'account',
					'action' => 'dashboard',
					'result' => true,
					'message' => '',
					'step' => 'step3',
					'fn' => $fn,
					'ln' => $ln,
					'cc' => $cc,
					'cn' => $cn,
					'dc' => $dc,
					'mo' => $mo,
					'gen' => $gen,
					'dob' => $dob,
					'type' => $type,
					'label' => $label,
					'address' => $address,
					'country' => $country,
					'state' => $state,
					'city' => $city,
					'zip' => $zip
				);
				// Some required fields are empty
				// Set onboarding step to step 1
				$this->onBoardingStep = 'step1';
			}
		} else {
			// uid does not exist in user table.
			// create error report
		}

		if ($this->onBoard === false) {
			// onboarding is not complete
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'dashboard',
				'result' => false,
				'message' => '<in><b class="icon-info"></b>Onboarding pending!</in>',
				'resolution' => 'complete-onboarding',
				'onBoarding' => true,
				'step' => $this->onBoardingStep
			);
			return false;
		} else {
			// onboarding completed show dashboard
			// create success report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'dashboard',
				'result' => true,
				//'message' => '<s><b class="icon-done-all"></b>Onboarding completed!</s>',
				'advice' => 'onboarding completed',
				'gotFullDashboard' => ''
			);
			return false;
		}
	} // end method getDashboard();

	public function onBoardStep1() {

	}

} // end trait GetDashboard
