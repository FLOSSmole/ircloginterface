<!html doctype>
<head>
<link rel="stylesheet" type="text/css" href="tablestyle2.css">
<title>IRC Chat Search</title>
</head>
<style type= 'text/css'>
	#button2 {
		width: 25px;
		height: 27px;
		margin: 0;
		padding: 0;
		border: 0;
		background: transparent url(female2.gif) no-repeat center top;
		overflow:hidden;
		cursor: pointer;
		cursor: hand;
	}
	#button3 {
		width: 25px;
		height: 25px;
		margin: 0;
		padding: 0;
		border: 0;
		background: transparent url(urmom.jpg) no-repeat center top;
		overflow:hidden;
		cursor: pointer;
		cursor: hand;
	}
</style>
<body>

<?php
$messageid = $_GET['mid'];
$searchBy = $_GET['s'];
$datasource = $_GET['datasource'];
$keyword = trim ( $_GET['key'] );
$jokeType = $_GET['j'];
$userid = $_GET['u'];
$getlines = $messageid - 10;
$limit = 11;

$submit = $_GET['submit'];
$submit2 = $_GET['button2'];
$submit3 = $_GET['button3'];
$set_line_num = $_GET['setnum'];
$moreLines = $_GET['lines'];
$afterLines = $_GET['afterlines'];
$newlines = $_GET['lines'];
$newlimit = $_GET['limit'];

if(isset($newlines)){
	$getlines = $newlines;
	$limit = $newlimit;
}

if(isset($moreLines)){
	$getlines = $getlines - 10;
	$limit = $limit + 10;
	
}
if(isset($afterLines)){
	$limit = $limit + 10;
}

//echo $keyword;
//if (isset($submit))

//{
require("login2.php");

// connect to database using credentials from login.php
$dbc = mysqli_connect($db_hostname, 
                        $db_username,   
                        $db_password,  
                        $db_database)      
        or die('Error connecting to database!');

