<?php

//Alternative way for the project, is to split code up for better reuse and more MVC style. To create classes, FormEntry and FormEntryRepo to handle the different parts
//FormEntryRepo could have methods such as store, fetch and prepareAndBind to handle the sql queries etc.


define( 'DB_HOST', 'localhost' );
define( 'DB_USERNAME', 'kiran' );
define( 'DB_PASSWORD', '1234' );
define( 'DB_NAME', 'kiran' );
define( 'DB_PORT', '3306' );
/* Attempt MySQL server connection. Assuming, running MySQL
server with default setting (user 'root' with no password) */
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
    // Check connection
    if(!$conn){
     die("ERROR: Could not connect. " . mysqli_connect_error());
    }

session_start();
if (!empty($_POST['token'])) {
    if (hash_equals($_SESSION['token'], $_POST['token'])) {
         // Proceed to process the form data

        // Escape user inputs for security
$name = test_input(mysqli_real_escape_string($conn, $_REQUEST['name']));
$email = test_input(mysqli_real_escape_string($conn, $_REQUEST['email']));
$number = test_input(mysqli_real_escape_string($conn, $_REQUEST['number']));

// Get the remaining 'fields' in an array 

$values = ($_POST);
$last_id = 0;

// Validation of Input and Assigning Errors
$nameErr = "";
$emailErr = "";
$numberErr = "";
$fieldErr = "";
$sqlErr = "";



//Check that the extra data is not empty. I.e. Province and city is filled in
$count = 0;
    foreach($values as $key => $value) {
        $count++;
        if ($count > 4){
            if (empty($value)) {
            $fieldErr = "Please fill in your extra data.";
            } 
        }
    }

   if (empty($name)) {
        $nameErr = "Please enter your name.";
    } 

    if (empty($email)) {
       $emailErr = "Please enter your email address.";  
    } 
    else{
        $email = test_email($email);
        if($email == FALSE){
            $emailErr = "Please enter a valid email address.";
        }
    }

    if (empty($number)) {
        $numberErr = "Please enter your mobile number.";
    } 
    else{
        if(($number < 0) || (strlen($number) != 10) || $number[0] != 0){
              $numberErr = "Please enter a valid mobile number.";
        }
    }

   
        
    // Validation of Input and Assigning Errors End(Above)


        // Check if there are any errors, If not add to the DB, Else Display Errors and Ask for Input again
    if (empty($nameErr) && empty($emailErr) && empty($numberErr) && empty($fieldErr))
    {
        $sql = $conn->prepare("INSERT INTO formentry (name, email, number) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $name, $email, $number);
        
             if ($sql->execute()) {
                //Get the last inserted ID
                $last_id = $conn->insert_id;
            } else {
                $sqlErr = "ERROR: It was not able to execute $sql. " . $conn->error;
                echo $sqlErr;
            }
        $sql->close();

      //Check if there is an error from the First insert query 
    if (empty($sqlErr)){

        $counter = 0;
        foreach($values as $key => $value) {
            $keyT = test_input(mysqli_real_escape_string($conn, $key));
            $valueT = test_input(mysqli_real_escape_string($conn, $value));
            $counter++;
            
            if ($counter > 4){
                $sqls = $conn->prepare("INSERT INTO formfield (formentryId, fieldName, fieldValue) VALUES (?, ?, ?)");
                $sqls->bind_param("iss", $last_id, $keyT, $valueT);
            if ($sqls->execute()) {
            }
                else {
                $sqlErr = "ERROR: It was not able to execute $sqls. " . $conn->error;
                echo $sqlErr;
                mysqli_rollback($conn);
                }
            }
        }
    $sqls->close(); 
    } 

        if(empty($sqlErr)){
            echo "Records added successfully. Thank you.<br>";
            
        } 
        // close connection
        $conn->close();
   
    }
      else{

        echo $nameErr . "<br>" . $emailErr . "<br>" . $numberErr . "<br>" . $fieldErr . "<br>";
        echo "Click <a href='http://localhost/Users/'>HERE</a> to go back to make the appropriate changes and add another record.";
        }



    } else {
         // Log this as a warning and keep an eye on these attempts...
       echo "You cannot be trusted....";
    }
}




//Functions to Test and Trim input, Check Email input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_email($field){
    // Sanitize e-mail address
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    // Validate e-mail address FILTER_VALIDATE_EMAIL is used for this use case. More specific requirements could call for 
    // a more specific Regexp
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    }else{
        return FALSE;
    }
}

 function password_match() {
    # Validate password match
    if (isset($_POST["password"]) && isset($_POST["verify"])) {
      if ($_POST["password"] != "" && $_POST["verify"] != "") {
        if ($_POST["password"] != $_POST["verify"]) {
          $_SESSION["error"][] = "Passwords don't match";
        }
        else if (strlen($_POST["password"]) < 6 || strlen($_POST["verify"]) < 6) {
          $_SESSION["error"][] = "Passwords should be more than 6 characters";
        }
      }
    }
    
    $this->error_check();
  }
  




//upload
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $extensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$extensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152){
       $errors[]='File size must be excately 2 MB';
    }
    
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"images/".$file_name);
       echo "Success";
    }else{
       print_r($errors);
    }
 }


?>