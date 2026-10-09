 <?php
require_once 'db_conn.php';

$sql = "SELECT * FROM course_table";
$result = $conn->query($sql);

    if(!$result){
        die("SQL Query failed:".$conn->error);
    }

    if(isset($_POST['save'])) {

	$course_name= $_POST['course_name'];
	$duration = $_POST['duration'];
	$cost = $_POST['cost'];

	 if ($course_name === '' || $duration === '' || $cost === '') {
        header("Location: course.php?error=empty");
        exit();
    }
	

	$sql = "INSERT INTO course_table (course_name,duration,cost) 
	VALUES('$course_name','$duration','$cost')";

	if(mysqli_query($conn,$sql)){
        echo"Submission successful!";
		header("Location:course.php?success=1");
	}else{
		echo"error".mysqli_error($conn);
		exit();
	}
	}

 	if(isset($_POST['course_delete'])){
		$course_id = $_POST['course_id'];
		$delete_sql = "DELETE FROM course_table WHERE course_id = '$course_id' ";

		if(mysqli_query($conn,$delete_sql)){
			header("Location: course.php?deleted=1");
			exit();

		}else{
			echo"Error deleting record:".mysqli_error($conn);
			exit();
		}
	}

		if(isset($_POST['update_btn'])){
			$course_id = $_POST['course_id'];
			$course_name = $_POST['course_name'];
			$duration = $_POST['duration'];
			$cost = $_POST['cost'];
		
		$update_sql = "UPDATE course_table SET
		`course_name` ='$course_name',
		`duration` ='$duration',
		`cost`= '$cost'
	 WHERE `course_id`='$course_id'";
	 
		if(mysqli_query($conn,$update_sql)){
			header("Location: course.php?updated=1");
			exit();

		}else{
			echo"Error updating record:".mysqli_error($conn);
			exit();
		}

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
				<a href="stat.php" >Stat Dashboard🖥</a>
				<a href="index.php" >Enquiries</a>
				<a href="course.php" >Courses</a>
				
			</div>

			<a href="Login.html" class="log">Logout</a>
		</div>
	 <nav class="nav1">
        <h1  class="h2">Course Table</h1>
            <table class="table">
                <th class="table1">Course Name</th>
                <th class="table1">Duration</th>
                <th class="table1">Cost</th>
				<th class="table1">
                    
                </th>
                <th class="table1">
                    
                </th>
                <button type="button" class="ahref" onclick="opencourse_EnquiryModal()">➕ Add course</button>
                
                <?php
                if($result && $result->num_rows > 0)
                    {
                        while($row = $result-> fetch_assoc()){

						echo "<tr id='row-".$row['course_id']."'>";
				    echo "<td class='table2' id='course_name-". 
					$row['course_id']."'>"
					.htmlspecialchars($row['course_name'])."</td>";

					echo "<td class='table2' id='duration-". 
					$row['course_id']."'>"
					.htmlspecialchars($row['duration'])."</td>";

					echo "<td class='table2' id='cost-".$row['course_id']."'>"
						.htmlspecialchars($row['cost'])."</td>";

                    echo "<td class='table2'>";
					echo "<button
					onclick='editcourse(" .
					$row['course_id'] . ")'class='edit'>Edit✍🏼</button>";
					echo"</td>";

					echo "<td class='table2'>";
					echo "<button
					onclick='deletecourse(". $row['course_id'].")' class='Delete'>Delete🗑️</button>";
					echo"</td>";   
					?>


            

                
                </tr>
                <?php
                        }
                    }else{
                        echo"<tr><td colspan = '4' class='table2'>No courses Found</td></tr>";
                
                        }
                ?>

			<div id="course_enquirymodal" class="modal-overlay">
				<div class="modal-content">
					<h1 class="h">Courses📝</h1><p>Create a New course </p>	
					<form method ="POST" action="course.php" >	
					<input type = "hidden" name="course_id" id="edit_course_id">
							<label class="lb1">Course</label><br>
							<input type="text" name="course_name" class="input2" id="course_name"><br><br>
							<label class="lb1">Duration</label><br>
							<input type="text" name="duration" class="input2" id="duration"><br><br>
							<label class="lb1">Cost<br>
							<input type="text" name="cost" class="input2" id="cost"><br>
							</label><br>
							<button type="submit" name="save" id="submitBtn"  value = "1" class="btn">
								Save
							</button>
							<button type="button" onclick="closecourse_EnquiryModal()" class="btn">Cancel</button>
						</form>
            	
				</div>
				</div>

                <!-- Delete Confirmation Popup -->
						<div id="deletecourse" class="modal">
							<div class="modal-box">
								<h2>Delete Course</h2>
								<p>Are you sure you want to delete this course?</p>
								<form method="POST" action="course.php">
									<input type="hidden" name="course_id" id="course_id" value="">  
								<div class="modal-buttons">
									<button type="button" class="cancel-btn" onclick="closedeletecourse()">
										Cancel
									</button>

									<button type="submit" class="delete-btn" name="course_delete">
										Delete
									</button>
								</div>
							</form>

							</div>
						</div>

                

                <script src="script.js"></script>
            </table>
        </nav><br>

</body>
</html>