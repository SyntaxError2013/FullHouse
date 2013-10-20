<?php session_start(); ?>
<?php error_reporting(0) ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Know Your Leader</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</head>
<body>

	<?php include "includes/backend.php" ?>
     <script type="text/javascript">
		var sum_negative = <?php echo $sum_negative; ?>;
		sum_negative = parseFloat(sum_negative);
		
		var sum_positive = <?php echo $sum_positive; ?>;
		sum_positive = parseFloat(sum_positive);
		
		var sum_neutral = <?php echo $sum_neutral; ?>;
      	sum_neutral = parseFloat(sum_neutral);
      	
		// Load the Visualization API and the piechart package.
      	google.load('visualization', '1.0', {'packages':['corechart']});

      	// Set a callback to run when the Google Visualization API is loaded.
      	google.setOnLoadCallback(drawChart);

      	// Callback that creates and populates a data table,
      	// instantiates the pie chart, passes in the data and
      	// draws it.
      	
		function drawChart() {

        	// Create the data table.
        	var data = new google.visualization.DataTable();
        	data.addColumn('string', 'Opinion');
        	data.addColumn('number', 'value');
        	data.addRows([
          		['Favour', sum_positive],
          		['DisFavour', sum_negative],
          		['Neutral', sum_neutral]
        	]);

        	// Set chart options
        	var options = {'title':'How People Rate',
                       'width':400,
                       'height':300};

        	// Instantiate and draw our chart, passing in some options.
        	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
       	 	chart.draw(data, options);
      	}
    </script>   

    <div class="header">
    <div class="header_top">
       	<div class="social">
        	<a href="#"><button class="btn btn-small btn-warning" style="margin-top: 2px;">Login</button></a>
            <a href="https://www.facebook.com/dosw.iitr?fref=ts" target="_blank"><img src="images/google.png" width="30px"  height="25px" style="margin-top: 2px;" /></a>
        </div>
    </div>
    		
    <div class="header_content">
         <div class="logo">
                <img src="images/leader.jpg" width="150px" height="150px" style="margin-top:15px;" />
         </div>
                
         <div class="title">
         	<h1><?php echo $_SESSION['name']; ?></h1>
         </div>
     </div>
        
	</div>
    
    <div class="body">
    	<div class="body_content">
        	<div id="chart_div" style="background-color:#FFF; width:400px; height:300px; margin-top:10px; margin-left: 10px;"></div>
            <div id="twitter_feed" style="background-color:#FFF; width:300px; height:300px; margin-top:10px;float:right">
            	<a class="twitter-timeline" width="300px" height="300px" href="https://twitter.com/desirecool219/politicians"  data-widget-id="391828279025344512">Recent Tweets</a>

</div>
        </div>
    </div>
    
    
    <?php include "includes/footer.php" ?>
    
</body>
</html>