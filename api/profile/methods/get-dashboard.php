<?php

trait GetDashboard
{

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// METHOD getFullDashboard(); // method to get full dashboard with all fields from all tables
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getFullDashboard()
	{
		// if all fields are filled, continue to load full dashboard		
		$this->onBoard = true;
		$this->getDashboardfields();
		// check onboarding step 3 if all requried fields are filled
		if (empty($this->type) || empty($this->label) || empty($this->address) || empty($this->country) || empty($this->state) || empty($this->city) || empty($this->zip)) {
			// atleast one of the required fields is empty in onboarding step 3
			$this->onBoardingStep = 'step3'; // tells jquery to load step3 of onboarding
			$this->onBoard = false; // indicates onboarding is pending
			$msg = 'Final step! Please fill in your address to launch your account dashboard.'; // adds msg to api report
		} // end if step 3
		// check onboarding step 2 if all required fields are filled
		if (empty($this->gender) || empty($this->dob)) {
			// atleast one of the required fields is empty in onboarding step 2
			$this->onBoardingStep = 'step2'; // tells jquery to load step 2 of onboarding
			$this->onBoard = false; // indicates onboarding is pending
			$msg = 'Almost done! One more step to go after this! '; // adds msg to api report
		} // end if step 2
		// Check onboarding step 1 if all required fields are filled
		if (empty($this->firstname) || empty($this->lastname) || empty($this->cc) || empty($this->cn) || empty($this->dc) || empty($this->mobile)) {
			// atleast one of the required fields is empty in onboarding step 1
			$this->onBoardingStep = 'step1'; // tell jquery to load step 1 of onboarding
			$this->onBoard = false; // indicates onboarding is pending
			$msg = 'Lets get you onboarded! Enter the required information while we prepare your account dashboard!'; // adds msg to api report
		} // end if step 1
		if ($this->onBoard === false) {
			// onboarding is not complete
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'dashboard',
				'result' => false,
				'message' => '<in><b class="icon-info"></b>' . $msg . '</in>',
				'resolution' => 'complete-onboarding',
				'onBoarding' => true, // tells jquery to load onboarding
				'step' => $this->onBoardingStep, // tells jquery which step of onboarding to show
				'fields' => $this->dashboardFields // sends an array containing all dashboard fields as key:value pairs
				// add additional data as arrays as required
			);
			return;
		} else {
			// onboarding completed show full dashboard
			// create success report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'dashboard',
				'result' => true,
				'message' => '<s><b class="icon-done-all"></b>Dashboard loaded successfully</s>',
				'dashboard' => true, // tells jquery to load full dashboard
				'fields' => $this->dashboardFields // sends an array containing all dashboard fields as key:value pairs
			);
			return;
		}
	} // end method getFullDashboard();

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// METHOD getDashboardFields(); // method to get an array of all dashboard fields from all tables
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getDashboardFields() {
		//--------------------------------------## ---------------- ##---------------------------------------//
		//--------------------------------------## KYC TABLE FIELDS ##---------------------------------------//
		//--------------------------------------## ---------------- ##---------------------------------------//
		// check kyc table in database for onboarding details
		$stmt = $this->connection->prepare("SELECT * FROM kyc WHERE uid = ?");
		if (!$stmt) { // failed to prepare statement
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > prepare-statement',
				'message' => '<e><b class="icon-error"></b>Failed to prepare statement</e>'
			);
			return false;
		}
		// bind parameters
		$stmt->bind_param("s", $this->sessionUID);
		if (!$stmt) { // failed to bind parameters
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > bind-parameters',
				'message' => '<e><b class="icon-error"></b>Failed to bind parameters</e>'
			);
			return false;
		}
		// execute query
		$stmt->execute();
		if (!$stmt) { // failed to execute query
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > execute-query',
				'message' => '<e><b class="icon-error"></b>Failed to execute query</e>'
			);
			return false;
		}
		$result = $stmt->get_result();
		if (!$result) { // failed to get result
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > get-query-results',
				'message' => '<e><b class="icon-error"></b>Failed to get query result</e>'
			);
			return false;
		}
		if (!$result->num_rows > 0) { // failed to find row in user table
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > find-row-in-user-table',
				'message' => '<e><b class="icon-error"></b>Failed to find row in user table</e>'
			);
			return false;
		}
		$row = $result->fetch_assoc();
		if (!$row) { // failed to fetch row
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > fetch-row-from-results',
				'message' => '<e><b class="icon-error"></b>Failed to fetch row from result</e>'
			);
			return false;
		}
		
		try {

			// Retrieve user information
			$this->email_alt = $row['email_alt']; // get alternate email address
			$this->firstname = $row['firstname']; // get firstname
			$this->lastname = $row['lastname']; // get lastname
			$this->cc = $row['cc']; // get country code
			$this->cn = $row['cn']; // get country name
			$this->dc = $row['dc']; // get dial code
			$this->mobile = $row['mobile']; // get mobile number
			$this->gender = $row['gender']; // get gender
			$this->dob = $row['dob']; // get date of birth
			$this->id_type = $row['id_type']; // get users kyc id type
			$this->id_image = $row['id_image']; // get uploaded image path to users id photo
			$this->id_address_proof = $row['id_address_proof']; // get users address id proof type
			$this->id_address_proof_image = $row['id_address_proof_image']; // get uploaded image path to users address proof photo
			$this->id_kyc_status = $row['id_kyc_status']; // get users id kyc status

		} catch (Exception $e) {
			// some fields were not fetched
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-kyc > fetch-fields',
				'message' => '<e><b class="icon-error"></b>' . $e->getMessage() . '</e>'
			);
		}

		// Close result set and statement
		$result->close();
		$stmt->close();


		//--------------------------------------## -------------------- ##---------------------------------------//
		//--------------------------------------## ADDRESS TABLE FIELDS ##---------------------------------------//
		//--------------------------------------## -------------------- ##---------------------------------------//

		$p = 1; // only check for priority address entry for the user
		$stmt = $this->connection->prepare("SELECT * FROM `address` WHERE `uid` = ? AND `priority` = ?");
		if (!$stmt) { // failed to prepare query
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > prepare-statement',
				'message' => '<e><b class="icon-error"></b>Failed to prepare statement</e>'
			);
			return false;
		}

		$stmt->bind_param('si', $this->sessionUID, $p);
		if (!$stmt) { // failed to bind params
			// create error report
			$this->reportaccount[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > bind-parameters',
				'message' => '<e><b class="icon-error"></b>Failed to bind parameters</e>'
			);
			return false;
		}

		$stmt->execute();
		if (!$stmt) { // failed to execute statement
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > execute-statement',
				'message' => '<e><b class="icon-error"></b>Failed to execute query statement</e>'
			);
			return false;
		}

		$result = $stmt->get_result();
		if (!$result) { // failed to get results
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > get-query-results',
				'message' => '<e><b class="icon-error"></b>Failed to get query results</e>'
			);
			return false;
		}

		if (!$result->num_rows > 0) {
			// uid entry not found in address table
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > get-num-rows',
				'result' => false,
				'message' => '<e><b class="icon-error"></b>Failed to get any rows in query result</e>'
			);
			return false;
		}

		$row = $result->fetch_assoc();
		if (!$row) { // failed to fetch row
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > fetch-row',
				'message' => '<e><b class="icon-error"></b>Failed to fetch row from results</e>'
			);
			return false;
		} 

		try {
			// found a priority address, continue to fetch address details
			$this->type = $row['type']; // address type home/office/other
			$this->label = $row['label']; // nickname to identify individual addresses
			$this->address = $row['address']; // full street address
			$this->country = $row['country']; // country of the address
			$this->state = $row['state']; // state of the address
			$this->city = $row['city']; // city of the address
			$this->zip = $row['zip']; // zip code of the address

		} catch (Exception $e) {
			// some fields were not fetched
			// create error report
			$this->report[] = array(
				'api' => 'Account',
				'action' => 'get-dashboard > get-dashboard-fields-address > fetch-fields',
				'message' => '<e><b class="icon-error"></b>' . $e->getMessage() . '</e>'
			);
		}		
		// create an array of variables containing all fields from all databases
		$this->dashboardFields = array(
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'cc' => $this->cc,
			'cn' => $this->cn,
			'dc' => $this->dc,
			'mobile' => $this->mobile,
			'gender' => $this->gender,
			'dob' => $this->dob,
			'type' => $this->type,
			'label' => $this->label,
			'address' => $this->address,
			'country' => $this->country,
			'state' => $this->state,
			'city' => $this->city,
			'zip' => $this->zip
		);
			
	} // end method getDashboardFields();

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// METHOD onBoardStep1(); // method to store user information from onboarding step1
	////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function onBoardStep1() {
		// collect post variables and store them in kyc table
		// prepare statement
		$stmt = $this->connection->prepare("UPDATE kyc SET firstname = ?, lastname = ?, cc = ?, cn = ?, dc = ?, mobile = ? WHERE uid = ?");
		if(!$stmt) { // failed to prepare statement
			// create error report
		}
		$stmt->bind_param('sssssss', $this->firstname, $this->lastname, $this->cc, $this->cn, $this->dc, $this->mobile, $this->sessionUID);
		if(!$stmt) { // failed to bind parameters
			// create error report

		}
		$stmt->execute();
		if(!$stmt) { // failed to execute statement
			// create error report
		}

		// successfully updated kyc table, run method getFullDashboard(); to initiate step 2

		$this->getFullDashboard();

	}

	public function onBoardStep2() {
		// prepare statement
		$stmt = $this->connection->prepare("UPDATE kyc SET gender = ?, dob = ? WHERE `uid` = ?");
		if(!$stmt) { // failed to prepare statement
			// create error report
		}
		$stmt->bind_param('iss', $this->gender, $this->dob, $this->sessionUID);
		if(!$stmt) { // failed to bind parameters
			// create error report
		}
		$stmt->execute();
		if(!$stmt) { // failed to execute statement
			// create error report
		}

		// successfully inserted values into kyc table, run getFullDashboard(); to initiate step 3

		$this->getFullDashboard();

	}

	public function onBoardStep3() {
		$p = 1;
		// prepare statement
		$stmt = $this->connection->prepare("UPDATE address 
                                    SET `type` = ?, 
                                        `label` = ?, 
                                        `address` = ?, 
                                        `country` = ?, 
                                        `state` = ?, 
                                        `city` = ?, 
                                        `zip` = ? 
                                    WHERE `uid` = ? 
                                    AND `priority` = ?");

		if(!$stmt) { // failed to prepare statement
			// create error report
		}
		$stmt->bind_param('isssssssi', $this->type, $this->label, $this->address, $this->country, $this->state, $this->city, $this->zip, $this->sessionUID, $p);
		if(!$stmt) { // failed to bind param
			// create error report
		}
		$stmt->execute();
		if(!$stmt) { // failed to execute statement
			// create error report
		}

		// successfully updated address, run getFullDashboard(); to initiate dashboard

		$this->getFullDashboard();

	}

} // end trait GetDashboard
