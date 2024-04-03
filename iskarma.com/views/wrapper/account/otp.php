<div id="account">
	<br />
	<a class="icon-iskarma" href="#welcome" location="iskarma.com/content/articles" title="Welcome to isKarma Inc">
		<span class="path1"></span>
		<span class="path2"></span>
		<span class="path3"></span>
		<span class="path4"></span>
	</a>
</div>

<h1>One Time Password</h1>
<div class="ibx icon-key">
	<input id="otp" type="password" maxlength="6" placeholder="Enter 6 digit OTP" autofocus autocomplete="off">
	<label>otp</label>
</div>

<div id="validOTP" class="ibxg grid-b">
	<div class="bbx space" id="cancel" tabindex="0">
		<div class="icon-btn">
			<span class="icon-close"></span><a class="clear">Cancel</a>
		</div>
	</div>
</div>

<div class="bbx space" id="confirm" tabindex="0" otpid="" otptype="" uid="">
	<div class="icon-btn">
		<span class="icon-done"></span><a class="clear">Confirm OTP</a>
	</div>
</div>
<messages></messages>
<div class="bbx" id="resendTimer"></div>