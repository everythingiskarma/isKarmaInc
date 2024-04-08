<?php
trait Properties {

    // Common properties
    protected $uid; // to store uid from database
    protected $sessionUID; // to store current session UID
    protected $incomingUID; // to store UID of incoming post request

    protected $domain; // to store domain from database
    protected $sessionDomain; // to store domain from session variable
    protected $incomingDomain; // to store domain of incoming post request

    protected $action; // to store action from incoming post request

    // dashboard related properties
    protected $profileFields;
    protected $onBoard;
    protected $onBoardingStep;

    // address related properties
    protected $type = '';
    protected $priority = '';
    protected $label = '';
    protected $address = '';
    protected $country = '';
    protected $state = '';
    protected $city = '';
    protected $zip = '';

    // communication related properties
    protected $status_newsletter = '';
    protected $status_notifications = '';

    // kyc related properties 
    protected $email_alt = ''; // users alternate email address
    protected $firstname = ''; // users firstname
    protected $lastname = ''; // users lastname
    protected $gender = ''; // users gender
    protected $dob = ''; // users date of birth
    protected $cc = ''; // users country code
    protected $cn = ''; // users country name
    protected $dc = ''; // users country dial code
    protected $mobile = ''; // users mobile number
    protected $id_type = ''; // users kyc id type
    protected $id_image = ''; // users kyc id photograph
    protected $id_address_proof = ''; // users kyc id address proof type
    protected $id_address_proof_image = ''; // users kyc id address proof image
    protected $id_kyc_status = ''; // users kyc id and address verification status
    

    // kyc business related properties
    protected $biz_name = ''; // business or organization name
    protected $biz_type = ''; // business type
    protected $biz_role = ''; // users role in business
    protected $biz_industry = ''; // 
    protected $biz_category = '';
    protected $biz_reg_type = '';
    protected $biz_reg_cert_image = '';
    protected $biz_validity = '';
    protected $biz_annual_income = '';
    protected $biz_total_employees = '';
    protected $biz_kyc_status = '';

    // preferences related properties
    protected $language = '';
    protected $mode = '';
    protected $timezone = '';

    // security related properties
    protected $two_factor = '';
    protected $two_factor_key = '';
    protected $status_terms = '';
    protected $status_privacy = '';
    protected $status_multisite = '';



}   
?>
