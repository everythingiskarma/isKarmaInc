<?php
trait Properties
{

	// Common properties
	protected $uid; // to store uid from database
	protected $sessionUID; // to store current session UID
	protected $incomingUID; // to store UID of incoming post request

	protected $domain; // to store domain from database
	protected $sessionDomain; // to store domain from session variable
	protected $incomingDomain; // to store domain of incoming post request

	protected $action; // to store action from incoming post request

}
?>