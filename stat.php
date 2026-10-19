<?php
require_once 'db_conn.php';

	$result = $conn->query("SELECT COUNT(*) AS total FROM course");
	$totalcourse = $result->fetch_assoc()['total'];

	$result = $conn->query("SELECT COUNT(*) AS total FROM enquiries");
	$totalenquiries = $result->fetch_assoc()['total'];

	$result = $conn->query("SELECT COALESCE(SUM(cost),0) AS total FROM course_table"); 
	$totalfees = $result->fetch_assoc()['total'];

	$result = $conn->query("SELECT  c.course_name,COUNT(e.enquiry_id) AS total 
	FROM course c LEFT JOIN enquiries e ON e.course = c.course_name
	GROUP BY c.course_id,c.course_name
	ORDER BY c.course_id");


$coursename = [];
$enquirycount = [];
$feename = [];
$feevalue = [];



// Enquiries per course, including courses with zero enquiries
		$sql = "
			SELECT course_name, no_enquiries
			FROM course_view
			ORDER BY course_name ASC
		";

		$result = $conn->query($sql);

		$coursename = [];
		$enquirycount = [];

		while ($row = $result->fetch_assoc()) {
			$coursename[] = $row['course_name'];
			$enquirycount[] = (int) $row['no_enquiries'];
		}

// Fees per course
$sql = "
    SELECT
        course_name,
        SUM(
            CAST(
                REPLACE(
                    REPLACE(
                        REPLACE(TRIM(cost), '$', ''),
                        ',',
                        ''
                    ),
                    ' ',
                    ''
                ) AS DECIMAL(10,2)
            )
        ) AS total_cost
    FROM course_table
    GROUP BY course_name
    ORDER BY course_name ASC
";

$result = $conn->query($sql);

$feename = [];
$feevalue = [];

while ($row = $result->fetch_assoc()) {
    $feename[] = $row['course_name'];
    $feevalue[] = (float) $row['total_cost'];
}

while ($row = $result->fetch_assoc()) {
    $feename[] = $row['course_name'];
    $feevalue[] = (float) $row['total_cost'];
}

while ($row = $result->fetch_assoc()) {
    $feename[] = $row['course_name'];
    $feevalue[] = (float) $row['total_cost'];
}

// Most enquired course
$mostenquired = [
    'course_name' => 'No course',
    'total' => 0
];

$sql = "
    SELECT
        c.course_name,
        COUNT(e.enquiry_id) AS total
    FROM course c
    LEFT JOIN enquiries e
        ON e.course = c.course_name
    GROUP BY c.course_id, c.course_name
    ORDER BY total DESC, c.course_name ASC
    LIMIT 1
";

$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    $mostenquired = $row;
}

$mostenquiredname = $mostenquired['course_name'];
$mostenquiredcount = (int) $mostenquired['total'];

// Courses that have at least one enquiry
$coursesWithEnquiries = count(
    array_filter($enquirycount, fn($n) => $n > 0)
);
?>
	

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Statistics Dashboard</title>
	<link rel="stylesheet" type="text/css" href="stastyle.css">
