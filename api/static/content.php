<?php

class GetSiteContent {

  public $report = array();
  public $content = '';

  public function __construct() {
    $this->processPostData();
  }

  private function processPostData() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      // create class error message and resolution
      $this->report[] = array(
        'api' => 'Static PHP Content',
        'action' => 'verify-request-method',
        'result' => false,
        'message' => '<e><b class="icon-error"></b>Invalid data request method. Only POST requests are accepted</e>',
        'resolution' => 'make-a-post-request'
      );
      return false;
    }
    // check if required parameters are received successfully
    $requiredParams = ['requestContentLocation', 'requestContentName', 'requestDomain'];
    foreach ($requiredParams as $param) {
      if (!isset($_POST[$param]) || $_POST[$param] === '') {
        // create class error message and resolution
        $this->report[] = array(
          'api' => 'Static PHP Content',
          'action' => 'verify-request-parameters',
          'result' => false,
          'message' => '<e><b class="icon-error"></b>$param value must be supplied and cannot be empty</e>',
          'resolution' => 'send-request-parameters'
        );
        return false;
      }
    }

    $contentLocation = $_POST['requestContentLocation'];
    $contentName = $_POST['requestContentName'];
    $contentDomain = $_POST['requestDomain'];
    // verify if the requesting domain and the sitename in location path are the same
    if($contentDomain === explode('/', $contentLocation)[1]) {
      // domain matches the request location proceed to display content
      $filePath = "../{$contentLocation}/{$contentName}.php";
      if (!file_exists($filePath)) {
        // create class error message and resolution
        $this->report[] = array(
          'api' => 'Static PHP Content',
          'action' => 'verify-file-exists',
          'result' => false,
          'message' => '<e><b class="icon-error"></b>The requested file does not exist on the server!</e>',
          'resolution' => 'check-requested-file-name-or-path'
        );
        return false;
      }

      $fileContent = file_get_contents($filePath);
      if ($fileContent === false) {
        // create class error message/resolution
        $this->report[] = array(
          'api' => 'Static PHP Content',
          'action' => 'get-file-contents',
          'result' => false,
          'message' => '<e><b class="icon-error"></b>Failed to read file content</e>',
          'resolution' => 'check-file-content-and-retry'
        );
        return false;
      }

      $this->content = $fileContent;

      // Include the required file and execute its PHP code
      ob_start();
      include $filePath;
      $this->content = ob_get_clean();

      $this->report[] = array(
        'api' => 'Static PHP Content',
        'action' => 'get-requested-content',
        'result' => true,
        'message' => '<s><b class="icon-done-all"></b>File content fetched!</s>',
        'content' => $this->content
      );
      return true;
    } else {
      // requesting domain does not match the domain in the requested file path
      // create class error message/resolution
      $this->report[] = array(
        'api' => 'Static PHP Content',
        'action' => 'verify-request-domain',
        'result' => false,
        'message' => 'Error: Invalid data request! Requesting domain does not match file location',
        'content' => 'request-content-from-valid-domain'
      );
      return false;
    }
  }

  public function getReport() {
    return json_encode($this->report);
  }

} // end class GetSiteContent

// create a new instance of the class
$getSiteContent = new GetSiteContent();
// get the response array
echo $getSiteContent->getReport();
?>
