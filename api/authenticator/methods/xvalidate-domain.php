<?php
// method to validate the source domain of the request
private function validateDomain() {

  if(isset($_POST['domain']) && !empty($_POST['domain'])) {
    // domain successfully recieved from post request, continue to validate email

    // trim email to remove leading and trailing whitespaces
    $domain = trim($_POST['domain']);

    // validate domain name
    if(filter_var($domain, FILTER_VALIDATE_DOMAIN)) {
      // it is a valid domain
      $this->domain = $domain;
      // create class response success message
      $this->report[] = array(
        'api' => 'Authenticator',
        'action' => 'validate-domain',
        'result' => true,
        'message' => '<s><b class="icon-done-all"></b>A valid domain was recieved in the post request</s>',
        'resolution' => 'check-registration-status'
      );
      return true;
    } else {
      // it is not a valid domain
      // create class response error message
      $this->report[] = array(
        'api' => 'Authenticator',
        'action' => 'validate-domain',
        'result' => false,
        'message' => '<e><b class="icon-error"></b>Domain name recieved is not valid!</e>',
        'resolution' => 'reset-login-form'
      );
      return false;
    }
  } else {
    // domain not recieved in the post request set it to default domain
    $this->domain = "iskarma.com";
    // create class response error message
    $this->report[] = array(
      'api' => 'Authenticator',
      'action' => 'set-domain',
      'result' => false,
      'message' => '<e><b class="icon-error"></b>Unable to recieve a valid domain in the post request. set to default!</e>',
      'resolution' => 'reset-login-form'
    );
    return false;
  }
}
?>
