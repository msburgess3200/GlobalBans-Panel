<?php
/*
////////////////////////////////////////////////////////////////
//					GLOBALBANS PUBLIC PANEL
////////////////////////////////////////////////////////////////
*/
	// database information...
	$cfg['data']['host'] = "";
	$cfg['data']['user'] = "";
	$cfg['data']['pass'] = "";
	$cfg['data']['datanase'] = "";
	$cfg['data']['table'] = "banlist";
	$cfg['data']['pconnect'] = false; // allow persisant connections? DEFAULT: FALSE.
	$cfg['data']['limit'] = "0"; // Records per page... if zero (0) turns off pages..
	
	
	// debugging options...
	$cfg['info']['version'] = "0.0.1";
	$cfg['info']['debug'] = true; // debug - true=ON ; false=OFF
	$cfg['info']['connection'] = true; // shows connection status - true=ON ; false=OFF - YOU'LL NEED TO KEEP THIS OFF UNLESS DEBUGGING.

	
	// upcoming feature...
	$cfg['steam']['api'] = "ut_bans"; //steam api here
	
	
	
	
	/* LEAVE EVERYTHING ALONE HERE.... */
	if ($cfg['info']['debug'] == true){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}else{
		error_reporting(0);
		ini_set('display_errors', 0);
	}
	// begin connection...
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "Connecting to... " . $cfg['data']['host'];
		echo "<br />";
	}
	$conn = mysql_connect($cfg['data']['host'], $cfg['data']['user'], $cfg['data']['pass']) or die("<br />ERROR: ". mysql_error());
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "OK!";
		echo "<br />";
		echo "Selecting database... " . $cfg['data']['database'];
	}
	$db = mysql_select_db($cfg['data']['datanase'], $conn) or die("<br />ERROR: ". mysql_error());
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "<br />";
		echo "OK!";
		echo "<br />";
		echo "Connection successful!";
	}
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "<br />";
		echo "Running query...";
	}
	if ($cfg['data']['limit'] == "0"){
		$limit = "";
	}else{
		$limit ="LIMIT " . $cfg['data']['limit'];
	}
	$q = mysql_query("SELECT * FROM `". $cfg['data']['table']."` " . $limit . ";", $conn) or die("<br />ERROR: ". mysql_error());
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "<br />";
		echo "Query successful!";
		echo "<br />";
		echo "Generating table from query...";
	}
	$table1 = mysql_fetch_array($q) or die("<br />ERROR: ". mysql_error());
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "<br />";
		echo "Fetching array...";
		echo "<br />";
		echo "OK!";
	}
	$rows = mysql_num_rows($q) or die("<br />ERROR: ". mysql_error());
	if ($cfg['info']['debug'] == true && $cfg['info']['connection'] == true){
		echo "<br />";
		echo "Detecting number of entries..." . $rows;
		echo "<br />";
		echo "OK!";
	}
	echo "	<center>
		<table border=\"1\" width=\"500\">
	<tr>
		<th scope=\"col\">
				Time / Date
		</th>
		<th scope=\"col\">
				Player
		</th>
		<th scope=\"col\">
				Length
		</th>
		<th scope=\"col\">
				Reason
		</th>
		</tr>";
	while ($table = mysql_fetch_array($q)){
?>
			<tr>
				<td><?php echo $table['banTime']; ?></td>
				<td><?php echo $table['charactername']; ?></td>
				<td><?php if ($table['banDuration'] == NULL){echo "Forever";}else{echo $table['banDuration'];}; ?></td>
				<td><?php echo $table['banMessage']; ?></td>
			</tr>
<?php
	}
	echo "		</table>
	</center>";
	// <------- DO NOT REMOVE THIS OR THE SCRIPT WILL FAIL.
	// we need this at the end of the file so, we can export our HTML table before disconnecting...
	// For servers who don't allow peristant connections...
	if ($cfg['info']['pconnect'] == false){
		if ($cfg['info']['connection'] == true){
			echo "<br />";
			echo "Disconnecting...";
		}
		mysql_close($conn);
	}
?>