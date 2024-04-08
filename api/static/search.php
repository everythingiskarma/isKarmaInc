<?php

class Search {
  //Declares a public property $report initialized as an empty array.
  public $report = array();
  //Declares a private property $content initialized as an empty string.
  private $content = array();
  //Constructor method called when a new instance of the class is created.
  public function __construct() {
    //Calls the processPostData() method to handle the search functionality.
    $this->processPostData();
  }

  //Method to process the POST data for search parameters.
  private function processPostData() {
    //Checks if required search parameters (searchKeyword and requestFrom) are sent correctly.
    $requiredParams = ['searchKeyword', 'requestFrom'];
    foreach($requiredParams as $param) {
      //If parameters are missing or empty, it adds an error report to $this->report and returns false.
      if(!isset($_POST[$param]) || $_POST[$param] === '') {
        // create error report
        $this->report[] = array(
          'api' => 'Static PHP Content Search',
          'action' => 'check-post-variables',
          'result' => false,
          'message' => '<e><b class="icon-error"></b>Missing required search parameters!</e>',
          'content' => 'send request with valid parameters'
        );
        return false;
      }
    }
    //Sets variables for post parameters ($searchDomain and $searchKeyword).
    $searchDomain = $_POST['requestFrom'];
    $searchKeyword = $_POST['searchKeyword'];
    //Constructs a directory path based on the post parameters.
    $directory = '../../' . $searchDomain . '/content';
    //Calls the searchFiles() method to search for content in PHP files within the directory.
    $searchResults = $this->searchFiles($directory, $searchKeyword);
    // Process the search results to extract categories and update category counts.
    $catCount = [];
    $totalHits = 0;
    // array to store hit count for each directory
    //Processes the search results to extract categories and category counts.
    foreach($searchResults as $result) {
      $category = $result["pageType"];
      $dir = dirname($result["pageType"]);
      // increment category count
      if(isset($catCount[$category])) {
        $catCount[$category]++;
      } else {
        $catCount[$category] = 1;
      }

      // Increment total hits count.
      $totalHits++;

    }
    // create an array of unique categories
    $categories = array_keys($catCount);

    //Prepares response data array and encodes it into JSON format.
    $responseData = array(
      'categories' => $catCount,
      'hits' => $totalHits,
      'results' => $searchResults
    );
    // json encode response data
    $this->content = json_encode($responseData);

    // create success report
    $this->report[] = array(
      'api' => 'Static PHP Content Search',
      'action' => 'get-search-results',
      'result' => true,
      'message' => '<s><b class="icon-done-all"></b>Search results received successfully</s>',
      'content' => $responseData
      //'content' => $this->content
    );

    return true;

  }

  // Recursive method to search for content in PHP files within directories and return an array of data $results[]
  private function searchFiles($directory, $searchKeyword) {

    $results = [];
    $handle = opendir($directory);

    // check if directory can be opened
    if($handle === false) {
      $this->report[] = array(
        'api' => 'Static PHP Content Search',
        'action' => 'open-directory',
        'result' => false,
        'message' => '<e><b class="icon-error"></b>Unable to access content directory for this domain</e>',
        'content' => 'refresh and try again'
      );
      return false;
    }

    while (($file = readdir($handle)) !== false) {
      //Iterates through files in the directory, skipping . and ...
      if ($file == '.' || $file == '..') continue;
      $path = $directory . DIRECTORY_SEPARATOR . $file;
      if (is_dir($path)) {
        //Recursively calls itself for subdirectories.
        $results = array_merge($results, $this->searchFiles($path, $searchKeyword));
      } elseif (pathinfo($path, PATHINFO_EXTENSION) == 'php') {
        //Reads PHP files and searches for the given keyword.
        $content = file_get_contents($path);
        if ($content !== false && stripos($content, $searchKeyword) !== false) {
          // extract page id from the file name
          $pageId = basename($path, '.php');
          // extract page path from files absolute path
          $pagePath = implode('/', array_slice(explode('/', $path), 1, -1));
          // extract page type (i.e the name of the parent directory as category)
          $pageType = explode('/', explode('/content/', $path)[1])[0];
          // extract page title from the first h1 tag in the content
          $pageTitle = $this->extractPageTitle($content);
          // extract page intro from the element <intro> in the content
          $pageIntro = $this->extractPageIntro($content);
          // extract matching sentence from the content
          $matchingSentence = $this->extractMatchingSentence($content, $searchKeyword);
          // extract the image url from the first <img> tag
          //$pageImage = $this->extractPageImage($content, $_SESSION['imagePaths']);
          $pageImage = "";
          // extracts relevant data from matching files and adds it to the results array.
          $results[] = compact('pageId', 'pagePath', 'pageType', 'pageTitle', 'pageIntro', 'matchingSentence', 'pageImage');
        }
      }
    }
    closedir($handle);
    return $results;
  } // end function searchFiles

  private function extractPageImage($content, $imagePaths) {
    if(empty($imagePaths)) return 'No Image found';
    foreach($imagePaths as $imagePath)
    if(stripos($content, $imagePath) !== false)
    return $imagePath;
    return 'No image found';
  }

  private function extractPageTitle($content) {
    return preg_match('/<h1>\s*(.*?)\s*<\/h1>/', $content, $matches) ? $matches[1] : 'No page title found!';
  }

  private function extractPageIntro($content) {
    return preg_match('/<intro>\s*(.*?)\s*<\/intro>/is', $content, $matches) ? $matches[1] : 'No intro text found!';
  }

  private function extractMatchingSentence($content, $searchKeyword) {
    $snippetLength = 250;
    $keywordPosition = stripos($content, $searchKeyword);
    if ($keywordPosition !== false) {
      $startIndex = max(0, $keywordPosition - $snippetLength);
      $sentenceStartIndex = strrpos(substr($content, 0, $startIndex), '.');
      if($sentenceStartIndex === false) $sentenceStartIndex = 0;
      else $sentenceStartIndex = strpos($content, '>', $sentenceStartIndex) === false ? 0 : $sentenceStartIndex + 1;
      $endIndex = min(strlen($content), $keywordPosition + strlen($searchKeyword) + $snippetLength);
      $snippet = substr($content, $sentenceStartIndex, $endIndex - $sentenceStartIndex);
      $snippet = strip_tags($snippet);
      return str_ireplace($searchKeyword, '<span class="highlight">' . $searchKeyword . '</span>', $snippet);
    } else return 'no results found!';
  }

  public function getReport() {
    return json_encode($this->report);
  }
} // end class GetSiteSearchResults

// create a new instance of the class
$i = new Search();
// get the report array
echo $i->getReport();

?>
