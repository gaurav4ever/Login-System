<!DOCTYPE html>
<html>
<head>
	<title>View Request</title>
	<link rel="stylesheet" type="text/css" href="style/style_portal.css">
	<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	<style type="text/css">
		#temp{
			visibility: hidden;
		}
		.form_request{
			height: 460px;
		}
	</style>
</head>
<body>
<img src="img/nic.png" style="width:100%">
<div class="banner">
		<center>
			<a href="logout_authority.php"><p>Logout</p></a>
		</center>
</div>
<button style="height:25px;width:60px;"><a href="request_page.php" style="color:#000000; text-decoration:none;">Back</a></button><br>
<?php 
	session_start();

	$auth_name=$_SESSION['username'];
		//current date picker
		$mydate=getdate(date("U"));
		$issueDate_val=$mydate['mday'].'/'.$mydate['mon'].'/'.$mydate['year'];

	if(isset($_POST['uname'])){
		$val=addslashes($_POST["uname"]);
		
		require 'connect.php';
		mysql_select_db('nic database');
		$sql1="UPDATE `NIC_worker_info` SET `flag`=1 WHERE username='$val';";
		$retval1=mysql_query($sql1);

		$sql2="UPDATE `NIC_worker_info` SET `flag`=0 WHERE username<>'$val';";
		$retval2=mysql_query($sql2);

		//random IP Address gereneration database code
		$sql="SELECT `division` FROM `nic_worker_info` WHERE flag=1";
		$retval_sql=mysql_query($sql);

		if(!$retval_sql){
			die('Server error'.mysql_error());
		}
		$mquery_sql=mysql_fetch_array($retval_sql);
		$mDivison=$mquery_sql['division'];
		$sql_ip = "SELECT * FROM `nic_worker_info` WHERE username='Free IP Address'"; 

		$retval_ip=mysql_query($sql_ip);

		if($retval_ip){
			$a=array();
			while($mquery_ip=mysql_fetch_array($retval_ip)){
				array_push($a,$mquery_ip['IP']);
			}
			$count=sizeof($a);
			// echo $count;
			// print_r($a);
			if($count!=1){
				$index=rand(0,$count-1);
				$aindex=$a[$index];
			}
			else
				$aindex=$a[0];
		}
		else {
			echo "error";
		}
		//random IP Address gereneration database code 
		//finished


		if(!$retval1){
			die('Server error<br>'.mysql_error());
		}
		if(!$retval2){
			die('Server error<br>'.mysql_error());
		}
		$sql_fetch="SELECT * FROM `NIC_worker_info` WHERE flag=1";
		$retval3=mysql_query($sql_fetch);
		if($retval3){
			$mquery=mysql_fetch_assoc($retval3);
			$text='
				<input type="text" id="temp" value="'.$aindex.'">
				<form method="post" class="form_request" action="approve_request.php" action="submit">
			<div class="container">
	<h1 class="header">Pending Requests</h1><br/>
	
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Ip Add. :</div>
			<input type="text" id="searchtext1" placeholder="click to get an IP" name="ip" onclick="mFuntion()" required>
			
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Username: </div>
			<input type="text" id="searchtext2" name="username" value="'.$mquery['username'].'">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Location: </div>
			<input type="text" id="searchtext3" name="location" value="'.$mquery['location'].'">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Intercom: </div>
			<input type="text" id="searchtext4" name="intercom" value="'.$mquery['intercom'].'">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Division: </div>
			<input type="text" id="searchtext5" name="division" value="'.$mquery['division'].'">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Designation: </div>
			<input type="text" id="searchtext6" name=" designation" value="'.$mquery['designation'].'">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">AntiVirus: </div>
			<input type="text" id="searchtext7" name="antiVirus" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">MAC: </div>
			<input type="text" id="searchtext8" name="mac" value="'.$mquery['MAC'].'">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Non Nic/ Coordinator: </div> 
			<input type="text" id="searchtext9" name="nonNic" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Connected/ Switch: </div>
			<input type="text" id="searchtext10" name="connectedSwitch" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Issue Date: </div>
			<input type="text" id="searchtext11" name="issueDate" value="'.$issueDate_val.'">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Reason for change IP: </div>
			<input type="text" id="searchtext12" name="changeIp" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Verify IP in NULL: </div>
			<input type="text" id="searchtext13" name="verifyIp" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Old user detail: </div>
			<input type="text" id="searchtext14" name="oldUserDetails" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Issued By :  </div>
			<input type="text" id="searchtext15" name="issuedBy" value='.$auth_name.'>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Connected Port: </div>
			<input type="text" id="searchtext16" name="connectedPort" required>
		</div>

	</div>
	<br>
	<center>
		<input type="submit" name="add" value="Approve Request"><br/>
	</center>
		</div>
		</form>
		<center>
		<button type="submit" id="show_database"><a href="database_view.php">View Database</a></button>
		</center>
		'
		;
		echo $text;
		}
	}


	else{
			include 'connect.php';
			mysql_select_db('nic database');
			$sql_ip = "SELECT * FROM `nic_worker_info` WHERE username='Free IP Address'"; 
		$retval_ip=mysql_query($sql_ip);
		if($retval_ip){
			$a=array();
			while($mquery_ip=mysql_fetch_array($retval_ip)){
				$b=array($mquery_ip['division'],$mquery_ip['IP']);
				array_push($a,$b);
			}
		}
		else die("connection error!");
		$default_option="Select Division";
		$aindex='';

		$text='<form method="post" action="approve_request.php">
			<div class="container">
	<h1 class="header">Pending Requests</h1><br/>
	
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Ip Add. :</div>
			<input type="text" id="searchtext1" placeholder="select division first" name="ip"  required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Username: </div>
			<input type="text" id="searchtext2" name="username" >
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Location: </div>
			<input type="text" id="searchtext3" name="location">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Intercom: </div>
			<input type="text" id="searchtext4" name="intercom">
		</div>
	</div>


	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Division: </div>
			<select name="division" id="box" onChange="getIP(this.value)">
				<option disabled selected>select division</option>
				<option name=" INOC" onclick="getIP()">INOC</option>
				<option name="lib" onclick="getIP()">Library</option>
				<option name="ssk" onclick="getIP()">SSK</option>
			</select>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Designation: </div>
			<input type="text" id="searchtext6" name=" designation" value="">
		</div>
	</div>


	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">AntiVirus: </div>
			<input type="text" id="searchtext7" name="antiVirus" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">MAC: </div>
			<input type="text" id="searchtext8" name="mac">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Non Nic/ Coordinator: </div> 
			<input type="text" id="searchtext9" name="nonNic" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Connected/ Switch: </div>
			<input type="text" id="searchtext10" name="connectedSwitch" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Issue Date: </div>
			<input type="text" id="searchtext11" name="issueDate" value="'.$issueDate_val.'">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Reason for change IP: </div>
			<input type="text" id="searchtext12" name="changeIp" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Verify IP in NULL: </div>
			<input type="text" id="searchtext13" name="verifyIp" required>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Old user detail: </div>
			<input type="text" id="searchtext14" name="oldUserDetails" required>
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Issued By :  </div>
			<input type="text" id="searchtext15" name="issuedBy" value='.$auth_name.'>
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Connected Port: </div>
			<input type="text" id="searchtext16" name="connectedPort" required>
		</div>
	</div>
	<br>
	<center>
		<input type="submit" name="add" value="Approve Request"><br/>
	</center>
		</div>
	</form>
		';
		echo $text;
	}
 ?>

<script type="text/javascript">
		function mFuntion(){
			var mValue=document.getElementById("temp").value;
			 document.getElementById("searchtext1").value=mValue;
		}
		function getIP(value_division){
			var products = <?php echo json_encode( $a ) ?>;
			var p=[];
			for(var i=0;i<products.length;i++){
				if(products[i][0]==value_division){
					p.push(products[i][1]);
				}
			}
			var r=Math.floor((Math.random() * p.length-1) + 1);
			var ip=p[r];
			document.getElementById("searchtext1").value=ip;
		}
	</script>

</body>
</html>