
<?php
require_once 'db_conn.php';

/* Total Courses */
$result = $conn->query(
    "SELECT COUNT(*) AS total FROM course_table"
);
$totalcourse = $result ? (int) $result->fetch_assoc()['total'] : 0;

/* Total Enquiries */
$result = $conn->query(
    "SELECT COUNT(*) AS total FROM enquiries"
);
$totalenquiries = $result ? (int) $result->fetch_assoc()['total'] : 0;

/* Total Fees */
$result = $conn->query(
    "SELECT COALESCE(SUM(cost), 0) AS total FROM course_table"
);
$totalfees = $result ? $result->fetch_assoc()['total'] : 0;

/* Arrays for charts */
$coursename = [];
$enquirycount = [];
$feename = [];
$feevalue = [];

/* Enquiries per course, including courses with zero enquiries */
$sql = "
    SELECT course_name, no_enquiries
    FROM course_view
    ORDER BY course_name ASC
";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $coursename[] = $row['course_name'];
        $enquirycount[] = (int) $row['no_enquiries'];
    }
}

/* Fees per course */
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

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $feename[] = $row['course_name'];
        $feevalue[] = (float) $row['total_cost'];
    }
}

/* Most Enquired Course */
$mostenquired = [
    'course_name' => 'No course',
    'total' => 0
];

$sql = "
    SELECT
        course_id,
        course_name,
        COUNT(*) AS total
    FROM enquiries_view
    GROUP BY course_id, course_name
    ORDER BY total DESC, course_name ASC
    LIMIT 1
";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $mostenquired = $row;
}

$mostenquiredname = $mostenquired['course_name'];
$mostenquiredcount = (int) $mostenquired['total'];

/* Courses that have at least one enquiry */
$coursesWithEnquiries = count(
    array_filter($enquirycount, fn($n) => $n > 0)
);

/* Enquiries over time */
$sql = "
    SELECT
        MONTH(`date`) AS enquiry_month,
        COUNT(*) AS total
    FROM enquiries
    WHERE `date` IS NOT NULL
      AND YEAR(`date`) = YEAR(CURDATE())
    GROUP BY MONTH(`date`)
    ORDER BY enquiry_month ASC
";

$result = $conn->query($sql);

$monthlyTotals = array_fill(1, 12, 0);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $monthlyTotals[(int) $row['enquiry_month']] =
            (int) $row['total'];
    }
}

$monthLabels = [
    'January', 'February', 'March', 'April',
    'May', 'June', 'July', 'August',
    'September', 'October', 'November', 'December'
];

$enquiryDates = $monthLabels;
$enquiryTotals = array_values($monthlyTotals);
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

    <h1 class="h1">Dashboard</h1>

    <div class="sidenav">
    <div class="sidebar-logo">
        <img src="/Enquiry-system/gi%20kace.jpeg"
             class="img"
             alt="Dashboard logo">

        <div class="sidebar-brand">
            <h2>GI-KACE</h2>
            <p>Enquiry System</p>
        </div>
    </div>

    <div class="sidebar-menu">
        <p class="sidebar-label">MAIN MENU</p>

        <a href="/Enquiry-system/stats" class="active">
            <span class="sidebar-icon">▦</span>
            <span>Dashboard</span>
        </a>

        <a href="/Enquiry-system/index">
            <span class="sidebar-icon">☷</span>
            <span>Enquiries</span>
        </a>

        <a href="/Enquiry-system/course">
            <span class="sidebar-icon">▤</span>
            <span>Courses</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-profile">
            <div class="profile-avatar">A</div>
            <div class="profile-info">
                <strong>Administrator</strong>
                <span>System Manager</span>
            </div>
        </div>

        <a href="Login.php" class="log">
            <span class="sidebar-icon">↪</span>
            <span>Logout</span>
        </a>
    </div>
