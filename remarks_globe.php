<?php

// TODO add common city list

// TODO add google API fallthrough

function addLongLatsToMatrix($long, $lat){
	global $remarks_longlats;
	
	if (array_key_exists($long, $remarks_longlats)){
		if (array_key_exists($lat, $remarks_longlats[$long])){
			$remarks_longlats[$long][$lat]++;
			RETURN -1;
		}
	}
	
	// fallthrough
	
	$remarks_longlats[$long]= array($lat => 1);
}


function stripCountry($raw_country){
	return ucwords(strtolower(substr($raw_country, 0, strpos($raw_country, " ("))));
}

function Geolocation_InsertCommentLocation($commentID, $country, $city, $latitude, $longitude){
    global $wpdb;

    global $remarks_countries;
	global $remarks_longlats;
    global $wpdb;

	$sql = "INSERT INTO $wpdb->remarks_comments VALUES ($commentID".', \''.$city.'\', \''.$country.'\', '.$latitude.', '.$longitude.')';
	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

     if (($latitude != 0.0) || ($longitude != 0.0)){
          addLongLatsToMatrix($longitude, $latitude);
     }

}

function Geolocation_RegisterCountry($country){
     global $remarks_countries;

    // 3. see if that city and country exists
    if (array_key_exists($country, $remarks_countries)){
        // 3b. otherwise increase that city and country's value by 1
	$remarks_countries[$country] ++;
    } else {
        // 3a. if that city and country doesn't exist, create a key in an array for that city and country, and set its number to 1
	$remarks_countries[$country] = 1;
    }
}

function IPtoLocationEntry_HostIP($commentIndex, $eachIP){
	global $remarks_longlats;
    
    // thanks Dan Grossman of Stack Overflow!
    $response = file("http://api.hostip.info/get_html.php?ip=$eachIP&position=true");
    
    IF( strpos($response[0], "(XX)") != FALSE ){
    	RETURN -1;
    }
    
    foreach ($response as $line) {
	$line = trim($line);
	    if (!empty($line)) {
		$parts = explode(': ', $line);
		if (array_key_exists(1, $parts)){
			$result[$parts[0]] = $parts[1];
		} else {
		}
	    }
    }
    
    $strippedCountry = stripCountry($result['Country']);
    
    Geolocation_RegisterCountry($strippedCountry);
    
     // 5. add any longlats to the longlatlist
     if (array_key_exists('Longitude', $result) && array_key_exists('Latitude', $result)){ // 5a. use the ones from hpinfo
          Geolocation_InsertCommentLocation($commentIndex, $strippedCountry, $result['City'], $result['Latitude'], $result['Longitude']);

	} elseif(array_key_exists('City', $result) && array_key_exists('Country', $result)){
		Geolocation_InsertCommentLocation($commentIndex, $strippedCountry, $result['City'], 0.0, 0.0);
		
	} elseif(array_key_exists('Country', $result)){
		Geolocation_InsertCommentLocation($commentIndex, $strippedCountry, "?", 0.0, 0.0);
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);


    } else { // 5b. look them up with the google api
	    
    
    }
}

function IPtoLocationEntry_FreeGeoIp($commentIndex, $eachIP){

     echo 'IPtoLocationEntry_FreeGeoIp';

     $response_raw = file("http://freegeoip.net/csv/$eachIP");

     echo $response_raw['0']."<br>";
     
     $responseArray = str_getcsv($response_raw['0']);
     
     $country = $responseArray['2'];
     $city = $responseArray['5'];
     $latitude = $responseArray['7'];
     $longitude = $responseArray['8'];
     
     Geolocation_RegisterCountry($country);
     
	Geolocation_InsertCommentLocation($commentIndex, $country, $city, $latitude, $longitude);
}

function onPostDeletion($commentID){

    global $wpdb;

	$sql = "DELETE
	    FROM       `$wpdb->remarks_comments`
	    WHERE      comment_ID = '$commentID'";

    $wpdb->query($sql);
}

