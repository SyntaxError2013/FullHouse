<?php session_start(); ?>

<?php
	
	require_once "includes/lib/Unirest.php";
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
    
    $results1 = $twitter->get('https://api.twitter.com/1.1/users/search.json?q="'.$toadd.'"&page=1&count=1');  
	
	//$x = json_decode($results1,true);                                                                //decoding the result of the query
	$required_id = $results1[0]->{'screen_name'};
    //$required_id = $x[0]['screen_name'];                                              //required cid for giving the response
	
    $_SESSION['screen_name'] = $required_id;
    $results2 = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=%23'.$required_id.'&result_type=mixed&count=4');
    
	$y = $results2->{'statuses'};
	
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
					var_dump($output);
					//$response[$key] = $output->{'label'};
					//var_dump($response[$key]);
                    //$response[$key] = $dummy_output['label'];
            }        
			exit;
    $analysis_array = array_count_values($response);		
?>