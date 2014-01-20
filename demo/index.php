<?php

require_once '../analytics/Google_Client.php';
require_once '../analytics/contrib/Google_AnalyticsService.php';
require_once 'storage.php';
require_once 'authHelper.php';

// These must be set with values YOU obtains from the APIs console.
// See the Usage section above for details.
const REDIRECT_URL = 'http://hznr.ihoi.eu.org/~cronic/api/demo/index.php';
const CLIENT_ID = '595092983393.apps.googleusercontent.com';
const CLIENT_SECRET = 'Lc-QIvNmy0pRSUBn0xUtDWXz';

// The file name of this page. Used to create various query parameters to
// control script execution.
const THIS_PAGE = 'index.php';

const APP_NAME = 'Google Analytics Sample Application';
const ANALYTICS_SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';


$demoErrors = null;

$authUrl = THIS_PAGE . '?action=auth';
$revokeUrl = THIS_PAGE . '?action=revoke';

$mgmtApiDemoUrl = THIS_PAGE . '?demo=mgmt';
$coreReportingDemoUrl = THIS_PAGE . '?demo=reporting';

// Build a new client object to work with authorization.
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URL);
$client->setApplicationName(APP_NAME);
$client->setScopes(
    array(ANALYTICS_SCOPE));

// Magic. Returns objects from the Analytics Service
// instead of associative arrays.
$client->setUseObjects(true);


// Build a new storage object to handle and store tokens in sessions.
// Create a new storage object to persist the tokens across sessions.
$storage = new apiSessionStorage();


$authHelper = new AuthHelper($client, $storage, THIS_PAGE);

// Main controller logic.

if ($_GET['action'] == 'revoke') {
  $authHelper->revokeToken();

} else if ($_GET['action'] == 'auth' || $_GET['code']) {
  $authHelper->authenticate();

} else {
  $authHelper->setTokenFromStorage();

  if ($authHelper->isAuthorized()) {
    $analytics = new Google_AnalyticsService($client);
	
	if ($_GET['demo'] == 'mgmt') {

      // Management API Reference Demo.
      require_once 'managementApiReference.php';

      $demo = new ManagementApiReference($analytics);
      $htmlOutput = $demo->getHtmlOutput();
      $demoError = $demo->getError();

    } else if ($_GET['demo'] == 'reporting') {

      // Core Reporting API Reference Demo.
      require_once 'coreReportingApiReference.php';

      $demo = new CoreReportingApiReference($analytics, THIS_PAGE);
      $sites = array('ga:72779327', 'ga:77060423', 'ga:79046312', 'ga:76691494', 'ga:73579491', 'ga:69318364', 'ga:60083007', 'ga:52774896', 'ga:78361118', 'ga:78698281', 'ga:79483537');
      $htmlOutput = $demo->getHtmlOutput($sites);//$_GET['tableId']);
      $demoError = $demo->getError();
    }
  }

  // The PHP library will try to update the access token
  // (via the refresh token) when an API request is made.
  // So the actual token in apiClient can be different after
  // a require through Google_AnalyticsService is made. Here we
  // make sure whatever the valid token in $service is also
  // persisted into storage.
  $storage->set($client->getAccessToken());
}

// Consolidate errors and make sure they are safe to write.
$errors = $demoError ? $demoError : $authHelper->getError();
$errors = htmlspecialchars($errors, ENT_NOQUOTES);
?>


<!DOCTYPE>
<html>
  <head>
  	<link rel="stylesheet" type="text/css" href="style.css">
    <title>GMP Raport</title>
  </head>
  <body>


<?php
  // Print out authorization URL.
  if ($authHelper->isAuthorized()) {
    print "<p><button class=button><a href='$revokeUrl'>Anulowanie autoryzacji</a></button></p>";
    
    print "<hr>";
    print "<ul>";
    print "<li><button class=button><a href='$mgmtApiDemoUrl'>Management API</a></button></li>";
    print "<li><button class=button><a href='$coreReportingDemoUrl'>Raport miesieczny</a></button></li>";
    print "</ul>";
    print "<hr>";
  } else {
  
 
    print "<p><button class=button_auth><a href='$authUrl'>Autoryzacja</a></button></p>";
  }
  

  // Print out errors or results.
  if ($errors) {
    print "<div>Wystąpił błąd: <br> Należy zalogować się z konta administracyjnego";     //$errors</div>";
  } else if ($authHelper->isAuthorized()) {
    print "<div>$htmlOutput</div>";
  } 
?>

  </body>
</html>

