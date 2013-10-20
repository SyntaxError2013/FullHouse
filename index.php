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
    
     <div class="body">
    	<div class="clear"></div>
    	<div class="body_content">
        	
            <div class="buttons">
            	<div><h2>Enter the name of the politician</h2></div>  
                <div id="form-place">
                	<form id="form-app" action="analysis.php" method="get">
                    	<input type="text" style="width:400px; height: 40px; font-size:18px; padding:5px" placeholder="EnterName" name="query" /><br>
                        <input id="sub" type="submit" class="btn btn-primary" value="submit" />
                    </form>
                </div>           
            </div>
        </div>
    </div>
    
    <?php include "includes/footer.php" ?>
</body>
</html>
