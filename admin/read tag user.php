<?php
require 'database.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM table_the_iot_projects WHERE id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

$msg = null;
if ($data === false) {
    $msg = "Dear student, you are not registered yet. Please ask for help!";
    $data['id'] = $id;
    $data['name'] = "--------";
    $data['year_of_study'] = "--------";
    $data['class'] = "--------";
    $data['photo'] = "--------";
} else {
    $msg = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/ruang-admin.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: #10a0c5;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #007b8f;
        }

        /* Custom Image Styles */
        #student-photo {
            width: 160px;
            height: 160px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="card shadow-sm">
        <div class="card-header text-white bg-primary">
            <h4 class="mb-0">WELCOME STUDENT</h4>
        </div>
        <div class="card-body">
            <div id="show_user_data">
                <table>

                    <tr>
                        <td rowspan="4">
                            <img src="uploads/<?php echo $data['photo']; ?>" alt="Student Photo" class="img-fluid rounded" id="student-photo">
                        </td>
                        <td><b>ID</b></td>
                        <td><?php echo $data['id'];?></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td>
                        <td><?php echo $data['name'];?></td>
                    </tr>
                    <tr>
                        <td><b>Year Of Study</b></td>
                        <td><?php echo $data['year_of_study'];?></td>
                    </tr>
                    <tr>
                        <td><b>Class</b></td>
                        <td><?php echo $data['class'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        <p style="color:red;"><?php echo $msg;?></p>
    </div>
</body>
</html>
