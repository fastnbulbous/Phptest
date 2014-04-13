<?php
echo "My first PHP script!";

$input = $_GET["search"];
$currentPage = $_GET["page"];

$query = $input;  // A query

$SafeQuery = urlencode($query);


if (!$currentPage)
  $currentPage = 1;


$apicall = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.7&SECURITY-APPNAME=TomLinge-452a-421b-bd32-289d2152277f&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD=true&paginationInput.entriesPerPage=8&paginationInput.pageNumber=$currentPage&keywords=sprewell&GLOBAL-ID=EBAY-GB";



// Load the call and capture the document returned by the Shopping API
$resp = simplexml_load_file($apicall)->searchResult;

// Check to see if the response was loaded, else print an error
if ($resp)
{
  $loopCount = 0;

  $results = '<table>';

  // If the response was loaded, parse it and build links
  foreach($resp->item as $item)
  {

    $link  = $item->viewItemURL;
    $title = $item->title;
    $image = $item->galleryURL;
    $price = $item->sellingStatus->convertedCurrentPrice;
    $timeLeft = $item->sellingStatus->timeLeft;

    // Iterate though each item and build a table as $results
    
    if ($loopCount == 0)
      $results .= '<tr bgcolor="#ffdbdb">';
    else
      $results .= '<tr>';

    $results .= '<td><img src="' . $image . '"></td>';
    $results .= '<td><a href="' . $link . '">' . $title . '</a></td>';
    $results .= '<td>£' . $price . '</td>';
    $results .= '<td>' . $timeLeft . '</td>';
    $results .= '</tr>';

    if ($loopCount == 0)
      $loopCount = 1;
    else
      $loopCount = 0;
  }

}
// If there was no response
else {
	$results = "Sorry there was an error talking to the API";
}

$results .= "</table>";

echo $results;

?>

