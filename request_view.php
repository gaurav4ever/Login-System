<!DOCTYPE html>
<html>
<head>
	<title>Pending Request</title>
	<link rel="stylesheet" type="text/css" href="style/style_portal.css">
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
<?php 
		$val=addslashes($_POST["uname"]);
		$mysql_host='localhost';
		$mysql_user='root';
		$mysql_password='';

		$conn=mysql_connect($mysql_host,$mysql_user,$mysql_password);
		if((!$conn)){
			die('could not connect: '.mysql_error());
		}
		$sql1="UPDATE `NIC_worker_info` SET `flag`=1 WHERE username='$val';";
		$sql2="UPDATE `NIC_worker_info` SET `flag`=0 WHERE username<>'$val';";

		mysql_select_db("nic database");
		$retval1=mysql_query($sql1,$conn);
		$retval2=mysql_query($sql2,$conn);

		//random IP Address gereneration database code
		$sql_ip = "SELECT `IP` FROM `nic_worker_info` WHERE username='Free IP Address'"; 
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
			die('could not enter data<br>'.mysql_error());
		}
		if(!$retval2){
			die('could not enter data<br>'.mysql_error());
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
			<input type="text" id="searchtext1" value="click to get an IP" name="ip" onclick="mFuntion()">
			
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
			<input type="text" id="searchtext7" name="antiVirus">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">MAC: </div>
			<input type="text" id="searchtext8" name="mac" value="'.$mquery['MAC'].'">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Non Nic/ Coordinator: </div> 
			<input type="text" id="searchtext9" name="nonNic">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Connected/ Switch: </div>
			<input type="text" id="searchtext10" name="connectedSwitch">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Issue Date: </div>
			<input type="text" id="searchtext11" name="issueDate">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Reason for change IP: </div>
			<input type="text" id="searchtext12" name="changeIp">
		</div>
	</div>
	<div class="row">
		<div class="col" style="float:left">
			<div class="text_field">Verify IP in NULL: </div>
			<input type="text" id="searchtext13" name="verifyIp">
		</div>
		<div class="col" style="float:right">
			<div class="text_field">Old user detail: </div>
			<input type="text" id="searchtext14" name="oldUserDetails">
		</div>
	</div>

	<center>
		<input type="submit" name="add" value="Approve Request"><br/><br/>
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
 ?>

<script type="text/javascript">
		function mFuntion(){

			var mValue=document.getElementById("temp").value;
			 document.getElementById("searchtext1").value=mValue;
		}
	</script>

</body>
</html>