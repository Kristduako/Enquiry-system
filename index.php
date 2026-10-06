<?php
require_once 'db_conn.php';

$sql = "SELECT * FROM enquiries";
$result = $conn->query($sql);

if(isset($_POST['save'])) {

	$name = $_POST['name'];
	$course = $_POST['course'];
	$date = $_POST['date'];
	$status = $_POST['status'];
	$contact = $_POST['contact'];
	$address = $_POST['address'];

	$sql = "INSERT INTO enquiries (name,course,date,status,contact,address) 
	VALUES('$name','$course','$date','$status','$contact','$address')";

	if(mysqli_query($conn,$sql)){

		header("Location:index.php?success=1");
	}else{
		echo"error".mysqli_error($conn);
		exit();
	}
}

	if(isset($_POST['confirm_Delete'])){
		$enquiry_id = $_POST['enquiry_id'];
		$delete_sql = "DELETE FROM enquiries WHERE enquiry_id = '$enquiry_id' ";

		if(mysqli_query($conn,$delete_sql)){
			header("Location: index.php?deleted=1");
			exit();

		}else{
			echo"Error deleting record:".mysqli_error($conn);
			exit();
		}

	}

if(isset($_POST['update_btn'])){
	$enquiry_id = $_POST['enquiry_id'];
	$name = $_POST['name'];
	$course = $_POST['course'];
	$date = $_POST['date'];
	$status = $_POST['status'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];
	

	$update_sql = "UPDATE enquiries SET
	 `name` ='$name',
	 `course` ='$course',
	 `date`= '$date',
	 `status` = '$status',
	 `address`='$address',
	 `contact` ='$contact'
	 
	 WHERE `enquiry_id`='$enquiry_id'";
	 
		if(mysqli_query($conn,$update_sql)){
			header("Location: index.php?updated=1");
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
		<title>Enquir Dashboard🖥</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	
	</head>
	<body style="margin: 0;">
		<div>
			<div class="sidenav">
				<input type="Search" placeholder="Search Enquires 🔍" name="Search" class="input"><button type="submit" class="btn">Search</button><br><br></h1><br>
				<a href="stat.html" >Stat Dashboard🖥</a>
				<a href="index.php" >Enquiries</a>
				<a href="course.php" >Courses</a>
				
			</div>

			<a href="Login.html" class="log">Logout</a>
		</div>
		
        <nav>
		      <h1 class="new1">Enquiries System View🖥<img src="gi kace.jpeg" class="img"><br>
        </nav><br>
        <div class="nav1">
            <h1 class="h1">Enquiry Table</h1>
			<div >
		  <table class="table">
			<tr id="record-1"  >
                <th class="table1" >
                    Name
                </th>
                <th class="table1" >
                	Course
                </th>
                <th class="table1" >
                	Date
                </th>
                <th  class="table1" >
                	Status

                </th>
                <th class="table1" >
                	Contact
                </th>
				<th class="table1" >
                	Address
                </th>
                <th class="table1">
                    
                </th>
                <th class="table1">
                    
                </th>
				<button type="button" class="ahref" onclick="openEnquiryModal()">➕ New Enquiry</button>
            </tr>

			
			<?php
			if($result->num_rows > 0){
				while($row = $result-> fetch_assoc()){

				    echo "<tr id='row-".$row['enquiry_id']."'>";
				    echo "<td class='table2' id='name-". 
					$row['enquiry_id']."'>"
					.htmlspecialchars($row['name'])."</td>";
					echo "<td class='table2' id='course-". 
					$row['enquiry_id']."'>"
					.htmlspecialchars($row['course'])."</td>";
					echo "<td class='table2' id='date-".
					 $row['enquiry_id']."'>"
					 .htmlspecialchars($row['date'])."</td>";
					echo "<td class='table2' id='status-".
					 $row['enquiry_id']."'>"
					 .htmlspecialchars($row['status'])."</td>";
					echo "<td class='table2' id='contact-".
					 $row['enquiry_id']."'>"
					 .htmlspecialchars($row['contact'])."</td>";
					echo "<td class='table2' id='address-". 
					$row['enquiry_id']."'>"
					.htmlspecialchars($row['address'])."</td>";

					
					echo "<td class='table2'>";
					echo "<button
					onclick='editRecords(" .
					$row['enquiry_id'] . ")'class='edit'>✍🏼</button>";
					echo"</td>";

					echo "<td class='table2'>";
					echo "<button
					onclick='deleteRecords(". $row['enquiry_id'].")' class='Delete'>🗑️</button>";
					echo"</td>";
					
				}

			} else {
				echo"<tr><td colspan='8'> No enquiries found </td></tr>";
			}
			?>
			</table>
			</div>
			</div>
			//add new enquiry//

			<div id="enquiryModal" class="modal-overlay">
				<div class="modal-content">
					<h1 class="h1">ENQUIRY FORM 📚</h1><p>Create a New Enquiry Form </p>
						
					<form method ="POST" action="index.php" >
						<input type = "hidden" name="enquiry_id" id="edit_enquiry_id">
							<label class="lb1">Name</label><br>
							<input type="text" name="name" class="input2" id="name"><br>
							
							<label class="lb1">Course</label><br>
							<SELECT Name="course" class="input2" id="course">
								<option value="">Selecct Course</option>
								<option value="OPS">OPS</option>
								<option value="CISA(weekdays)">CISA(weekdays)</option>
								<option value="CISA(weekdends)">CISA(weekdends)</option>
								<option value="CCNA(weekdays)">CCNA(weekdays)</option>
								<option value="CCNA(weekends)">CCNA(weekends)</option>
								<option value="CSD">CSD</option>
								<option value="Cyber security">Cyber security</option>
							</SELECT><br>

							<label class="lb1">Date 📅</label><br>
							<input type="Date" name="date" class="input2" id="date"><br>

							<label class="lb1">Status🟢</label><br>
							<input list="Status" name="status" placeholder="Status" class="input2" id="status"><br>
							<datalist id="Status">
							<option value="Cancelled"></option>
							<option value="Registered"></option>
							<option value="Pending"></option>
							</datalist>

							<label class="lb1">Address
							<input type="text" name="address" class="input2" id="address"><br>
							</label>
		
							<label class="lb1">Contact📞</label><br>
							<input type="text" name="contact" class="input2" id="contact"><br><br>
							
							<button type="submit" name="save" id="submitBtn"  value = "1" class="btn">
								Save
							</button>
							<button type="button" onclick="closeEnquiryModal()" class="btn">Cancel</button>
						</form>
            	
				</div>

			</div>
			```html
						<!-- Delete Confirmation Popup -->
						<div id="deleteModal" class="modal">
							<div class="modal-box">
							

								<h2>Delete Enquiry</h2>

								<p>Are you sure you want to delete this enquiry?</p>
								<form method="POST" action="index.php">
									<input type="hidden" name="enquiry_id" id="modal_enquiry_id" value="">  

								

								<div class="modal-buttons">
									<button type="button" class="cancel-btn" onclick="closeDeleteModal()">
										Cancel
									</button>

									<button type="submit" class="delete-btn" name="confirm_Delete">
										Delete
									</button>
								</div>
							</form>

							</div>
						</div>
						```

		
				
		<script src="script.js"></script>
            
	</body>
</html>