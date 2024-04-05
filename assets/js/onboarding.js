
// click handler for onboarding continue button
$(document).on("click", "#step1", function () {
	// validate inputs
	var firstname = btoa($("#firstname").val());
	var lastname = btoa($("#lastname").val());
	var cc = btoa($("#country").attr("countrycode"));
	var cn = btoa($("#country").attr("countryname"));
	var dc = btoa($("#country").attr("dialcode"));
	var mobile = btoa($("#mobile").val());
	if (firstname.length === 0) {
		alert('First name cannot be empty');
		$("#firstname").focus();
		return;
	}
	if (lastname.length === 0) {
		alert('Last name cannot be empty');
		$("#lastname").focus();
		return;
	}
	if (cc.length === 0 || cn.length === 0 || dc.length === 0) {
		alert('Please select your country and dial code');
		$("#country").trigger("click");
		return;
	}
	if (mobile.length === 0) {
		alert('Phone number cannot be empty');
		$("#mobile").focus();
		return;
	}
	// If all conditions are met, proceed with further logic here
	$("#processing").fadeIn();
	var requestData = {
		api: 'account',
		action: 'step1',
		uid: uid,
		firstname: firstname,
		lastname: lastname,
		cc: cc,
		cn: cn,
		dc: dc,
		mobile: mobile
	}
	// send an ajax request to store onboarding step 1 information
	processRequest('api/account.php', requestData, successCallback, errorCallback);
});


$(document).on("click", "#step2", function () {
	// validate inputs
	var gender = $(".gender.selected").attr("gender");
	var month = $(".month").val();
	var day = $(".day").val();
	var year = $(".year").val();
	var dob = btoa(month + '-' + day + '-' + year);
	if (gender.length === 0) {
		alert('Please select a gender to continue');
		return;
	}
	if (month.length === 0) {
		alert('Month cannot be empty. Please enter the month for your date of birth');
		$(".month").focus();
		return;
	}
	if (day.length === 0) {
		alert('Day cannot be empty. Please enter the day for your date of birth');
		$(".day").focus();
		return;
	}
	if (year.length === 0) {
		alert('Year cannot be empty. Please enter the year for your date of birth');
		$(".year").focus();
		return;
	}
	var requestData = {
		api: 'account',
		action: 'step2',
		uid: 'uid',
		gender: gender,
		dob: dob
	}
	// send an ajax request to store onboarding step 2 information
	processRequest('api/account.php', requestData, successCallback, errorCallback);
});


$(document).on("click", "#step3", function () {
	// validate inputs
	var type = $(".type.selected").attr("type"); // type of business address
	var label = btoa($("#label").val());
	var address = btoa($("#address").val());
	var city = btoa($("#city").val());
	var state = btoa($("#state").val());
	var country = btoa($("#add-country").val());
	var zip = btoa($("#zip").val());
	if (type.length === 0) {
		alert('Please select a type of address');
		return;
	}
	if (label.length === 0) {
		alert('Label cannot be empty. Please enter suitable label to identify this address');
		$("#address").focus();
		return;
	}
	if (country.length === 0) {
		alert('Country cannot be empty. Please enter the country for your address');
		$("#country").focus();
		return;
	}
	if (state.length === 0) {
		alert('State cannot be empty. Please enter the state for your address');
		$("#state").focus();
		return;
	}
	if (city.length === 0) {
		alert('City cannot be empty. Please enter the city for your address');
		$("#city").focus();
		return;
	}
	if (zip.length === 0) {
		alert('Zip Code cannot be empty. Please enter your area postal code for your address');
		$("#zip").focus();
		return;
	}
	var requestData = {
		api: 'account',
		action: 'step3',
		uid: 'uid',
		type: type,
		label: label,
		address: address,
		country: country,
		state: state,
		city: city,
		zip: zip
	}
	// send an ajax request to store onboarding step 2 information
	processRequest('api/account.php', requestData, successCallback, errorCallback);
});


function onBoarding(obj) {
	var step = obj.step;
	var fields = obj.fields;
	var month;
	var day;
	var year;
	if (fields.dob !== null) { // Check if fields.dob is not null
		var dob = atob(fields.dob); // Decode the base64-encoded date string
		var parts = dob.split('-'); // Split the date string into parts
		var month = parts[0]; // Extract the month part
		var day = parts[1]; // Extract the day part
		var year = parts[2]; // Extract the year part
	}
	$("load").load('/iskarma.com/views/wrapper/account/onboarding.php', function () {
		$(".tab").removeClass("active");
		$(".tab." + step).addClass("active");
		switch (step) {
			case step1:
				$("#firstname").focus();
				break;
			case step2:
				$(".gender").focus();
				break;
			case step3:
				$(".type").focus();
				break;
			default:
				break;
		}
		// populate each field with returned values
		if (fields.firstname != null) {
			$("#firstname").val(atob(fields.firstname));
		}
		if (fields.lastname != null) {
			$("#lastname").val(atob(fields.lastname));
		}
		if (fields.cc != null || fields.cn != null || fields.dc != null) {
			$("#country").attr({
				"countrycode": atob(fields.cc),
				"countryname": atob(fields.cn),
				"dialcode": atob(fields.dc)
			});
			$("#country").text(atob(fields.cn));
			$(".dialCode").text(atob(fields.dc));
		}
		if (fields.mobile != null) {
			$("#mobile").val(atob(fields.mobile));
		}
		if (fields.gender != null) {
			$(".gender").each(function () {
				if ($(this).attr("gender") === fields.gender) {
					$(this).addClass("selected");
				}
			});
		}
		$("#month").val(month);
		$("#day").val(day);
		$("#year").val(year);
		$(".type").each(function () {
			if ($(this).attr("type") === fields.type) {
				$(this).addClass("selected");
			}
		});
		$("#label").val(fields.label);
		$("#address").val(fields.address);
		$("#add-country").val(fields.country);
		$("#state").val(fields.state);
		$("#city").val(fields.city);
		$("#zip").val(fields.zip);
	});
}
