<center>
	<br>
	<a class="icon-iskarma" href="#welcome" location="iskarma.com/content/articles" title="Welcome to isKarma Inc">
		<span class="path1"></span>
		<span class="path2"></span>
		<span class="path3"></span>
		<span class="path4"></span>
	</a>
	<br><br>
	<p><big>Welcome Aboard!</big><br>Let's get to know you a little better..</p>
</center>

<ul class="tab-wizard" id="onboarding">
	<li class="tab step1">
		<div class="ibxg grid-b">
			<div class="ibx name">
				<label for="firstName">first name *</label>
				<input class="firstname" name="firstName" id="firstname" type="text" placeholder="Enter first name" tabindex="0" autofocus autocomplete="off">
			</div>

			<div class="ibx name">
				<label for="lastName">last name *</label>
				<input class="lastname" name="lastName" id="lastname" type="text" placeholder="Enter last name" tabindex="0">
			</div>
		</div>
		<div class="ibx icon-sphere">
			<label>location *</label>
			<div class="space selector" id="country" countrycode="" countryname="" dialcode="" tabindex="0">Select Country ( Dial Code )</div>
		</div>

		<div id="countries" class="ibx-selection">
			<div class="close-selection icon-close"></div>
			<div class="ibx icon-search">
				<input class="selection-filter" placeholder="Search Country Name" autofocus tabindex="0">
			</div>
			<ul class="selection"></ul>
		</div>

		<div class="ibx icon-phone">
			<label>mobile *</label>
			<div class="dialCode">+</div>
			<input class="mobile" id="mobile" type="text" placeholder="Enter phone number here" tabindex="0">
		</div>
		<hr/>
		<div class="bbx">
			<div class="space icon-btn" id="step1" tabindex="0">
				<span class="icon-right"></span><a class="clear">Continue</a>
			</div>
		</div>

	</li>
	<li class="tab step2">
		<div class="ibxg ibx">
			<label>date of birth</label>
			<div class="ibx date">
				<label>month</label>
				<input class="month" id="month" type="number" min="01" max="12" placeholder="01" tabindex="0" autofocus>
			</div>
			<div class="ibx date">
				<label>day</label>
				<input class="day" id="day" type="number" min="01" max="31" placeholder="01" tabindex="0">
			</div>
			<div class="ibx date">
				<label>year</label>
				<input class="year" id="year" type="number" min="1924" max="2024" placeholder="1924" tabindex="0">
			</div>
		</div>

		<div class="ibxg ibx">
			<label>gender</label>
			<div class="ibx twin-select">
				<div class="space twin-btn gender" gender="0" tabindex="0"><span class="icon-male"></span>Male</div>
				<div class="space twin-btn gender selected" gender="1" tabindex="0"><span class="icon-female"></span>Female</div>
			</div>
		</div>

		<hr />
		<div class="ibxg grid-b">
			<div class="bbx">
				<div class="icon-btn" tabindex="0">
					<span class="icon-left"></span><a class="clear">Back</a>
				</div>
			</div>

			<div class="bbx">
				<div class="icon-btn" tabindex="0">
					<span class="icon-right"></span><a class="clear">Continue</a>
				</div>
			</div>
		</div>


	</li>
	<li class="tab step3">
		<div class="ibx icon-business-add">
			<label>organization</label>
			<input id="business" type="text" placeholder="Name of your business or organization" tabindex="0" autofocus>
		</div>

		<div class="ibx icon-location">
			<label>street address</label>
			<textarea id="address" type="textarea" placeholder="Enter your home / street address here" tabindex="0"></textarea>
		</div>

		<div class="ibx icon-address-add">
			<label>city</label>
			<input id="city" type="text" placeholder="Enter your city here" tabindex="0">
		</div>

		<div class="ibx icon-network">
			<label>zip code</label>
			<input id="zip" type="text" placeholder="Enter your area zip code here" tabindex="0">
		</div>
		<hr />

		<div class="ibxg grid-b">
			<div class="bbx">
				<div class="icon-btn" tabindex="0">
					<span class="icon-left"></span><a class="clear">Back</a>
				</div>
			</div>

			<div class="bbx">
				<div class="icon-btn" tabindex="0">
					<span class="icon-done-all"></span><a class="clear">Finish</a>
				</div>
			</div>
		</div>
	</li>
</ul>

<script>
	$(document).ready(function() {
		$.each(countries, function(index, country) {
			$("#countries ul").append(
				$('<li class="space" tabindex="0" cn="' + country.cn + '" dc="' + country.dc + '" cc="' + country.cc + '"> ' + country.cn + ' ( ' + country.dc + ' )</li>')
			);
		});
	});
</script>