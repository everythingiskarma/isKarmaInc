<?php 
session_name("everythingIsKarma");
session_start();
if (isset($_SESSION['loggedIn'])) { ?>
	<li id="logout" class="icon-exit right <?php echo $status; ?>" title="logout from your account"></li>
	<li view="write" class="icon-pencil" title="write a new post/article"></li>
<?php } ?>
	<li view="account" class="icon-user modal right" title="manage your account"></li>
	<li view="sidebar" class="icon-th-list" title="display the sidebar"></li>
	<li view="search" class="icon-search modal" title="Search anything on this site...!"></li>
	<li id="notifications" view="notifications" class="icon-bell-o right" title="view system notifications and messages"></li>
	<li id="efs" class="icon-fs" title="enter/exit full screen mode"></li>