</div>

    <div class="dashboard">
        <div class="stats">
           
            <!-- Number of Courses -->
            <div class="card blue">
               
                <svg xmlns="http://www.w3.org/2000/svg"
                     height="48px" viewBox="0 -960 960 960"
                     width="48px" fill="#010101">
                    <path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Z"/>
                </svg>
                <a href="course.php" class="link"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-240-56-56 384-384H240v-80h480v480h-80v-344L256-240Z"/></svg></a>
                <h3>NUMBER OF COURSES</h3>
                <h2><?= $totalcourse ?></h2>
            </div>

            <!-- Total Enquiries -->
            <div class="card orange">
                <svg xmlns="http://www.w3.org/2000/svg"
                     height="48px" viewBox="0 -960 960 960"
                     width="48px" fill="#010101">
                    <path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Z"/>
                </svg>
                <a href="index.php" class="link"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-240-56-56 384-384H240v-80h480v480h-80v-344L256-240Z"/></svg></a>
                <h3>TOTAL ENQUIRIES</h3>
                <h2><?= $totalenquiries ?></h2>
            </div>

            <!-- Most Enquired Course -->
            <div class="card green">
				<svg xmlns="http://www.w3.org/2000/svg"
                     height="48px" viewBox="0 -960 960 960"
                     width="48px" fill="#010101">
                    <path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Z"/>
                </svg>
                <a href="course.php" class="link"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-240-56-56 384-384H240v-80h480v480h-80v-344L256-240Z"/></svg></a>
                <h3>MOST ENQUIRED COURSE</h3>
                <h3><?= htmlspecialchars($mostenquiredname) ?></h3>
                <h4><?= $mostenquiredcount ?> Enquiries received</h4>
            </div>

            <!-- Courses with Enquiries -->
            <div class="card red">
					<svg xmlns="http://www.w3.org/2000/svg"
                     height="48px" viewBox="0 -960 960 960"
                     width="48px" fill="#010101">
                    <path d="M180-120q-24.75 0-42.37-17.63Q120-155.25 120-180v-600q0-24.75 17.63-42.38Q155.25-840 180-840h205q5-35 32-57.5t63-22.5q36 0 63 22.5t32 57.5h205q24.75 0 42.38 17.62Q840-804.75 840-780v600q0 24.75-17.62 42.37Q804.75-120 780-120H180Zm0-60h600v-600H180v600Zm100-100h273v-60H280v60Zm0-170h400v-60H280v60Zm0-170h400v-60H280v60Z"/>
                </svg>
                <a href="course.php" class="link"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-240-56-56 384-384H240v-80h480v480h-80v-344L256-240Z"/></svg></a>
                <h3>COURSES WITH ENQUIRIES</h3>
                <h2><?= $coursesWithEnquiries ?></h2>
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

             <div class="chart-card3">
                <h3>Enquiries Over Time</h3>
                <canvas id="timeChart"></canvas>
            </div>

        </div>
    
       
    </div>

    <script>
        window.dashboardData = {
            course_name: <?= json_encode(
                $coursename,
                JSON_HEX_TAG | JSON_HEX_APOS |
                JSON_HEX_QUOT | JSON_HEX_AMP
            ) ?>,

            enquirycount: <?= json_encode($enquirycount) ?>,

            feename: <?= json_encode(
                $feename,
                JSON_HEX_TAG | JSON_HEX_APOS |
                JSON_HEX_QUOT | JSON_HEX_AMP
            ) ?>,

            feevalue: <?= json_encode($feevalue) ?>,
            enquiryDates: <?= json_encode($enquiryDates) ?>,
            enquiryTotals: <?= json_encode($enquiryTotals) ?>
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        console.log("Dashboard data:", window.dashboardData);
        console.log("Fee values:", window.dashboardData.feevalue);
        console.log("Enquiry values:", window.dashboardData.enquirycount);
    </script>

    <script src="script.js"></script>

</body>
</html>
