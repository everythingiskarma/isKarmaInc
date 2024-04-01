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
require_once "classes/connect.php";
// declare class properties used across the api
require_once "methods/account/trait-properties.php"; // provides trait Properties
require_once "methods/account/trait-get-dashboard.php"; // provides trait GetDashboard

class Account extends Connect
{

	use Properties; // provides Account class properties
	use GetDashboard; // provides method getDashboard();

	public function __construct()
	{
		parent::__construct(); // call the constructor of the parent class conDb;
		$this->dashboard();

		if (isset($_SESSION['loggedIn'])) {
			$this->report[] = array(
				'login' => $_SESSION['loggedIn'],
				'uid' => $_SESSION['uid'],
				'domain' => $_SESSION['domain']
			);
		}
	} // end function __construct

	private function dashboard()
	{
		if (isset($_POST['action'])) {
			$this->action = $_POST['action'];

			switch ($this->action) {
				case 'dashboard':
					// execute method getDashboard and create success/error report based on the result
					$this->getDashboard();
					if ($this->onBoard === false) {
						// onboarding is not complete
						// create error report
						$this->report[] = array(
							'api' => 'Account',
							'action' => 'dashboard',
							'result' => false,
							'message' => '<e><b class="icon-error"></b>Onboarding pending!</e>',
							'resolution' => 'complete-onboarding',
							'onBoard' => ''
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
							'getDashboard' => ''
						);
						return false;
					}
					// code...
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

} // end class Account

// instantiate the class Account
$account = new Account();

// output report arrays as json
echo $account->getReport();
