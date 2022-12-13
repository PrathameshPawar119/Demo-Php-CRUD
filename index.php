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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<?php         
    require 'elements/db_connector.php'; 
    $total_std = "SELECT * FROM `students`";
    $total_std_result = mysqli_query($conn, $total_std);
    $total_num = mysqli_num_rows($total_std_result);
    mysqli_close($conn);
?>

<body>
    <?php require('./elements/navbar.html'); ?>
    <div class="container my-3">
        <form class="container mx-3" id="addNewRecordForm">
            <div class="row">
                <div class="col-10 my-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Student Name">
                </div>
                <div class="col-2 my-2">
                    <h3 ><span id="fetchTableData" class="badge bg-secondary p-4 m-2" style="cursor: pointer;"><?php echo $total_num; ?></span></h3>
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
                <button class="btn btn-primary mx-2 px-4" type="submit" id="formSubmitBtn">Submit</button>
                <button class="btn btn-primary mx-2 px-4" type="reset">Reset</button>
            </center>
        </form>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBodyHere">
                            ...
                            <!-- Edit record Modal Body here-->
                    </div>
                    <center class='my-2 modal-footer'>
                        <button class='btn btn-secondary mx-2 px-2' data-bs-dismiss='modal' id="closeEditModalBtn" type='button'>Close</button>
                        <button class='btn btn-success mx-2 px-4' type='submit' data-example='ganndu' id='editFormSubmitBtn'>Submit</button>
                        <button class='btn btn-primary mx-2' type='reset'>Reset</button>
                    </center>
                </div>
            </div>
        </div>
        <div class="student_table my-4" id="student_table">
            <!--   Table will be generated dynamically here using ajax-php  -->
        </div>
    </div>
</body>
<script src="./elements/jquery.js"></script>
<script>
    function getStudentsTableAjax (){
        // Function to view & fetch table data
        $.ajax({
            url: "elements/getStudentData.php",
            type: "POST",
            success: function (data){
                $("#student_table").html(data);
            }
        })
    }

    async function addNewRecordAjax(){
        // Function to submit the form - add new record
        var name = $("input[name=name]").val();
        var age = $("input[name=age]").val();
        var phone = $("input[name=phone]").val();
        var subject = $("input[name=subject]").val();
        
        var formInputData = {
            name: name,
            age: age,
            phone: phone,
            subject: subject
        }
        if (name && age && phone && subject) {
            await $.ajax({
                url: "elements/addNewRecord.php",
                type: "POST",
                data: formInputData,
                success: function(result){
                    if (result == '0' || result == 0) {
                        alert("Duplicate Number Found!!!");
                    }
                    else{
                        getStudentsTableAjax();
                    }
                }
            });
            document.getElementById("addNewRecordForm").reset(); 
        }
        else{
            alert("Some field is remaining to fill.");
        }
    }

    function loadEditModalBody(e){
        // console.log(e.target.getAttribute("data-studentId"));
        var stuId = e.target.getAttribute("data-studentId");
        $.ajax({
            url: "elements/load_update_form.php",
            type: "POST",
            data: {studentId: stuId},
            success: function(data){
                $("#modalBodyHere").html(data);
            }
        });
    }

    function updateRecordAjaxFunc(e){
        e.preventDefault();
        var id = $("input[name=update_studentid]").val();
        var name = $("input[name=update_name]").val();
        var age = $("input[name=update_age]").val();
        var phone = $("input[name=update_phone]").val();
        var subject = $("input[name=update_subject]").val();
        var formData = {id:id, name: name, age: age, phone: phone, subject: subject};
        console.log(formData);

        $.ajax({
            url: "elements/updateRecord.php",
            type: "POST",
            data: formData,
            success: function(result){
                if (result == '1' || result == 1) {
                    document.getElementById("closeEditModalBtn").click();
                    getStudentsTableAjax();
                }
                else if(result == '0' || result == 0) {
                    alert('Student with same mobile number already exists!');
                }
                else{
                    alert("Pata nahi kya hua rrrrr!");
                }
            }
        });
    }

    function deleteRecord(e){
        var stuId = e.target.getAttribute("data-studentId");
        var ask1 = confirm("Are you sure to delete record no."+stuId);
        if (ask1) {
            $.ajax({
                url: "elements/deleteRecord.php",
                type: "POST",
                data: {studentId: stuId},
                success: function(result){
                    if (result == '1' || result == 1) {
                        getStudentsTableAjax();
                    }
                    else{
                        alert("Some Problem occured while deleting!");
                    }
                }
            })
        }
    }
    
    $(document).ready(function(){
        getStudentsTableAjax();

        $('#fetchTableData').on("click", getStudentsTableAjax());
        
        $('#formSubmitBtn').on("click",  function(e){
            e.preventDefault();
             addNewRecordAjax();
        });

        $(document).on("click", ".editBtnSm", function(e){
            loadEditModalBody(e);
        });

        $("#editFormSubmitBtn").on("click", function(e){
            updateRecordAjaxFunc(e);
        });

        $(document).on("click", ".deleteBtnSm", function (e){
            deleteRecord(e);
        });


    })
 

</script>
</html>