<?php

   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/staff.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <title>TitsRP Staff</title>
</head>
<body>
    <br>
    <br>
    <image id="logo" src="images/stafflogo.png">
    <br>
    <br>
    <div class=main>
        <table id = "stafftable" class="stafftable" cellspacing="1" style="width:75%">
            <tbody id="tablebody">
            <tr id="insert" class = "insert">
            <th id="lefttr">User</th>
            <th id="centertr">Rank</th>
            <th id="centertr">Last Login</th>
            </tr>
        </table>
    </div>
</body>
    <script language="javascript">
		if (!sessionStorage.StaffTable){
			$.get("fetch.php",function(data){
				AddTableRow(data);
				sessionStorage.setItem("StaffTable",data);
			});
		}else{
			AddTableRow(sessionStorage.getItem("StaffTable"));
		}
	</script>
</html>