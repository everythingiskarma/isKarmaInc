<div class="ibxg ibx">
	<label>gender</label>
	<div class="ibx twin-select">
		<div class="twin-btn gender" gender="0">Male</div>
		<div class="twin-btn gender selected" gender="1">Female</div>
	</div>
</div>


<ul id="" class="toolbar">
	<div class="bbx">
		<div id="logout" class="button" tabindex="0">Logout</div>
	</div>
</ul>

<center>
	<p><big>Welcome Aboard!</big><br>Let's get to know you a little better..</p>
</center>

<div class="ibx icon-user">
	<label for="firstName">first name *</label>
	<input name="firstName" id="firstname" type="text" placeholder="Enter your first name" tabindex="0" autofocus>
</div>

<div class="ibx icon-user">
	<label for="lastName">last name *</label>
	<input name="lastName" id="lastname" type="text" placeholder="Enter your last name" tabindex="0">
</div>

<div class="ibxg ibx">
	<label>date of birth</label>
	<div class="ibx date">
		<label>month</label>
		<input class="month" id="month" type="number" min="01" max="12" placeholder="12" tabindex="0">
	</div>
	<div class="ibx date">
		<label>day</label>
		<input class="day" id="day" type="number" min="01" max="31" placeholder="27" tabindex="0">
	</div>
	<div class="ibx date">
		<label>year</label>
		<input class="year" id="year" type="number" min="1924" max="2024" placeholder="1982" tabindex="0">
	</div>
</div>

<div class="ibx icon-sphere">
	<label>location *</label>
	<select id="countries" tabindex="0">
		<option>Select Country (Dial Code)</option>
	</select>
</div>

<script>
	$(document).ready(function() {
		$("#countries").empty();
		$.each(countries, function(index, country) {
			$("#countries").append($('<option>', {
				value: country.dc,
				text: country.cn + ' ( ' + country.dc + ' )'
			}));
		});
		$("#countries").change(function() {
			var sel = $(this).val();
			$("#countries").attr('sel', sel);
		});
	});
</script>

<div class="ibx icon-phone">
	<label>mobile *</label>
	<input id="phone" type="text" placeholder="Enter your phone number here" tabindex="0">
</div>


<div class="ibx icon-business-add">
	<label>organization</label>
	<input id="business" type="text" placeholder="Enter name of your business or organization" tabindex="0">
</div>

<div class="ibx icon-home">
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

<div class="bbx">
	<div class="icon-btn" tabindex="0">
		<span class="icon-right"></span><a class="clear">Continue</a>
	</div>
</div>