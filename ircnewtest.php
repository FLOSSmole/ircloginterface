<!html doctype>
<head>
<link rel="stylesheet" type="text/css" href="newStyle.css">
<title>IRC Chat Log Search</title>
<script type="text/javascript">

var newwindow;
function poptastic(url)
{
	newwindow=window.open(url,'Chat Log','width=700, height=500, left=800, top=300');
	if (window.focus) {newwindow.focus()}
}

</script>
</head>
<body>

<?php

require("login2.php");
$dbc = mysqli_connect($db_hostname, 
                        $db_username,   
                        $db_password,  
                        $db_database);


$keyword = trim( $_POST['keyword'] );
$searchBy = $_POST['searchBy'];
$searchBy2 = $_POST['searchBy2'];
$sortBy = $_POST['sortBy'];
$jokeType = $_POST['jokeType'];
$jokeType2 = $_POST['jokeType2'];
$userName = $_POST['user_id'];
$wholeWord = $_POST['singleWord'];
$current = $_POST['lastloc'];
$desc = '';
$submit = $_POST['submit'];
$submit2 = $_POST['submit2'];

if(isset($wholeWord)){
	$keyword = " " . $keyword . " ";
}

if ($sortBy == 'date'){
	$desc = 'DESC';
}


echo "<div id='form1' align='left'>";
echo "<span id='fillOut'>";
echo "<h2>Search for Jokes</h2>";
echo "<form method='post' action='ircnewtest.php'>";
echo "<p>";

if(isset($userName)){
	echo "<label for='user_id'>Your name:</label>	<input type='text' id='user_id' name='user_id' value = '$userName' class='two'>";
}
else{
	echo "<label for='user_id'>Your name:</label>	<input type='text' id='user_id' name='user_id' class='two'>";
}
echo "</p>";
echo "<p>";
if(isset($keyword)){
	$keyword2 = htmlspecialchars($keyword, ENT_QUOTES);
	echo "<label for='keyword'>Search keyword:</label><input type='text' id= 'keyword' name='keyword' value='$keyword2' class='two'>";
}
else{
	echo "<label for='keyword'>Search keyword:</label><input type='text' id= 'keyword' name='keyword' class='two'>";
}
echo "</p>";
echo "<input type='checkbox' name='singleWord' value='Yes'><font size=2>Match whole word only</font>";
echo "<p>";
echo "<label for='jokeType'>Joke type:</label><select id='jokeType' name='jokeType' class='one'>";
echo "<option value='your_mom'";
if($jokeType == 'your_mom'){
	echo " selected";
}
echo ">Your mom</option>";
echo "<option value='thats_what_she_said'";
if($jokeType == 'thats_what_she_said'){
	echo " selected";
}
echo ">That's what she said</option>";
echo "<option value='gender_stereotype'";
if($jokeType == 'gender_stereotype'){
	echo " selected";
}
echo ">Gender sterotype</option>";
echo "</select>";
echo "</p>";
echo "<p>";
echo "<label for='searchBy'>List:</label><select id='searchBy' name='searchBy' class='one'>";


          
$tableselect = "SELECT table_name, display_name FROM IRCtablelist";

$tableresult = mysqli_query($dbc, $tableselect)
        or die('Error with query!');
        
while($row = mysqli_fetch_array($tableresult))
{        
	$first = $row['table_name'];
	$second = $row['display_name'];
	
	echo "<option value='$first'";
	if($searchBy == $first){
		echo " selected";
	}
	echo ">$second</option>";
}



echo "</select>";
echo "</p>";
echo "<p>";
echo "<label for='sortBy'>Sort by:</label><select id='sortBy' name='sortBy' class='one'>";
echo "<option value='date_of_entry'";
if($sortBy == 'date_of_entry'){
	echo " selected";
}
echo ">Date</option>";
echo "<option value='send_user'";
if($sortBy == 'send_user'){
	echo " selected";
}
echo ">Sender</option>";
echo "</select>";
echo "</p>";
echo "<p>";
echo "<input type='submit' value='Submit' name='submit'>";
echo "</p>";
echo "<input type='hidden' name='lastloc' value='0'>";
echo "</form>";

echo "<h2>Display Jokes</h2>";
echo "<form method='post' action='ircnewtest.php'>";
echo "<p>";
echo "<label for='searchBy'>Pick a List:</label><select id='searchBy2' name='searchBy2' class='one'>";



          
$tableselect2 = "SELECT table_name, display_name FROM IRCtablelist";

$tableresult2 = mysqli_query($dbc, $tableselect2)
        or die('Error with query!');
        
while($row = mysqli_fetch_array($tableresult2))
{        
	$first = $row['table_name'];
	$second = $row['display_name'];
	
	echo "<option value='$first'";
	if($searchBy2 == $first){
		echo " selected";
	}
	echo ">$second</option>";
}


