<?php
	
	require_once "lib/Unirest.php";
	include "tqo.php";
	include "config.php";
	
	//$search_name = $_GET['query'];
	//if( $search_name == NULL ) header('location: index.php');
	$search_name = "Sushma Swaraj";
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
	
    $_SESSION['screen_name'] = $required_id;
    $results2 = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=%23'.$required_id.'&result_type=mixed&count=5');
    var_dump($results2);
	exit;
	$y = $results2->{'statuses'};
	var_dump($y);
	exit;
	//$y = json_decode($results2,true);
    
	//$yy = $y['statuses'];
    $yyy = array();
    foreach($y as $row1)
            {
                    $yyy[] = $row1->{'text'};
            }    
			                           
	$response = array();
        //$response_output = array();
        foreach($yyy as $key => $value)
            {
                    $output = Unirest::post(
                            "https://japerk-text-processing.p.mashape.com/sentiment/",
                            array(
                                        "X-Mashape-Authorization" => "nxI9toagr6TJO9gGBEWTyD66YloVuOp4"
                            ),
                            array(
                                        "text" => $yyy[$key],
                                        "language" => "english"
                            )
                    );
                    //$dummy_output = json_decode($output,true);
					//var_dump($output);
					//$response[$key] = $output->{'label'};
					//var_dump($response[$key]);
                    //$response[$key] = $dummy_output['label'];
            }        

    foreach ($yyy as $key => $value) {
                    unset ($yyy[$key]);
                    $new_key =  "text$key";
                    $yyy[$new_key] = $value;
    } 
    $url3 = "http://api.repustate.com/v2/d68427d7e77b4d38f6c789083092afdeb3996850/bulk-score.json";
    /*$demo = array(
        "text1" => "I am feeling good",
        "text2" => "I am feeling very bad"
        ); */ 
    $ch = curl_init ($url3);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $yyy);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $results3 = curl_exec ($ch);
    $results4 = json_decode($results3,true);
    $analysis_array = $results4["results"];
    $results5 = array();
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
            $sum_neutral =  $count + 0.05;
            //var_dump($sum_neutral);
        }
    
    }
    $sum_negative = (-1.0)*($sum_negative);
    $analysis_data = array($sum_negative,$sum_positive,$sum_neutral);
    
	
?>
