<?php
    session_start();

    include '../database/config.php';
    $selected_option = mysqli_real_escape_string($conn,$_POST['selected_option']);
    $question_id = mysqli_real_escape_string($conn,$_POST['question_id']);
    $score_earned = mysqli_real_escape_string($conn,$_POST['score']);
    $student_details = json_decode($_SESSION['student_details']);
    $student_id;

    foreach($student_details as $obj){
        $student_id = $obj->id;
        $test_id = $obj->test_id;
    }
    
    if (!$conn) 
        die("Connection failed: " . mysqli_connect_error());
    else{
        $result = mysqli_query($conn, "SELECT id FROM Questions WHERE id = '".$question_id."' AND correctAns = '".$selected_option."' LIMIT 1 ");        
        if (mysqli_num_rows($result) > 0){
            //increase question corerct count
            $sql = "UPDATE score set correct_count = correct_count + 1 where question_id = '$question_id'";
            mysqli_query($conn,$sql);
           if(mysqli_query($conn, "UPDATE students set score = score + '".$score_earned."' where id = '".$student_id."' ")){
                echo "SCORE_UPDATED_SUCCESSFULLY";
           }else{
                echo "SCORE_UPDATE_FAILURE";
            }  
        }
        else {
            //increase question wrong count
            $sql = "UPDATE score set wrong_count = wrong_count + 1 where question_id = '$question_id'";
            mysqli_query($conn,$sql);
            $sql = "INSERT INTO score_question_student SET score = 0, student = '".$student_id."', question = '" . $question_id."'";
			error_log($sql);
			mysqli_query($conn,$sql);
            echo "WRONG_ANSWER";
        }
    }

    mysqli_close($conn);
?>