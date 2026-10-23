<?php
require_once 'db_conn.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$error = '';
$successMessages = [
    'success' => 'Enquiry added successfully.',
    'updated' => 'Enquiry updated successfully.',
    'deleted' => 'Enquiry deleted successfully.'
];

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // DELETE ENQUIRY
        if (isset($_POST['confirm_Delete'])) {
            $enquiry_id = filter_var(
                $_POST['enquiry_id'] ?? '',
                FILTER_VALIDATE_INT
            );

            if (!$enquiry_id || $enquiry_id < 1) {
                throw new RuntimeException('Invalid enquiry ID.');
            }

            $stmt = $conn->prepare(
                'DELETE FROM enquiries WHERE enquiry_id = ?'
            );
            $stmt->bind_param('i', $enquiry_id);
            $stmt->execute();

            if ($stmt->affected_rows !== 1) {
                $stmt->close();
                throw new RuntimeException(
                    'The enquiry was not found or was already deleted.'
                );
            }

            $stmt->close();

            header('Location: index.php?deleted=1');
            exit();
        }

        // CREATE OR UPDATE ENQUIRY
        if (isset($_POST['save']) || isset($_POST['update_btn'])) {
            $name = trim($_POST['name'] ?? '');
            $course = trim($_POST['course'] ?? '');
            $date = trim($_POST['date'] ?? '');
            $contact = trim($_POST['contact'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $enquiry_id = filter_var(
                $_POST['enquiry_id'] ?? '',
                FILTER_VALIDATE_INT
            );
            $isUpdate = isset($_POST['update_btn'])
                || ($enquiry_id !== false && $enquiry_id !== null
                    && $enquiry_id !== '');

            if (
                $name === '' ||
                $course === '' ||
                $date === '' ||
                $contact === '' ||
                $address === ''
            ) {
                throw new RuntimeException(
                    'Please complete all enquiry fields.'
                );
            }

            if (
                $isUpdate &&
                (!$enquiry_id || $enquiry_id < 1)
            ) {
                throw new RuntimeException(
                    'Invalid enquiry ID for updating.'
                );
            }
            $dateObject = DateTime::createFromFormat('!Y-m-d', $date);

            if (
                !$dateObject ||
                $dateObject->format('Y-m-d') !== $date
            ) {
                throw new RuntimeException(
                    'Please enter a valid enquiry date.'
                );
            }

            if ($isUpdate) {
                $stmt = $conn->prepare(
                    'UPDATE enquiries
                     SET name = ?, course = ?, `date` = ?,
                         contact = ?, address = ?
                     WHERE enquiry_id = ?'
                );

                $stmt->bind_param(
                    'sssssi',
                    $name,
                    $course,
                    $date,
                    $contact,
                    $address,
                    $enquiry_id
                );

                $stmt->execute();
                $stmt->close();

                header('Location: index.php?updated=1');
                exit();
            } else {
                // INSERT into the underlying table, NOT the view.
                $stmt = $conn->prepare(
                    'INSERT INTO enquiries
                        (name, course, `date`, contact, address)
                     VALUES (?, ?, ?, ?, ?)'
                );

                $stmt->bind_param(
                    'sssss',
                    $name,
                    $course,
                    $date,
                    $contact,
                    $address
                );

                $stmt->execute();
                $stmt->close();

                header('Location: index.php?success=1');
                exit();
            }
        }
    } catch (RuntimeException $ex) {
        $error = $ex->getMessage();
    } catch (mysqli_sql_exception $ex) {
        // Log detailed errors on the server, not in the browser.
        error_log('Enquiry database error: ' . $ex->getMessage());
        $error = 'The enquiry could not be saved. Please check the '
               . 'database configuration and try again.';
    }
}

$search = trim($_GET['search'] ?? '');

try {
    if ($search !== '') {
        $stmt = $conn->prepare(
            'SELECT * FROM enquiries_view WHERE name LIKE ?'
        );

        $searchTerm = '%' . $search . '%';
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();

        $result = $stmt->get_result();
    } else {
        $result = $conn->query(
            'SELECT * FROM enquiries_view'
        );
    }
} catch (mysqli_sql_exception $ex) {
    error_log('Enquiry retrieval error: ' . $ex->getMessage());
    $error = 'Unable to load enquiries. Please try again.';
    $result = false;
}

$notice = '';
$status = $_GET['status'] ?? '';

if (isset($successMessages[$status])) {
    $notice = $successMessages[$status];
}

