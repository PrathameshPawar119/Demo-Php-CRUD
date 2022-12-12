<?php
require "./db_connector.php";

$studentId = $_POST['studentId'];
$student = "SELECT * FROM `students` WHERE `students`.`id`= '$studentId';";
$student_res = mysqli_query($conn, $student);


if( mysqli_num_rows($student_res) > 0)
{  
    $output = "";
    while ($temp = mysqli_fetch_array($student_res)) {

        $output .= "<form class='container mx-3' id='editRecordForm'>
                        <div class='row'>
                            <div class='col-10 my-2'>
                            <label for='name' class='form-label'>Name</label>
                            <input type='text' class='form-control' id='name' name='update_name' value='$temp[1]' placeholder='Student Name'>
                            <input type='hidden' id='studentId' name='update_studentid' value='$studentId'>
                        </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2 my-2'>
                                <label for='edit_age' class='form-label'>Age</label>
                                <input type='number' class='form-control' value='$temp[2]' id='edit_age' name='update_age' placeholder='00' min='4' max='100'>
                            </div>
                            <div class='col-md-4 my-2'>
                                <label for='edit_phone' class='form-label'>Phone Number</label>
                                <input type='text' class='form-control' value='$temp[3]' id='edit_phone' name='update_phone' placeholder='xxxxxxxxxx' maxlength='10' minlength='10'>
                            </div>
                            <div class='col-md-6 my-2'>
                                <label for='edit_subject' class='form-label'>Subject</label>
                                <input type='text' class='form-control' value='$temp[4]' id='edit_subject' name='update_subject'>
                            </div>
                        </div>
                    </form>";
    }
    mysqli_close($conn);
    echo $output;
}
else {
    echo "Error occured while loading update form";
}

?>