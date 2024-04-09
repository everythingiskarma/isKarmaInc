<?php
// Set custom name for the session cookie
session_name('everythingIsKarma');
// start session before processing the post request (via ajax or php form)
session_start();
// report all errors in case the script fails to execute at some point
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/////////////////////////////////////////////////////////////////////////////////////////
// initiate a database connection
require_once "../../api-helpers/connect.php";
// declare class properties used across the api
require_once "methods/properties.php"; // provides trait Properties
require_once "methods/get-profile-overview.php"; // provides trait GetProfile
require_once "methods/update-profile.php"; // provides trait UpdateProfile

class Profile extends Connect
{

	use Properties; // provides Profile class properties
	use GetProfileOverview; // provides method getProfileOverview();
	use UpdateProfile; // provides method updateProfile();

	public function __construct()
	{
		parent::__construct(); // call the constructor of the parent class conDb;
		$this->profile();
		/*
		if (isset($_SESSION['loggedIn'])) {
			$this->report[] = array(
				'action' => 'session-variables',
				'login' => $_SESSION['loggedIn'],
				'uid' => base64_encode($_SESSION['uid']),
				'domain' => base64_encode($_SESSION['domain'])
			);
		}
		*/
	} // end function __construct

	private function profile()
	{
		$this->sessionUID = $_SESSION['uid']; // set uid based on current session
		$this->sessionDomain = $_SESSION['domain']; // set uid based on current session
		$this->onBoardingStep = 'step1'; // set default to step for onboarding wizard
		$this->onBoard = false; // set default onboarding status

		if (isset($_POST['action'])) {
			$this->action = $_POST['action'];

			switch ($this->action) {
				case 'profile-overview':
					// execute method getProfile and create success/error report based on the result
					$this->getProfileOverview();
					break;
				case 'update-profile':
					$this->firstname = $_POST['firstname'];
					$this->lastname = $_POST['lastname'];
					$this->cc = $_POST['cc'];
					$this->cn = $_POST['cn'];
					$this->dc = $_POST['dc'];
					$this->mobile = $_POST['mobile'];
					$this->gender = $_POST['gender'];
					$this->dob = $_POST['dob'];
					$this->type = $_POST['type'];
					$this->label = $_POST['label'];
					$this->address = $_POST['address'];
					$this->country = $_POST['country'];
					$this->state = $_POST['state'];
					$this->city = $_POST['city'];
					$this->zip = $_POST['zip'];
					// execute method updateProfile and create success/error report based on the result
					$this->updateProfile();
					break;
				case 'list-address':
				case 'add-address':
				case 'remove-address':
				case 'update-address':
					// execute method getAddress
					//$this->manageAddress();
					break;
				case 'step1':
					// save step1 post data and go to step 2
					//$this->incomingUID = base64_decode($_POST['uid']);
					$this->firstname = $_POST['firstname'];
					$this->lastname = $_POST['lastname'];
					$this->cc = $_POST['cc'];
					$this->cn = $_POST['cn'];
					$this->dc = $_POST['dc'];
					$this->mobile = $_POST['mobile'];
					$this->onBoardStep1();
					break;
				case 'step2':
					// save step2 post data and go to step 3
					//$this->incomingUID = base64_decode($_POST['uid']);
					$this->gender = $_POST['gender'];
					$this->dob = $_POST['dob'];
					$this->onBoardStep2();
					break;
				case 'step3':
					// save step3 post data and go to dashboard
					//$this->incomingUID = base64_decode($_POST['uid']);
					$this->type = $_POST['type'];
					$this->label = $_POST['label'];
					$this->address = $_POST['address'];
					$this->country = $_POST['country'];
					$this->state = $_POST['state'];
					$this->city = $_POST['city'];
					$this->zip = $_POST['zip'];
					$this->onBoardStep3();
					break;							
				default:
					// code
					break;
			}
		}
	}

	// method to access success array
	public function getReport()
	{
		return json_encode($this->report);
	}

} // end class Profile

// instantiate the class Profile
$profile = new Profile();

// output report arrays as json
echo $profile->getReport();