echo "</select>";
echo "</p>";
echo "<p>";
echo "<label for='jokeType'>Pick Joke type:</label><select id='jokeType2' name='jokeType2' class='one'>";
echo "<option value='your_mom'";
if($jokeType2 == 'your_mom'){
	echo " selected";
}
echo ">Your mom</option>";
echo "<option value='thats_what_she_said'";
if($jokeType2 == 'thats_what_she_said'){
	echo " selected";
}
echo ">Thats what she said</option>";
echo "<option value='gender_stereotype'";
if($jokeType2 == 'gender_stereotype'){
	echo " selected";
}
echo ">Gender sterotype</option>";
echo "</select>";
echo "</p>";
echo "<p>";
echo "<input type='submit' value='Submit' name='submit2'>";
echo "</p>";
echo "</form>";


echo "</span>";
echo "</div>";


echo "<div id='form2' name='form2' align='right'>";




if (isset($submit))

{


$keyword2 = mysqli_real_escape_string($dbc, $keyword);
        
// set up our query
$select = "SELECT date_of_entry, time_of_entry, send_user, line_num, datasource_id, line_message FROM $searchBy WHERE line_message LIKE '%$keyword2%' ORDER BY $sortBy $desc LIMIT 0,500";
//echo "<p>[<b>$query</b>]</p>\n";

$result = mysqli_query($dbc, $select)
        or die('Error with query!');



$newkeyword = urlencode($keyword2);

echo "<table border='1'>";
echo "<th>Date</th><th>Time</th><th>Sender</th><th>Message</th><th>Editor</th>";


while($row = mysqli_fetch_array($result))
{
    // pull out particular columns by name
    // these are names of actual columns in the db table
    $first = $row['date_of_entry'];
    $second = $row['time_of_entry']; 
    $third = $row['send_user'];
    $fourth = $row['line_num'];
    $fifth = $row['datasource_id'];
    $last = $row['line_message'];


    //print first/last to web screen, with line break in between and carriage return at end of line
    echo "<tr>";

    $last = str_ireplace("$keyword", "<font color='red'>$keyword</font>", "$last");
    echo "<td>$first</td><td>$second</td><td>$third</td><td><a href=javascript:poptastic('messageDisplay2.php?mid=$fourth&datasource=$fifth&s=$searchBy&j=$jokeType&u=$userName&key=$newkeyword')>$last</a></td><td>";

$userOut = "";

$select2 = "SELECT datasource_id, punch_line_num, user FROM talk_twss";

$result2 = mysqli_query($dbc, $select2)
		or die('Error with query!');


		while($row2 = mysqli_fetch_array($result2))
	{
		$one = $row2['datasource_id'];
		$two = $row2['punch_line_num'];
		$three = $row2['user'];

		if($two == $fourth && $one == $fifth){
			if($three == 'Becca' || $three == 'becca'){
				$userOut = " " . $three;
				echo "<font color='purple'>$userOut</font>";
				//echo $three;
			}
			elseif($three == 'Megan' || $three == 'megan'){
				$userOut = " " . $three;
			echo "<font color='red'>$userOut</font>";
			}
			else{
				$userOut = " " . $three;
				echo $userOut;
			}
		}
	}
	echo "</td></tr>";
}

echo "</table>";

}

if(isset($submit2)){
        
$select3 = "SELECT a.datasource_id, a.date_of_entry, a.send_user, a.line_message, b.search_keyword, b.joke_type FROM $searchBy2 a JOIN talk_twss b ON a.datasource_id=b.datasource_id AND (a.line_num = b.set_line_num OR a.line_num = b.punch_line_num) WHERE (a.line_num = b.set_line_num OR a.line_num=b.punch_line_num) AND b.joke_type = '$jokeType2'";
//echo "<p>[<b>$select3</b>]</p>\n";

$result3 = mysqli_query($dbc, $select3)
        or die('Error with query!');

echo "<center>Results \n";

echo "<table border='1' id='table1'> \n";
echo "<th>Date</th><th>User</th><th>Message</th><th>User2</th><th>Message2</th> \n";
$countNum = 1;
while($row = mysqli_fetch_array($result3))
{
    // pull out particular columns by name
    // these are names of actual columns in the db table
    
    $first = $row['date_of_entry'];
    $second = $row['joke_type'];
    $third = $row['send_user'];
    $fourth = $row['line_message'];
    $fifth = $row['search_keyword'];
	

    //print first/last to web screen, with line break in between and carriage return at end of line
if($second != 'gender_stereotype'){  
    if ($countNum % 2 != 0) {
	    echo "<tr> \n";
    	echo "<td>$first</td> \n";
    	echo "<td>$third</td>";
    	$fourth = str_ireplace("$fifth", "<font color='red'><b>$fifth</b></font>", "$fourth");
    	echo "<td>$fourth</td>";
	}
	else{
		echo "<td>$third</td>";
		$fourth = str_ireplace("$fifth", "<font color='red'><b>$fifth</b></font>", "$fourth");
		echo "<td>$fourth</td>";
    	echo "</tr> \n";
	}
}

else{
	if ($countNum % 2 != 0) {
	    echo "<tr> \n";
    	echo "<td>$first</td> \n";
    	echo "<td>$third</td>";
    	$fourth = str_ireplace("$fifth", "<font color='red'><b>$fifth</b></font>", "$fourth");
    	echo "<td>$fourth</td>";
	}
	else{
    	echo "</tr> \n";
	}
}
$countNum++;
}
echo "</table>";
echo "</center>";


}
echo "</div>";

mysqli_close($dbc);


?>

</body>
</html>
