<?php session_start(); ?>
<?php error_reporting(0) ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Hack-App</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    
</head>
<body>
    <?php include "includes/header.php" ?>
    
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
	
    <div class="body">
    	<div class="clear"></div>
    	<div class="body_content">
        	<div id="chart_div" style="width:400; height:300"></div>
            
        </div>
    </div>
    
    <?php include "includes/footer.php" ?>
</body>
</html>