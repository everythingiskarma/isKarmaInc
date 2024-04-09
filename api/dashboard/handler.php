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
require_once "methods/get-overview.php"; // provides trait GetOverview
require_once "methods/get-shortcuts.php"; // provides trait GetShortcuts

class Dashboard extends Connect
{

	use Properties; // provides class properties
	use GetOverview; // provides class getOverview();
	use GetShortcuts; // provides class getShortcuts();

	public function __construct()
	{
		parent::__construct(); // call the constructor of the parent class conDb;
		$this->dashboard();
	} // end function __construct

	private function dashboard()
	{
		$this->sessionUID = $_SESSION['uid']; // set uid based on current session
		$this->sessionDomain = $_SESSION['domain']; // set uid based on current session
		if(isset($_POST['action'])) {
			$this->action = $_POST['action'];

			switch ($this->action) {
				case 'dashboard-overview':
					$this->getOverview();
					# code...
					break;

				case 'dashboard-shortcuts':
					$this->getShortcuts();
					# code...
					break;
				
				default:
					# code...
					break;
			}
		}
	}

	// method to access success array
	public function getReport()
	{
		return json_encode($this->report);
	}
} // end class Dashboard

// instantiate the class Profile
$dashboard = new Dashboard();

// output report arrays as json
echo $dashboard->getReport();