</head>
<body>
	<h1 class="h1">Statistics Dashboard<img src="gi kace.jpeg" class="img"></h1>
		<div>
			<div class="sidenav">
				<input type="Search" placeholder="Search Enquires 🔍" name="Search" class="input"><button type="submit" class="btn">Search</button><br><br></h1><br>
				<a href="stat.php" >Stat Dashboard🖥</a>
				<a href="index.php" >Enquiries</a>
				<a href="course.php" >Courses</a>
					
			</div>

			<a href="Login.html" class="log">Logout</a>
		</div>
		<div class="dashboard">
			<h3>DASHBOARD</h3>
		<div class="stats">

		<div class="card blue">
			<h3> NUMBER OF COURSES  <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e3e3e3"><path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Zm224.5-187.5Q515-818 515-832t-10.5-24.5Q494-867 480-867t-24.5 10.5Q445-846 445-832t10.5 24.5Q466-797 480-797t24.5-10.5ZM180-180v-600 600Z"/></svg> </h3>
			<h2><?= $totalcourse ?></h2>		
		</div>

		<div class="card orange">
			<h3>TOTAL ENQUIRIES <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e3e3e3"><path d="M140-160q-24 0-42-18t-18-42v-520q0-24 18-42t42-18h680q24 0 42 18t18 42v520q0 24-18 42t-42 18H140Zm0-60h310v-520H140v520Zm370 0h310v-520H510v520Zm-320-97h210v-60H190v60Zm0-129h210v-60H190v60Zm0-129h210v-60H190v60Zm370 258h210v-60H560v60Zm0-129h210v-60H560v60Zm0-129h210v-60H560v60ZM450-220v-520 520Z"/></svg>  </h3>
			<h2><?= $totalenquiries ?></h2>		
		</div>

		<div class="card green">
			<h3> MOST ENQUIRIED COURSE  <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e3e3e3"><path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Zm224.5-187.5Q515-818 515-832t-10.5-24.5Q494-867 480-867t-24.5 10.5Q445-846 445-832t10.5 24.5Q466-797 480-797t24.5-10.5ZM180-180v-600 600Z"/></svg> </h3>
			<h2><?= htmlspecialchars($mostenquiredname) ?></h2>
			<p><?= $mostenquiredcount ?> Enquires recieved</P>
		</div>
		<div class="card red">
			<h3>COURSES  WITH ENQUIRIES <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e3e3e3"><path d="M560-574v-48q33-14 67.5-21t72.5-7q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-610q-38 0-73 9.5T560-574Zm0 220v-49q33-13.5 67.5-20.25T700-430q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-390q-38 0-73 9t-67 27Zm0-110v-48q33-14 67.5-21t72.5-7q26 0 51 4t49 10v44q-24-9-48.5-13.5T700-500q-38 0-73 9.5T560-464ZM248-300q53.57 0 104.28 12.5Q403-275 452-250v-427q-45-30-97.62-46.5Q301.76-740 248-740q-38 0-74.5 9.5T100-707v434q31-14 70.5-20.5T248-300Zm264 50q50-25 98-37.5T712-300q38 0 78.5 6t69.5 16v-429q-34-17-71.82-25-37.82-8-76.18-8-54 0-104.5 16.5T512-677v427Zm-30 90q-51-38-111-58.5T248-239q-36.54 0-71.77 9T106-208q-23.1 11-44.55-3Q40-225 40-251v-463q0-15 7-27.5T68-761q42-20 87.39-29.5 45.4-9.5 92.61-9.5 63 0 122.5 17T482-731q51-35 109.5-52T712-800q46.87 0 91.93 9.5Q849-781 891-761q14 7 21.5 19.5T920-714v463q0 27.89-22.5 42.45Q875-194 853-208q-34-14-69.23-22.5Q748.54-239 712-239q-63 0-121 21t-109 58ZM276-489Z"/></svg></h3>
			<h2><?= count(array_filter($enquirycount,fn($n)=> $n > 0)) ?></h2>		
			</div>
			</div>	
			<div class="chart-container">

				<div class="chart-card">
					<h3>Fees Per Course</h3>
					<canvas id="feeChart"></canvas>
				</div>

				<div class="chart-card2">
					<h3>Number of Enquiries Per Course</h3>
					<canvas id="enquiryChart"></canvas>
				</div>

			</div>
			</div>

			<script>
				window.dashboardData = {
					course_name: <?= json_encode(
						$coursename,
						JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
					) ?>,

					enquirycount: <?= json_encode($enquirycount) ?>,

					feename: <?= json_encode(
						$feename,
						JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
					) ?>,

					feevalue: <?= json_encode($feevalue) ?>
				};
			</script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
		<script>
		console.log("Dashboard data:", window.dashboardData);
		console.log("Fee values:", window.dashboardData.feevalue);
		console.log("Enquiry values:", window.dashboardData.enquirycount);
		</script>
         <script src="script.js"></script>
</body>
</html>