if (isset($_GET['success'])) {
    $notice = $successMessages['success'];
} elseif (isset($_GET['updated'])) {
    $notice = $successMessages['updated'];
} elseif (isset($_GET['deleted'])) {
    $notice = $successMessages['deleted'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry Dashboard 🖥</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="sidenav">
        <img src="gi kace.jpeg" class="img" alt="Dashboard logo">
        <a href="stat.php">Stat Dashboard 🖥</a>
        <a href="index.php" class="active">Enquiries</a>
        <a href="course.php">Courses</a>
    </div>

    <a href="Login.php" class="log">Logout</a>

    <nav>
        <h1 class="new1">Enquiries System View 🖥</h1>
    </nav>

    <div class="container">

        <h1 class="h1">Enquiry Table</h1>       
				<?php if ($notice !== ''): ?>
					<div class="flash-message flash-success" role="status">
						<?= e($notice) ?>
					</div>
				<?php endif; ?>

				<?php if ($error !== ''): ?>
					<div class="flash-message flash-error" role="alert">
						<?= e($error) ?>
					</div>
				<?php endif; ?>

			<div class="search">
        <form method="GET" action="index.php">
            <input
                type="search"
                name="search"
                placeholder="Search Enquiries 🔍"
                class="input"
                value="<?= e($search) ?>"
            >
            <button type="submit" class="btn">Search</button>
        </form>

        <button
            type="button"
            class="ahref"
            onclick="openEnquiryModal()"
        >
            ➕ New Enquiry
        </button>
		</div>
        <table class="table">
            <thead>
                <tr>
                    <th class="table1">Name</th>
                    <th class="table1">Course</th>
                    <th class="table1">Date</th>
                    <th class="table1">Contact</th>
                    <th class="table1">Address</th>
                    <th class="table1">Edit</th>
                    <th class="table1">Delete</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php $id = (int)$row['enquiry_id']; ?>

                    <tr id="row-<?= $id ?>">
                        <td class="table2" id="name-<?= $id ?>">
                            <?= e($row['name']) ?>
                        </td>

                        <td class="table2" id="course-<?= $id ?>">
                            <?= e($row['course']) ?>
                        </td>

                        <td class="table2" id="date-<?= $id ?>">
                            <?= e($row['date']) ?>
                        </td>

                        <td class="table2" id="contact-<?= $id ?>">
                            <?= e($row['contact']) ?>
                        </td>

                        <td class="table2" id="address-<?= $id ?>">
                            <?= e($row['address']) ?>
                        </td>

                        <td class="table2">
                            <button
                                type="button"
                                onclick="editRecords(<?= $id ?>)"
                                class="edit"
                                aria-label="Edit enquiry <?= $id ?>"
                            >✍🏼</button>
                        </td>

                        <td class="table2">
                            <button
                                type="button"
                                onclick="deleteRecords(<?= $id ?>)"
                                class="Delete"
                                aria-label="Delete enquiry <?= $id ?>"
                            >🗑️</button>
                        </td>
                    </tr>
                <?php endwhile; ?>

            <?php else: ?>
                <tr>
                    <td class="table2" colspan="7">
                        No enquiries found.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Create/Edit Enquiry Modal -->
    <div id="enquiryModal" class="modal-overlay">
        <div class="modal-content">
            <h1 class="h1">ENQUIRY FORM 📚</h1>
            <p>Create or update an enquiry.</p>

            <form method="POST" action="index.php" id="enquiryForm">
                <input
                    type="hidden"
                    name="enquiry_id"
                    id="edit_enquiry_id"
                    value=""
                >

                <label class="lb1" for="name">Name</label><br>
                <input
                    type="text"
                    name="name"
                    class="input2"
                    id="name"
                    required
                ><br>

                <label class="lb1" for="course">Course</label><br>
                <select
                    name="course"
                    class="input2"
                    id="course"
                    required
                >
                    <option value="">Select Course</option>
                    <option value="OPS">OPS</option>
                    <option value="CISA(weekdays)">CISA (weekdays)</option>
                    <option value="CISA(weekdends)">CISA (weekends)</option>
                    <option value="CCNA(weekdays)">CCNA (weekdays)</option>
                    <option value="CCNA(weekends)">CCNA (weekends)</option>
                    <option value="CSD">CSD</option>
                    <option value="Cyber security">Cyber security</option>
                </select><br>

                <label class="lb1" for="date">Date 📅</label><br>
                <input
                    type="date"
                    name="date"
                    class="input2"
                    id="date"
                    required
                ><br>

                <label class="lb1" for="address">Address</label><br>
                <input
                    type="text"
                    name="address"
                    class="input2"
                    id="address"
                    required
                ><br>

                <label class="lb1" for="contact">Contact 📞</label><br>
                <input
                    type="text"
                    name="contact"
                    class="input2"
                    id="contact"
                    required
                ><br><br>

                <button
                    type="submit"
                    name="save"
                    id="submitBtn"
                    value="1"
                    class="btn"
                >Save</button>

                <button
                    type="button"
                    onclick="closeEnquiryModal()"
                    class="btn"
                >Cancel</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <h2>Delete Enquiry</h2>
            <p>Are you sure you want to delete this enquiry?</p>

            <form method="POST" action="index.php">
                <input
                    type="hidden"
                    name="enquiry_id"
                    id="modal_enquiry_id"
                    value=""
                >

                <div class="modal-buttons">
                    <button
                        type="button"
                        class="cancel-btn"
                        onclick="closeDeleteModal()"
                    >Cancel</button>

                    <button
                        type="submit"
                        class="delete-btn"
                        name="confirm_Delete"
                        value="1"
                    >Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>