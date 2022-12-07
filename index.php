<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
</head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php  require 'elements/db_connector.php'; ?>
<?php         
    $total_std = "SELECT * FROM `students`";
    $total_std_result = mysqli_query($conn, $total_std);
    $total_num = mysqli_num_rows($total_std_result);
?>

<?php
$std_exists = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // For adding new Student
        $name = ucwords($_POST['name']);
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $subject = ucwords($_POST['subject']);

            $check_exists_sql = "SELECT * FROM `students` WHERE `phone`='$phone';";
            $check_exists_res = mysqli_query($conn, $check_exists_sql);
            $total_existing_std = mysqli_num_rows($check_exists_res);
            if ($total_existing_std == 1) {
                $std_exists = true;
            }
            else {
                $std_exists = false;
            }

        if ($std_exists == false)
         {
            $insert_std_sql = "INSERT INTO `students` (`id`, `name`, `age`, `phone`, `subject`) VALUES (NULL, '$name', '$age', '$phone', '$subject');";
            $insert_std_result = mysqli_query($conn, $insert_std_sql);

        }
        else {
            echo "<script> alert('Student with same mobile number already exists!'); </script>";
        }

    }

?>
<body>
    <?php require('./elements/navbar.html'); ?>
    <div class="container my-3">
        <form action="/crud-php-recruitnx-demo/index.php" method="POST" class="container mx-3">
            <div class="row">
                <div class="col-10 my-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Student Name">
                </div>
                <div class="col-2 my-2">
                    <h3><span class="badge bg-secondary p-4 m-2"><?php echo $total_num; ?></span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 my-2">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" placeholder="00" min="4" max="100">
                </div>
                <div class="col-md-4 my-2">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="xxxxxxxxxx" maxlength="10" minlength="10">
                </div>
                <div class="col-md-6 my-2">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject">
                </div>
            </div>
            <center class="my-2">
                <button class="btn btn-primary mx-2 px-4" type="submit">Submit</button>
                <button class="btn btn-primary mx-2 px-4" type="reset">Reset</button>
            </center>
        </form>
        <div class="student_table my-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Age</td>
                        <td>Phone No.</td>
                        <td>Subject</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $students = "SELECT * FROM `students` ORDER BY `students`.`id`;";
                        $students_res = mysqli_query($conn, $students);
                        while ($item = mysqli_fetch_array($students_res)) {
                            echo"
                                <tr>
                                    <td>$item[0]</td>
                                    <td>$item[1]</td>
                                    <td>$item[2]</td>
                                    <td>$item[3]</td>
                                    <td>$item[4]</td>
                                    <td>
                                        <div class='row'>
                                            <a href='./edit_std.php?id=$item[0]&name=$item[1]&age=$item[2]&phone=$item[3]&subject=$item[4]'><span class='badge bg-secondary'>Edit</span></a>
                                            <a href='./elements/delete_std_script.php?id=$item[0]&name=$item[1]'><span class='badge bg-danger'>Delete</span></a>
                                        </div>
                                    </td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>