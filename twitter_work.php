<?php
    
	require_once './lib/Unirest.php';
    require('twitteroauth.php'); // path to twitteroauth library
    $consumerkey = 'KHpFcmyQ3vQBVBC1x1mw';
    $consumersecret = 'KDR85GQ4jTLUDVTJvKGQMWTD4EsXMNXkFHRDNzVbobI';
    $accesstoken = '115029858-6OMP0pCQt0VIxmsmaX3jRepx64vfmuyOuTmxgK1C';
    $accesstokensecret = 'EwZwx5WFcqOS4i1gwIAJhBydTboOO2OBMPsacRZnhU';
    $twitter = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
    //$search_name = "which is to be given";
    $search_name=$_REQUEST['search_name'];
    $search_name = trim($search_name);                                                                                    //removing unneccesary whitespaces
    $tokens = explode(" ", $search_name);                                                                                  //break the body into tokens
    foreach($tokens as $row){
        if($toadd == ""){
            $toadd = $toadd.$row;
        }
        else
        {
            $toadd = $toadd."%20$row";
        }
    }
    /* $tweets = $twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=craigbuckler&count=10'); */
   $results1 = $twitter->get('https://api.twitter.com/1.1/users/search.json?q='.$toadd.'&page=1&count=1');  
    //$url1 = "https://api.twitter.com/1.1/users/search.json?q=$toadd&page=1&count=1";    //url for the query
    //var_dump($url1);
    //$ch1 = curl_init($url1);
    //curl_setopt($ch1, CURLOPT_FOLLOWLOCATION , 1);                               // TRUE
    //curl_setopt($ch1, CURLOPT_HEADER ,0);                                                  // DO NOT RETURN HTTP HEADERS
    //curl_setopt($ch1, CURLOPT_RETURNTRANSFER ,1);                                // RETURN THE CONTENTS OF THE CALL
    //$results1 = curl_exec($ch1);
    $x = json_decode($results1,true);                                                                //decoding the result of the query
    $required_id = $x[0]['screen_name'];                                              //required cid for giving the response
    $results2 = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=%23'.$required_id.'&result_type=mixed&count=4');
    //$url2 = "https://api.twitter.com/1.1/search/tweets.json?q=%23$required_id&result_type=mixed&count=4";    //url for the query
    //var_dump($url1);
    //$ch2 = curl_init($url2);
    //curl_setopt($ch2, CURLOPT_FOLLOWLOCATION , 1);                               // TRUE
    //curl_setopt($ch2, CURLOPT_HEADER ,0);                                                  // DO NOT RETURN HTTP HEADERS
    //curl_setopt($ch2, CURLOPT_RETURNTRANSFER ,1);                                // RETURN THE CONTENTS OF THE CALL
    //$results2 = curl_exec($ch2);
    $y = json_decode($results2,true);
    $yy = $y['statuses'];
    $yyy = array();
    foreach($yy as $key => $value)
            {
                    $yyy[] = $yy[$key]['text'];
            }                                                                                                                                                              //assigning them the values
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
                    $dummy_output = json_decode($output,true);
                    $response[$key] = $dummy_output['label'];
            }        
    $analysis_array = array_count_values($response);
    
?>
    