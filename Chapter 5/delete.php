<?php

$id = $_GET['id'];

try{
    
    $mongodb = new Mongo();
    $articleCollection = $mongodb->myblogsite->articles;

} catch (MongoConnectionException $e) {
    
    die('Failed to connect to MongoDB '.$e->getMessage());
}

$articleCollection->remove(array('_id' => new MongoId($id)));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">

            body {
                background-color: #e1ddd9;
                font-size: 12px;
                font-family: Verdana, Arial, Helvetica, SunSans-Regular, Sans-Serif;
                color:#564b47;  
                padding:20px;
                margin:0px;
                text-align: center;
            }

            div#contentarea {
                text-align: left;
                vertical-align: middle;	
                margin: 0px auto;
                padding: 0px;
                width: 550px;
                background-color: #ffffff;
                border: 1px #564b47;
            }

            div#innercontentarea{ padding: 10px 50px; }    
            div#innercontentarea form input[type=text]{width: 435px;}
            div#innercontentarea form textarea {width: 435px;}

        </style>

        <title>Blog Post Creator</title>

    </head>

    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Blog Post Creator</h1>
                <p>
                    Article deleted. _id: <?php echo $id;?>.
                    <a href="dashboard.php">Go back to dashboard?</a>
                </p>
            </div>
        </div>
    </body>
</html>