<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Crawler</title>
    <link rel="stylesheet" href="crawler.css">
    <link rel="stylesheet" href="reset.css">
  </head>
  <body>
  	<div class="header">
  		<div class="header-text">Crawler</div>
	  	<form>
	  		<input class="search" type="text" name="crawler" <?php if (isset($_GET['crawler'])) { echo 'value="' . $_GET['crawler'] . '"';} ?>>
      </br>
	  		<input class="button" type="submit" value="Crawl!">
	  	</form>
	</div>

	<?php

function get_links($url) {
    // Create a new DOM Document to hold our webpage structure
    $xml = new DOMDocument();
    $returnedHtml = '';

    // Load the url's contents into the DOM
    @$xml->loadHTMLFile($url);

    // Empty array to hold all links to return
    $links = array();

    //Loop through each <a> tag in the dom and add it to the link array
    foreach($xml->getElementsByTagName('a') as $link) {
    	$href = $link->getAttribute('href');

    	if  ( $ret = parse_url($href) ) {
			if ( !isset($ret["scheme"]) ) {
				$href = "http://{$url}";
			}
		}
		$href = strtok($href, "#");

        $links[] = $href;
    }
    $links = array_unique($links);

    foreach($links as $link) {
        $returnedHtml .= '<a href="http://localhost/crawler.php?crawler='. urlencode($link) .'" class="link">' . $link . '</a>';
    }
    //Return the links
    return $returnedHtml;
} 


	if (isset($_GET['crawler'])) {
		$url = $_GET['crawler'];

		print($_GET['crawler']); 

		if (filter_var($url, FILTER_VALIDATE_URL)) {
		    echo(" is a valid URL<br>");
			   echo get_links($url);
		} else {
		    echo(" is not a valid URL<br>");
		}
	}
	?>

  </body>
</html>