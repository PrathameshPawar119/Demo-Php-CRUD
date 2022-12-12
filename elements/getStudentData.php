<?php

require './db_connector.php';

$students = "SELECT * FROM `students` ORDER BY `students`.`id`;";
$students_res = mysqli_query($conn, $students);


if (mysqli_num_rows($students_res) > 0) {
    $output = "<table class='table table-hover' id='studentsData'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Phone No.</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";
    while ($item = mysqli_fetch_array($students_res)) {
        $output .= "<tr>
                        <td>$item[0]</td>
                        <td>$item[1]</td>
                        <td>$item[2]</td>
                        <td>$item[3]</td>
                        <td>$item[4]</td>
                        <td>
                            <div class='row' style='display:inline;'>
                                <!-- Url rewriting - sending student data which was clicked -->
                                <button type='button' class='editBtnSm btn btn-primary ' data-studentId='$item[0]' style='width:60px;' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>Edit</button>
                                <button type='button' class='deleteBtnSm btn btn-danger' data-studentId='$item[0]' style='width:72px;'>Delete</button>
                            </div>
                        </td>
                    </tr>";
        }
        $output .= "</tbody></table>"; 

        mysqli_close($conn);
        echo $output;
}
else{
    echo "<h2>Records Not Found</h2>";
}


?>