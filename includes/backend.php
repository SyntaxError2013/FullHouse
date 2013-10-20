<?php
	
	//require_once "includes/lib/Unirest.php";
	include "tqo.php";
	include "includes/config.php";
	
	$search_name = $_GET['query'];
	if( $search_name == NULL ) header('location: index.php');

    $search_name = trim($search_name);         //removing unneccesary whitespaces
    $tokens = explode(" ", $search_name);      //break the body into tokens
	
    foreach($tokens as $row) {
		if($toadd == ""){
			$toadd = $toadd.$row;
		}
        else {
			$toadd = $toadd."%20$row";
        }
    }
    
    $results1 = $twitter->get('https://api.twitter.com/1.1/users/search.json?q='.$toadd.'&page=1&count=1');  
	
	//$x = json_decode($results1,true);                                                                //decoding the result of the query
	$required_id = $results1[0]->{'screen_name'};
    //$required_id = $x[0]['screen_name'];                                              //required cid for giving the response
	$required_name = $results1[0]->{'name'};
	$_SESSION['name'] = $required_name;
    $_SESSION['screen_name'] = $required_id;
    $results2 = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=%23'.$required_id.'&result_type=mixed&count=5');
    
	$y = $results2->{'statuses'};
	
    $yyy = array();
    foreach($y as $row1)
            {
                    $yyy[] = $row1->{'text'};
            }    
			                           
	//$response = array();
    foreach ($yyy as $key => $value) {
                    unset ($yyy[$key]);
                    $new_key =  "text".$key;
                    $yyy[$new_key] = $value;
    }
	//var_dump($yyy); 
	//exit;
    $url3 = "http://api.repustate.com/v2/d68427d7e77b4d38f6c789083092afdeb3996850/bulk-score.json";
    /*$demo = array(
        "text1" => "I am feeling good",
        "text2" => "I am feeling very bad"
        ); */ 
    $ch = curl_init ($url3);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $yyy);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $results3 = curl_exec($ch);
    //var_dump($results3);
	$results4 = json_decode($results3,true);
    //var_dump($results4);
	//exit;
	$analysis_array = $results4["results"];
    $results5 = array();
	//var_dump($results5);
	//exit;
    foreach($analysis_array as $key2 => $value2){
            $results5[$key2] = $value2["score"];
    }
    //var_dump($results5);
    sort($results5);
    $sum_negative = 0;
    $sum_positive = 0;
    $sum_neutral = 0;
    foreach($results5 as $key3 => $value3){
        if($value3 < 0.0){
            $sum_negative = $sum_negative + $value3;
            //var_dump($sum_negative);
        }
        elseif($value3 > 0.0){
            $sum_positive = $sum_positive + $value3;
            //var_dump($sum_positive);
        }
        else{
            $sum_neutral =  $sum_neutral + 0.05;
            //var_dump($sum_neutral);
        }
    
    }
    $sum_negative = (-1.0)*($sum_negative);
    $analysis_data = array($sum_negative,$sum_positive,$sum_neutral);
    
	
?>
