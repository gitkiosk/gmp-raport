<?php

	/*
date_default_timezone_set('Warsaw/Poland'); 
	$date = date('Y-m-d', time());
	echo($date);
*/	
	
class CoreReportingApiReference {

  /** @var apiAnalyticsService $analytics */
  private $analytics;

  /**
   * The Url of the main controller. Used to properly handle
   * redirects and strip the URL of additional authorization
   * parameters.
   * @var string $controllerUrl
   */
  private $controllerUrl;

  /** @var string $error */
  private $error = null;

  /**
   * Constructor.
   * @param $analytics
   * @param string $controllerUrl The Url for the main controller.
   * @internal param Google_AnalyticsService $analytics The analytics service
   *     object to make requests to the API.
   */
  function __construct(&$analytics, $controllerUrl) {
    $this->analytics = $analytics;
    $this->controllerUrl;
  }


  /**
   * Returns a HTML string representation of all the data in this demo.
   * This method first queries the Core Reporting API with the provided
   * profiled ID. Then it formats and returns all the results as a string.
   * If any API errors occur, they are caught and set in $this->error.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return string The formatted results from the API.
   */
  function getHtmlOutput($tableIds = null) {
//    $output = $this->getHTMLForm($tableId);

    if (isset($tableIds)) {
      try {
        foreach ($tableIds as $tableId) {
        	
        	$results = $this->queryCoreReportingApi($tableId);
			$output .= $this->getFormattedResults($results);
			$output .= "<br /><br />";
        }
      } catch (Google_ServiceException $e) {
        $this->error = $e->getMessage();
      }
    }
    return $output;
  }

  /**
   * Queries the Core Reporting API for the top 25 organic search terms
   * ordered by visits. Because the table id comes from the query parameter
   * it needs to be URI decoded.
   * @param string $tableId The value of the ids parameter in the
   *     Core Reporting API. This is the ga namespaced profile ID. It has the
   *     format of ga:xxxx where xxxx is the profile ID. You can get this
   *     value from the Management API. See the helloAnalytics.php example
   *     for details.
   * @return GaData The results from the Core Reporting API.
   */


  private function queryCoreReportingApi($tableId) {

    $optParams = array(
        'max-results' => '31');


    return $this->analytics->data_ga->get(
        urldecode($tableId),
        '2014-01-01',
        '2014-01-19',
        'ga:avgTimeOnSite',
        $optParams);
  }

  /**
   * Returns the results from the API as a HTML formatted string.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getFormattedResults(&$results) {
    return implode('', array(
        $this->getProfileInformation($results),
        $this->getTotalsForAllResults($results),
    ));
    
  }

  /**
   * Returns general report information.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getReportInfo(&$results) {
    return <<<HTML
<h3>Report Information</h3>
<pre>
Contains Sampled Data = {$results->getContainsSampledData()}
Kind                  = {$results->getKind()}
ID                    = {$results->getId()}
Self Link             = {$results->getSelfLink()}
</pre>
HTML;
  }

  /**
   * Returns pagination information.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getPaginationInfo(&$results) {
    return<<<HTML
<h3>Pagination Info</h3>
<pre>
Items per page = {$results->getItemsPerPage()}
Total results  = {$results->getTotalResults()}
Previous Link  = {$results->getPreviousLink()}
Next Link      = {$results->getNextLink()}
</pre>
HTML;
  }

  /**
   * Returns profile information describing the profile being accessed
   * by the API.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getProfileInformation(&$results) {
    $profileInfo = $results->getProfileInfo();

    return<<<HTML



{$profileInfo->getProfileName()}
</pre>
HTML;
  }

  /**
   * Returns all the query parameters in the initial API query.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getQueryParameters(&$results) {
    $query = $results->getQuery();

    $html = '<h3>Query Parameters</h3><pre>';
    foreach ($query as $paramName => $value) {
      $html .= "$paramName = $value\n";
    }
    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns all the column headers for the table view.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getColumnHeaders(&$results) {
    $html = '<h3>Column Headers</h3><pre>';

    $headers = $results->getColumnHeaders();
    foreach ($headers as $header) {
      $html .= <<<HTML

Column Name = {$header->getName()}
Column Type = {$header->getColumnType()}
Data Type   = {$header->getDataType()}

HTML;
    }

    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns the totals for all the results.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getTotalsForAllResults(&$results) {

    $rowCount = count($results->getRows());
    $totalResults = $results->getTotalResults();

    $totals = $results->getTotalsForAllResults();
    
    
    foreach ($totals as $metricName => $metricTotal) {
      $html .= "$metricTotal";
    }
    $html .= '</pre>';
    return $html;
  }

  /**
   * Returns the rows of data as an HTML Table.
   * @param GaData $results The results from the Core Reporting API.
   * @return string The formatted results.
   */
  private function getRows($results) {
    $table = '<h3>Rows Of Data</h3>';

    if (count($results->getRows()) > 0) {
      $table .= '<table>';

      // Print headers.
      $table .= '<tr>';

      foreach ($results->getColumnHeaders() as $header) {
        $table .= '<th>' . $header->name . '</th>';
      }
      $table .= '</tr>';

      // Print table rows.
      foreach ($results->getRows() as $row) {
        $table .= '<tr>';
          foreach ($row as $cell) {
            $table .= '<td>'
                   . htmlspecialchars($cell, ENT_NOQUOTES)
                   . '</td>';
          }
        $table .= '</tr>';
      }
      $table .= '</table>';

    } else {
      $table .= '<p>Nic nie znaleziono.</p>';
    }

    return $table;
  }

 /**
  * @return string Any error that occurred.
  */
  function getError() {
    return $this->error;
  }
}

