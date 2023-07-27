<?php
    $id;
	include "../../database/config.php";
    include __DIR__ . '/randomString.php';
   
        $classes = "SELECT id FROM classes where name = '".mysqli_real_escape_string($conn,$_POST['class_name'])."' ";
        $result = mysqli_query($conn, $classes);
                
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $id  = $row['id'];
            }
                    
        $insert_student = "INSERT INTO students (rollno, password, score, status) VALUES ('" . mysqli_real_escape_string($conn,$_POST['extra_roll_number']) . "', '" . generateRandomString(12) ."', 0, 0)";
        mysqli_query($conn, $insert_student);
        $sql = "INSERT INTO student_data (id, class_id) VALUES ('".mysqli_real_escape_string($conn,$_POST['extra_roll_number'])."', $id)";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>
