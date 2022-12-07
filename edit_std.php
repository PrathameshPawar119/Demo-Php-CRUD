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

// getting data from url
if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id = $_GET['id'];
    $old_name = $_GET['name'];
    $old_age = $_GET['age'];
    $old_phone= $_GET['phone'];
    $old_subject = $_GET['subject'];
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // For adding new Student
        $id = $_GET['id'];
        $name = ucwords($_POST['name']);
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $subject = ucwords($_POST['subject']);

            $check_exists_sql = "SELECT * FROM `students` WHERE `phone`='$phone';";
            $check_exists_res = mysqli_query($conn, $check_exists_sql);
            $total_existing_std = mysqli_num_rows($check_exists_res);
            if ($total_existing_std >2) {
                $std_exists = true;
            }
            else {
                $std_exists = false;
            }

        if ($std_exists == false)
         {
            $update_std = "UPDATE `students` SET `name`='$name', `age`='$age', `phone`='$phone', `subject`='$subject' WHERE `students`.`id`='$id'"; 
            $update_std_res = mysqli_query($conn, $update_std);
            if ($update_std_res) {
                header("Location: http://localhost/crud-php-recruitnx-demo/index.php");
            }

        }
        else {
            echo "<script> alert('Student with same mobile number already exists!'); </script>";
        }

    }

?>
<body>
    <?php require('./elements/navbar.html'); ?>
    <div class="container my-3">
        <form action="/crud-php-recruitnx-demo/edit_std.php?id=<?php echo $id;?>" method="POST" class="container mx-3">
            <h2 class="center">Update Student - <?php echo $old_name; ?></h2>
            <div class="row">
                <div class="col-12 my-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Student Name" value="<?php echo $old_name;?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 my-2">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" placeholder="00" value="<?php echo $old_age;?>" min="4" max="100">
                </div>
                <div class="col-md-4 my-2">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="xxxxxxxxxx" maxlength="10" minlength="10" value="<?php echo $old_phone;?>">
                </div>
                <div class="col-md-6 my-2">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $old_subject;?>">
                </div>
            </div>
            <center class="my-2">
                <button class="btn btn-primary mx-2 px-4" type="submit">Submit</button>
            </center>
        </form>
    </div>
</body>
</html>