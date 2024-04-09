<?php
// Set custom name for the session cookie
session_name('everythingIsKarma');
// start session before processing the post request (via ajax or php form)
session_start();
// report all errors in case the script fails to execute at some point
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_SESSION['loggedIn'])) {
	require_once 'views/login.php';
} else {
?>
	<div class="tabs sidebar">
		<ul class="tab-menu">
			<li id="dashboard">
				<h2>Dashboard</h2>
				<ul>
					<li id="dashboard-overview">Overview</li>
					<li id="dashboard-shortcuts">Shortcuts / Bookmarks</li>
				</ul>
			</li>
			<li id="profile">
				<h2>Profile</h2>
				<ul>
					<li id="profile-overview">Overview</li>
					<li id="profile-kyc">KYC</li>
					<li id="profile-kyc-business">Business KYC</li>
					<li id="profile-addresses">Addresses</li>
					<li id="profile-communication">Communications</li>
					<li id="profile-preferences">Preferences</li>
					<li id="profile-security">Security</li>
				</ul>
			</li>
			<li id="wallet">
				<h2>Wallet</h2>
				<ul>
					<li id="wallet-ledger">Balance</li>
					<li id="wallet-credits">Credits</li>
					<li id="wallet-debits">Debits</li>
				</ul>
			</li>
		</ul>
		<div class="tab-content">

		</div>
	</div>
	<script>
		reloadActiveMenu();
	</script>
<?php
}
?>