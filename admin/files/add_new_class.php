<?php
	include "../../database/config.php";
    include __DIR__ . '/randomString.php';
    $class_name = mysqli_real_escape_string($conn,$_POST['class_name']);
    $sql = "INSERT INTO classes (name) VALUES ('".$class_name."')";
 
    if (mysqli_query($conn, $sql)) {
        $class_id = mysqli_insert_id($conn);
        $starting_roll_number = mysqli_real_escape_string($conn, $_POST['starting_roll_number']);
        $ending_roll_number = mysqli_real_escape_string($conn, $_POST['ending_roll_number']);
        // output data of each row
        for ($x = $starting_roll_number; $x <= $ending_roll_number; $x++) {
			$insert_student = "INSERT INTO students (rollno, password, score, status) VALUES ('" . $x . "', '" . generateRandomString(12) ."', 0, 0)";
            mysqli_query($conn, $insert_student);
            $insert_roll_numbers = "INSERT INTO student_data (id, class_id) VALUES ('".$x."', $class_id)";
			error_log($insert_roll_numbers);
            mysqli_query($conn, $insert_roll_numbers);
        }
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
