<?php
	session_name("everythingIsKarma");
	session_start();
?>
<input id="uid" type="hidden" value="<?php if (isset($_SESSION['uid'])) {echo base64_encode($_SESSION['uid']);} ?>">
<ul id="togglebar">
	<li view="sidebar" class="icon-th-list left" title="display the sidebar"></li>
	<li view="search" class="icon-search modal" title="Search anything on this site...!"></li>
	<li id="notifications" view="notifications" class="icon-bell-o left" title="view system notifications and messages"><span class="ncount"><span></li>
	<?php
	if (isset($_SESSION['loggedIn'])) { ?>
		<li view="write" class="icon-pencil" title="write a new post/article"></li>
		<li view="profile" class="icon-user-private modal right" title="manage your account"></li>
		<li id="logout" class="icon-power right" title="logout from your account"></li>
	<?php } else { ?>
		<li view="profile" class="icon-user modal right" title="login to manage your account"></li>
	<?php } ?>
	<li id="efs" class="icon-fs" title="enter/exit full screen mode"></li>
</ul>