function onPostCreation($commentID){

    global $wpdb;

	$sql = "SELECT  comment_author_IP 
	    FROM       `$wpdb->comments`
	    WHERE      comment_ID = '$commentID'";

    $rawIP = $wpdb->get_results($sql , ARRAY_A);
    
    IPtoLocationEntry_HostIP($commentID, $rawIP[0]['comment_author_IP']);
}

function updateTableRecords(){

    global $wpdb;

    $sql = "SELECT     a.comment_ID, a.comment_author_IP 
	    FROM       `$wpdb->comments` AS a
	    WHERE      NOT EXISTS (SELECT * FROM `$wpdb->remarks_comments` AS b WHERE b.comment_ID = a.comment_ID)  AND a.comment_approved='1'";

    $uninterpretedComments = $wpdb->get_results($sql , ARRAY_A);

    foreach ($uninterpretedComments as $eachComment){
	/*IPtoLocationEntry_HostIP($eachComment['comment_ID'], $eachComment['comment_author_IP']);*/
	IPtoLocationEntry_FreeGeoIp($eachComment['comment_ID'], $eachComment['comment_author_IP']);
    }

}


function populateCityByComments(){
    global $wpdb;
    global $remarks_countries;

    // 0. retrieve the data
    $retrieveComments = "SELECT * FROM $wpdb->remarks_comments WHERE 1";
    $retrieveCountry = "SELECT COUNTRY, COUNT(COUNTRY) AS COUNT FROM `$wpdb->remarks_comments` WHERE COUNTRY != '' GROUP BY COUNTRY";

    // 1. iterate through each comment
    $commentDetails = $wpdb->get_results($retrieveComments, ARRAY_A);	
    $countryDetails = $wpdb->get_results($retrieveCountry, ARRAY_A);
    
    // 2. for each comment, divide the IP address into the city and country
    foreach ($countryDetails as $eachCountry){
	$remarks_countries[$eachCountry['COUNTRY']] = $eachCountry['COUNT'];
    }
    
    foreach ($commentDetails as $eachComment){
    	if (($eachComment['longitude'] > 0 || $eachComment['longitude'] < 0) && ($eachComment['latitude'] > 0 || $eachComment['latitude'] < 0)){
		addLongLatsToMatrix($eachComment['longitude'], $eachComment['latitude']);
	}
    }
    
    // uncomment this
    updateTableRecords();
    
    // 4. order by count
    arsort($remarks_countries);
}


function renderGeolocationCommentsTable(){
    global $remarks_countries;
    
    // draw a table of each city by the number of comments it has
    echo "<h3>Number of Comments by Location</h3>";
    echo "<em>Geolocation powered by <a href='http://www.freegeoip.net/'>FreeGeoIP</a>.</em><br/><br/>";
	echo "<table>";
    	echo "<tr><td><strong>Location</strong></a></td><td><strong>Number of Comments</strong></td></tr>";
	
        foreach($remarks_countries as $countryKey => $eachCountry){
		echo "<tr><td>$countryKey</td><td align='center'>$eachCountry</td></tr>";
	}
	echo "</table><br/>";
	
}

function renderMapByComments(){
    global $remarks_longlats;
    
   // draw a map
    echo'<img src="http://maps.google.com/maps/api/staticmap?center=0,0&zoom=1&size=500x360';
	foreach($remarks_longlats as $long => $pair){
		foreach($pair as $lat => $count){
			echo "&markers=color:blue|label:$count|$lat,$long";
		}
	}
    echo'&sensor=false"/><br/><em>Map powered by <a href="http://lmgtfy.com/?q=google+map+api">Google Map API</a>.<br/>Unfortunately, the above map may be missing the locations of some of your comments. This is because sometimes it\'s impossible to translate the IP address into a geographic location.</em>';

}


function globe_Initialise(){
  global $wpdb;

    // if the table doesn't exist, create it

   $table_name = $wpdb->prefix . "remarks_comments"; 

	$sql = "CREATE TABLE " . $table_name . " (
	  comment_id mediumint(9) NOT NULL,
	  city text NOT NULL,
	  country text NOT NULL,
	  latitude decimal(10,6) NOT NULL,
	  longitude decimal(10,6) NOT NULL,
	  UNIQUE KEY comment_id (comment_id)
	);";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($sql);

}

?>