<?php      
    session_start();
    include('connection.php');
    
    $email = $_POST['email'];  
    $password = $_POST['password'];  
    
    // Prepare the SQL statement
    $stmt = $con->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); // "ss" means two string parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $result->num_rows;
          
        if($count == 1){
            $isLoggedIncheck = 1;
            header("location: index.php");
            exit();
        } 
        else{
            ?>
            <style>
                a:hover{
                    box-shadow:2px 2px 5px gray;
                }
            </style>
            <div style="text-align: center;">
                <p style="font-size:larger;">Incorrect Email or Password!</p>

                <a href="javascript:history.back()" style="text-decoration: none;color:black;border: solid; padding: 10px; border-radius: 15px; border-width:1px">Go back and Try Again</a>
            </div>
            <?php
        }
        mysqli_close($con);   
        
?>