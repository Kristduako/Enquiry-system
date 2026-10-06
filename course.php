<?php
require_once 'db_conn.php';

$sql = "SELECT course_name,duration,cost,no_enquiries FROM enquiry_details_view";
$result = $conn->query($sql);

    if(!$result){
        die("SQL Query failed:".$conn->error);
    }


?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Course
	</title>
	<link rel="stylesheet" type="text/css" href="Course.css">
</head>
<body>
	<h1 class="h1">Enquiries course Table🖥<img src="gi kace.jpeg" class="img"><br></h1>
	<div>
			<div class="sidenav">
				<input type="Search" placeholder="Search Enquires 🔍" name="Search" class="input"><button type="submit" class="btn">Search</button><br><br></h1><br>
				<a href="stat.html" >Stat Dashboard🖥</a>
				<a href="index.php" >Enquiries</a>
				<a href="course.php" >Courses</a>
				
			</div>

			<a href="Login.html" class="log">Logout</a>
		</div>
	 <nav class="nav1">
        <h1  class="h">Course Table</h1>
            <table class="table">
                <th class="table1">Course Name</th>
                <th class="table1">Duration</th>
                <th class="table1">Cost</th>
                <th class="table1">Number of enquiries</th>

                <?php
                if($result && $result->num_rows > 0)
                    {
                        while($row = $result-> fetch_assoc()){
                ?>
                <tr>
                <td class="table2"><?php echo htmlspecialchars($row["course_name"]); ?></td>
                <td class="table2"><?php echo htmlspecialchars($row["duration"]); ?></td>
                <td class="table2"><?php echo htmlspecialchars($row["cost"]); ?></td>
                <td class="table2"><?php echo htmlspecialchars($row["no_enquiries"]); ?></td>
                </tr>
                <?php
                        }
                    }else{
                        echo"<tr><td colspan = '4' class='table2'>No courses Found</td></tr>";
                
                        }
                ?>
            </table>
        </nav><br>

</body>
</html>