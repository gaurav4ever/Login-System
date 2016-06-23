<!DOCTYPE html>
<html>
<head>
	<title>nic </title>
	<link rel="stylesheet" type="text/css" href="style/style_portal.css">
	<style type="text/css">
		table{
			width: 170%;
		}
		td{
			font-size: 15px;
			width: 130px;
			border: 1px solid #d1d1d1;
		}
		.names td{
			color: #3333ff;
			font-size: 18px;
		}
		input{
			background-color: #ADD8E6;
			color: #000000;
		}
	.export{
			float: left;
			width: 300px;
		}
	</style>
</head>
<body>

<img src="img/nic.png" style="width:100%;">
<div class="banner">
		<center>
			<a href="logout_authority.php"><p>Logout</p></a>
		</center>
</div>
<button style="height:25px;width:60px;"><a href="authority_portal.php" style="color:#000000;text-decoration:none;">Back</a></button>
<br><br>
<div class="search_options">
<div class="search">
 	<form method="post" action="show.php" action="submit" class="form">
 	<center class="form_center">
				 Username : 
				<input type="text" name='searchtext' id="searchtext" placeholder="Enter Username" />
				<button type="submit" name="search" id="search" />search</button>
				<br><br>
				Ip Address:
				<input type="text" name='searchtextip' id="searchtextip" placeholder="Enter IP" />
				<button type="submit" name="searchip" id="searchip" />search</button><br><br>
	</center>
	</form>
</div>
<div class="filter">
	<form method="post" action="database_view.php" class="form"> 
	<center class="form_center">
		<button type="submit" name="allocated">Allocated</button><br><br>
		<input type="text" name='search_seagment' id="search_seagment" placeholder="Enter Seagment" />
		<button type="submit" name="segement_all">All</button>
		<button type="submit" name="segment_allocated">Allocated</button><br><br>
		<br>
	</center>
	</form>	
</div>
</div>

<div class="export">
	<a href="ip_view.php"><button>Download as Excel Sheet</button></a>
</div><br>
	<?php 
	session_start();
	require 'connect.php';
	if(isset($_POST['allocated'])){
		$query="SELECT * FROM `nic_worker_info` WHERE username<>'Free IP Address' AND IP NOT LIKE 'AA%'";
	}
	else if(isset($_POST['segement_all'])){
		$ip_segment=$_POST['search_seagment'];
		$query="SELECT * FROM `nic_worker_info` WHERE IP LIKE '$ip_segment%'";
	}
	else if(isset($_POST['segment_allocated'])){
		$ip_segment=$_POST['search_seagment'];
		$query="SELECT * FROM `nic_worker_info` WHERE username<>'Free IP Address' AND IP LIKE '$ip_segment%'";
	}
	else $query="SELECT * FROM `nic_worker_info`";
	//echo $ip_segment;
	
	$_SESSION['query']=$query;

	if($is_query_run=mysql_query($query)){

		$text1='<table>
					<tr class="names">
						<td>IP</td>
						<td>Username</td>
						<td>Location</td>
						<td>Intercom</td>
						<td>Division</td>
						<td>Designation</td>
						<td>Antivirus</td>
						<td>MAC</td>
						<td>Non NIC /<br/>Coordinator</td>
						<td>Connected /<br/>Switch</td>
						<td>Issue Date</td>
						<td>Reason for<br/>change IP</td>
						<td>Verify<br/>Ip in NULL</td>
						<td>Old user<br/>detail</td>
						<td>Issued By</td>
					</tr>
				</table>';
			echo "$text1";
		while($query_execute=mysql_fetch_assoc($is_query_run)){
			//echo 'name: '.$query_execute['Name'].'<br>';
			$text='<table>
						<tr>
							<td>'.$query_execute['IP'].'</td>
							<td>'.$query_execute['username'].'</td>
							<td>'.$query_execute['location'].'</td>
							<td>'.$query_execute['intercom'].'</td>
							<td>'.$query_execute['division'].'</td>
							<td>'.$query_execute['designation'].'</td>
							<td>'.$query_execute['antivirus'].'</td>
							<td>'.$query_execute['MAC'].'</td>
							<td>'.$query_execute['Non NIC/ Coordinator'].'</td>
							<td>'.$query_execute['connected/ switch'].'</td>
							<td>'.$query_execute['issue date'].'</td>
							<td>'.$query_execute['reason for change Ip'].'</td>
							<td>'.$query_execute['verify Ip in NULL'].'</td>
							<td>'.$query_execute['Old user detail'].'</td>
							<td>'.$query_execute['Issued By'].'</td>
						</tr>
					</table>';
			echo "$text";
		}
	}
	else{
		echo "query not executed<br>";
	}

 ?>
 <br>
</body>
</html>