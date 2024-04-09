<div class="editable">

	<ul class="actionbar">
		<li class="space" id="uProfile" tabindex="0">
			<span class="icon-square-check"></span><i>Update</i>
		</li>
	</ul>

	<div class="ibxg ibx grid-b">
		<div class="ibx name">
			<label>first name *</label>
			<input class="firstname" id="firstname" type="text" placeholder="Enter first name" tabindex="0" autofocus autocomplete="off">
		</div>

		<div class="ibx name">
			<label>last name *</label>
			<input class="lastname" id="lastname" type="text" placeholder="Enter last name" tabindex="0">
		</div>
	</div>

	<div class="ibx icon-sphere">
		<label>location *</label>
		<div class="space selector" id="country" countrycode="" countryname="" dialcode="" tabindex="0">Select Country ( Dial Code )</div>
	</div>

	<div id="countries" class="ibx-selection">
		<div class="close-selection icon-close"></div>
		<div class="ibx icon-search" style="margin:20px auto; width:300px">
			<input class="selection-filter" placeholder="Search Country Name" autofocus tabindex="0">
		</div>
		<ul class="selection"></ul>
	</div>

	<div class="ibx icon-phone">
		<label>mobile *</label>
		<div class="dialCode">+</div>
		<input class="mobile" id="mobile" type="text" placeholder="Enter phone number here" tabindex="0">
	</div>

	<div class="ibxg ibx">
		<label>date of birth</label>
		<br>
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
		<div class="ibx grid-select twin">
			<div class="space btn gender" gender="1" tabindex="0"><span class="icon-male"></span><a>Male</a></div>
			<div class="space btn gender" gender="2" tabindex="0"><span class="icon-female"></span><a>Female</a></div>
		</div>
	</div>

	<div class="ibxg ibx">
		<label>type</label>
		<div class="ibx grid-select tri">
			<div class="space btn type" type="1" tabindex="0">Home</div>
			<div class="space btn type" type="2" tabindex="0">Office</div>
			<div class="space btn type" type="3" tabindex="0">Other</div>
		</div>
	</div>

	<div class="ibx icon-offer">
		<label>label</label>
		<input id="label" type="text" placeholder="Nickname for your address" tabindex="0" autofocus>
	</div>

	<div class="ibx icon-location">
		<label>street address</label>
		<textarea id="address" type="textarea" placeholder="Enter your home / street address here" tabindex="0"></textarea>
	</div>

	<div class="ibx icon-address-add">
		<label>city</label>
		<input id="city" type="text" placeholder="Enter your city here" tabindex="0">
	</div>

	<div class="ibx icon-address-add">
		<label>state</label>
		<input id="state" type="text" placeholder="Enter your state here" tabindex="0">
	</div>

	<div class="ibx icon-address-add">
		<label>country</label>
		<input id="add-country" type="text" placeholder="Enter your country here" tabindex="0">
	</div>

	<div class="ibx icon-network">
		<label>zip code</label>
		<input id="zip" type="text" placeholder="Enter your area zip code here" tabindex="0">
	</div>

</div>
<script>
	$(document).ready(function() {
		$.each(countries, function(index, country) {
			$("#countries ul").append(
				$('<li class="space" tabindex="0" cn="' + country.cn + '" dc="' + country.dc + '" cc="' + country.cc + '"> ' + country.cn + ' ( ' + country.dc + ' )</li>')
			);
		});
	});
</script>