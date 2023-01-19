<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['rename'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        if (empty($firstname) || empty($lastname)){
            $_SESSION['error'] = 'กรุณากรอกชื่อและนามสกุล';
            header("location: rename.php");
        } else{
            try {

                $check_data = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname WHERE id = :id ");
                $check_data->bindParam(":firstname", $firstname);
                $check_data->bindParam(":lastname", $lastname);
                $check_data->bindParam(":id", $_SESSION['user_id'] );
                $check_data->execute();
                

                if ($check_data->rowCount() > 0) {
                    header("location: user.php");
                } else {
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("location: rename.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

    }


?>