if(!isset($submit) && !isset($submit2) && !isset($submit3)){        
// set up our query
$query = "SELECT send_user, line_message, line_num, datasource_id FROM $searchBy WHERE line_num >= $getlines AND datasource_id = $datasource ORDER BY 3 LIMIT 0, $limit";
//echo "<p>[<b>$query</b>]</p>\n";

$result = mysqli_query($dbc, $query)
        or die('Error with query!');
        

//echo $keyword;

//echo "<input type='submit' value='More' name='submit' onClick='return validate(this.form);'>";
echo "<center><font color='white'>Select a set-up line to the punch-line</font> \n";

echo "<form name='firstform' method='GET' action='messageDisplay2.php'> \n";
echo "<input type='submit' name='lines' value='Add 10 more lines'>";
//add hidden for num of lines to display
echo "<input type = 'hidden' value='$messageid' name='mid'> \n";
echo "<input type = 'hidden' value='$jokeType' name='j'> \n";
echo "<input type = 'hidden' value='$userid' name='u'> \n";
echo "<input type = 'hidden' value=\"$keyword\" name='key'> \n";
echo "<input type = 'hidden' value='$searchBy' name='s'> \n";
echo "<input type = 'hidden' value='$getlines' name='lines'> \n";
echo "<input type = 'hidden' value='$limit' name='limit'> \n";
echo "<input type = 'hidden' value='$datasource' name='datasource'> \n";
echo "</form>";
echo "<table border='1'> \n";
echo "<th>User</th><th>Message</th><th>Select</th> \n";
while($row = mysqli_fetch_array($result))
{
    // pull out particular columns by name
    // these are names of actual columns in the db table
    $first = $row['line_message'];
    $second = $row['send_user'];
    $third = $row['line_num'];
    $fourth = $row['datasource_id'];
    //$second = $row['date']; 
    //$third = $row['subject'];
    //$last = $row['mid'];

    //print first/last to web screen, with line break in between and carriage return at end of line
    echo "<tr> \n";
    $first = str_replace("$keyword", "<font color='red'><b>$keyword</b></font>", "$first");
    echo "<td>$second</td> \n";
    echo "<td>$first</td>";
    //echo "<td><input type='radio' value='$third' name='setnum'></td> \n";
    echo "<td>";
    if($third != $messageid){
    echo "<form method='GET' action='messageDisplay2.php'> \n";
    echo "<input type='submit' name='button2' id='button2' value='' /> ";
    echo "<input type='submit' name='button3' id='button3' value='' /><br> ";
    echo "<input type='submit' name = 'submit' value='Submit'>";
    echo "<input type = 'hidden' value='$third' name='setnum'>\n";
    echo "<input type = 'hidden' value='$fourth' name='datasource'> \n";
    echo "<input type = 'hidden' value='$messageid' name='mid'> \n";
    echo "<input type = 'hidden' value='$jokeType' name='j'> \n";
    echo "<input type = 'hidden' value='$userid' name='u'> \n";
    echo "<input type = 'hidden' value=\"$keyword\" name='key'> \n";
	echo "<input type = 'hidden' value='$searchBy' name='s'> \n";
    echo "</form>";
    }
    else{
	echo "<form method='GET' action='messageDisplay2.php'> \n";
    echo "<input type='submit' name='button2' id='button2' value='' /> ";
    echo "<input type='submit' name='button3' id='button3' value='' /><br> ";
    echo "<input type = 'hidden' value='$third' name='setnum'>\n";
    echo "<input type = 'hidden' value='$fourth' name='datasource'> \n";
    echo "<input type = 'hidden' value='$messageid' name='mid'> \n";
    echo "<input type = 'hidden' value='$jokeType' name='j'> \n";
    echo "<input type = 'hidden' value='$userid' name='u'> \n";
    echo "<input type = 'hidden' value=\"$keyword\" name='key'> \n";
    echo "<input type = 'hidden' value='$searchBy' name='s'> \n";
    echo "</form>";
    }
    
    
    echo "</td>";
    echo "</tr> \n";
}
echo "</table>";


echo "<form name='afterform' method='GET' action='messageDisplay2.php'> \n";
echo "<input type='submit' name='afterlines' value='Add 10 more lines after'>";
//add hidden for num of lines to display
echo "<input type = 'hidden' value='$messageid' name='mid'> \n";
echo "<input type = 'hidden' value='$getlines' name='lines'> \n";
echo "<input type = 'hidden' value='$limit' name='limit'> \n";
echo "<input type = 'hidden' value='$jokeType' name='j'> \n";
echo "<input type = 'hidden' value='$userid' name='u'> \n";
echo "<input type = 'hidden' value=\"$keyword\" name='key'> \n";
echo "<input type = 'hidden' value='$searchBy' name='s'> \n";
echo "<input type = 'hidden' value='$datasource' name='datasource'> \n";
echo "</form>";


echo "</center>";
}



else{
	if(isset($submit)){
		$keyword = mysqli_real_escape_string($dbc, $keyword);
		//echo $keyword;
		$query2 = "INSERT IGNORE INTO talk_twss
					VALUES(
					$datasource,
					$set_line_num,
					$messageid,
					'$keyword',
					'$jokeType',
					'$userid')";
		$result2 = mysqli_query($dbc, $query2)
				 or die('Error with query! [$query2]');
			 
		echo "<font color='white'>Successful Insert into talk_twss database</font>";
	}
	if(isset($submit2)){
		$keyword = mysqli_real_escape_string($dbc, $keyword);
		//echo $keyword;
		$query2 = "INSERT IGNORE INTO talk_twss
					VALUES(
					$datasource,
					NULL,
					$set_line_num,
					'$keyword',
					'$jokeType',
					'$userid')";
		$result2 = mysqli_query($dbc, $query2)
				 or die('Error with query! [$query2]');
		echo "<font color='white'>Successful Insert into talk_twss database</font>";
	}
	if(isset($submit3)){
		$keyword = mysqli_real_escape_string($dbc, $keyword);
		//echo $keyword;
		$query2 = "INSERT IGNORE INTO talk_twss
					VALUES(
					$datasource,
					NULL,
					$set_line_num,
					'$keyword',
					'your_mom',
					'$userid')";
		$result2 = mysqli_query($dbc, $query2)
				 or die('Error with query! [$query2]');
		echo "<font color='white'>Successful Insert into talk_twss database</font>";
	}
}


// close our db connection
mysqli_close($dbc);
//}

?>

</body>
</html>
