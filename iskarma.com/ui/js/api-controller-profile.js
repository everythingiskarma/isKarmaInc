// this must be placed right after login is confirmed
var uid = $("#uid").val();
// click handler for logout button
$(document).on("click", "#logout", function () {
    $("#processing").fadeIn();
    var dom = domain;
    var requestData = {
        api: 'authenticator',
        action: 'logout',
        uid: uid,
        domain: domain
    }
    // Sending an AJAX request to the server to process and confirm logout
    processRequest(apiAuthenticator, requestData, successCallback, errorCallback);
});



function getProfile() {
    var requestData = {
        api: 'profile', // indicates which api / database to use
        action: 'get-profile-overview', // indicates which api action to perform
        domain: domain // indicates which domain requested the action
    };
    // Sending an AJAX request to the server to authenticate the email
    processRequest(apiProfile, requestData, successCallback, errorCallback);
}

function profileOverview(obj) {
    var fields = obj.profileFields;
    $("load").load('/iskarma.com/sections/profile/views/overview.php', function () {
        $("#firstname").val(atob(fields.firstname));
        $("#lastname").val(atob(fields.lastname));
        $("#country").attr({ "countrycode": atob(fields.cc), "countryname": atob(fields.cn), "dialcode": atob(fields.dc) });
        $("#country").text(atob(fields.cn));
        $(".dialCode").text(atob(fields.dc));
        $("#mobile").val(atob(fields.mobile));
        $(".gender").each(function () {
            if ($(this).attr("gender") == fields.gender) {
                $(this).addClass("selected");
            }
        });
        var dob = atob(fields.dob); // Decode the base64-encoded date string
        var parts = dob.split('-'); // Split the date string into parts
        var month = parts[0]; // Extract the month part
        var day = parts[1]; // Extract the day part
        var year = parts[2]; // Extract the year part
        $("#month").val(month);
        $("#day").val(day);
        $("#year").val(year);
        $(".type").each(function () {            
            if ($(this).attr("type") == fields.type) {
                $(this).addClass("selected");
            }
        });
        $("#label").val(atob(fields.label));
        $("#address").val(atob(fields.address));
        $("#add-country").val(atob(fields.country));
        $("#state").val(atob(fields.state));
        $("#city").val(atob(fields.city));
        $("#zip").val(atob(fields.zip));
    });
}

$(document).on("click", "#uProfile", function () {

    var type = $(".type.selected").attr("type"); // type of address
    var label = btoa($("#label").val()); // nickname for address
    var address = btoa($("#address").val()); // street address
    var city = btoa($("#city").val());
    var state = btoa($("#state").val());
    var country = btoa($("#add-country").val());
    var zip = btoa($("#zip").val());
    var gender = $(".gender.selected").attr("gender");
    var month = $(".month").val();
    var day = $(".day").val();
    var year = $(".year").val();
    var dob = btoa(month + '-' + day + '-' + year);
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

    if (type.length === 0) {
        alert('Please select a type of address');
        return;
    }
    if (label.length === 0) {
        alert('Label cannot be empty. Please enter suitable label to identify this address');
        $("#label").focus();
        return;
    }
    if (address.length === 0) {
        alert('Address cannot be empty. Please enter your street address');
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
        api: 'profile',
        action: 'update-profile',
        firstname: firstname,
        lastname: lastname,
        cc: cc,
        cn: cn,
        dc: dc,
        mobile: mobile,
        gender: gender,
        dob: dob,
        type: type,
        label: label,
        address: address,
        country: country,
        state: state,
        city: city,
        zip: zip
    }
    // send an ajax request to store onboarding step 2 information
    processRequest(apiProfile, requestData, successCallback, errorCallback);
    
});