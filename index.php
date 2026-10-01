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
				<a href="index.html" >Enquiries</a>
				<a href="course.html" >Courses</a>
				
			</div>

			<a href="Login.html" class="log">Logout</a>
		</div>
		
        <nav>
		      <h1 class="new1">Enquiries System View🖥<img src="gi kace.jpeg" class="img"><br>
        </nav><br>
        <div class="nav1">
            <h1 class="h1">Enquiry Table</h1>
			<div class=scrollable-table>
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
				    echo "<td class='table2' id='name- ". 
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

					
					echo "<td class='table1'>";
					echo "<button
					onclick='editRecords(" .
					$row['enquiry_id'] . ")'
					class='edit'>✍🏼</button>";
					echo"</td>";

					echo "<td class='table1'>";
					echo "<button
					onclick='deleteRecords(" .
					$row['enquiry_id'] . ")'
					class='Delete'>🗑️</button>";
					echo"</td>";
					
				}

			} else {
				echo"<tr><td colspan='8'> No enquiries found </td></tr>";
			}
			?>
			</table>
			</div>
			</div>
		
			<div id="enquiryModal" class="modal-overlay">
				<div class="modal-content">
					<h1 class="h1">ENQUIRY FORM 📚</h1><p>Create a New Enquiry Form </p>
						
					<form method ="POST" action="index.php">
							<label class="lb1">Name</label><br>
							<input type="text" name="name" class="input2" id="name"><br>

							<label class="lb1">Course📖</label><br>
							<input type="text" name="course" class="input2" id="course"><br>

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
							<input type="text" name="contact" class="input2" id="Contact"><br><br>
							
							<button type="submit" name="save"  value = "1" class="btn">
								Save
							</button>
							<button type="button" onclick="closeEnquiryModal()" class="btn">Cancel</button>
						</form>
            	
				</div>

			</div>

		
				
		<script src="script.js"></script>
            
	</body>
</html>