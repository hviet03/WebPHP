<?php


global $conn;
global $student_id;
// ============= ERROR HANDLING ===================
function customErrorHandler($severity, $message, $file, $line) {
    // Handle the error or log it
    // You can redirect to an error page or display a custom error message
    // instead of showing the actual error details to the user
    header("Location: error_page.php");
    exit;
}

// Set the custom error handler
set_error_handler("customErrorHandler");



// ============= DB ===================

function connect_db() {
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "codeandpunch");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
}

function disconnect_db() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}

function email_validation($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL); //true: valid email , false: invalid email
}

function no_symbol_validation($text){
    return preg_match('/[\'"^£$%&*()}{@#~?><>,|=+¬-]/', $text); //true: invalid text, false: valid text
}

function number_validation($number){
    if (preg_match('/[a-zA-Z\'"^£$%&*()}{@#~?><>,|=_+¬-]/',$number) 
        || strlen($number) > 10){
            return false;
        }
    return true; // true: valid number, false: invalid number
}


function check_parameter(...$agrs){  // check if all the para not null
    $empty_var  = false;            // return false if all the var not null
                                    // return true if 1 of them null
    foreach($agrs as $arg){
        if ($arg){
            continue;
        }
        $empty_var = true;
        
    }
    return $empty_var;
}

function update_record($password,$email,$phone,$id){
    global $conn;
    try{
        $query = "UPDATE information 
        SET password = ?, email = ?, phone_num = ?   
        WHERE user_id = ?;";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('sssi',$password,$email,$phone,$id);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo "update failed";
    }
}
function add_record($username,$password,$role,$fullname,$email,$phone){
    global $conn;
    try{
        if ($role == 'teacher'){
            $role = 1 ;
        }
        else {
            $role = 0;
        }
        $password = hash('sha256', $password);
        $query = "INSERT INTO information (username, role, password, full_name, email, phone_num) VALUES (?,?,?,?,?,?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('sisssi',$username,$role,$password,$fullname,$email,$phone);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo "Add failed";
    }
    
}

function check_login($username,$password){
    global $conn;
   try{
    $_SESSION['password'] = $password;
    $password = hash('sha256', $password);
    $query = "SELECT * FROM information WHERE username = ? AND password = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('ss',$username,$password);
    $preparedStatement->execute();
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "Incorrect username or password!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return false;
    } else {
        // get the username
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        
        return true; 
        
    } 
   }
   catch (Exception $e){
    echo "Login failed";
   }
}
function get_information($id){
    global $conn;
    $query = "SELECT * FROM information WHERE user_id = ?";
    try {
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
    }
    catch(Exception $e ){
        echo "<script>alert('Error connecting to database')</script>";
        exit();
    }
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "No result found !";
        echo "<script type='text/javascript'>alert('$message');</script>";
        
    } else {
        
        $row = $result->fetch_assoc();
        return $row;
}
}

function delete_record($id){
    global $conn;
    try{
        $query = "DELETE FROM `information` WHERE user_id = ?";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$id);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo ("Delete failed !");
    }
}


function get_all_users(){
    global $conn;
    $query = "SELECT * FROM information";
    $result = mysqli_query($conn, $query);
    return $result;
}

function check_dupl_username($str){  // return true if username duplicated, false if no duplicate found
    $result = get_all_users();
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['username'] == $str){
            return true;
        }
    }
    return false;

}
function update_submission($homework_id,$count){
    global $conn;
    try{
        $query = "UPDATE homework 
        SET current_submission = ?  
        WHERE homework_id = ?;";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('ii',$count,$homework_id,);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo "Update submission failed !"; 
     }
}
function count_submission($homework_id){
    
    global $conn;
    try{
         $query = "SELECT COUNT(*) FROM `student_homework` WHERE `homework_id` = ?";
         $preparedStatement = $conn->prepare($query);
         $preparedStatement->bind_param('i',$homework_id);
         $preparedStatement->execute();
         $result = $preparedStatement->get_result();
         if (mysqli_num_rows($result) <= 0) {
        $message = "No result found !";
        echo "<script type='text/javascript'>alert('$message');</script>";
        
    } else {
        
        $row = $result->fetch_assoc();
        return $row['COUNT(*)'];
}
    }
     catch(Exception $e){
         echo "Count submission failed !"; 
      }
}

// ======================= HOMEWORK ===============================================
function get_all_homework(){
    global $conn;
    $query = "SELECT * FROM homework";
    $result = mysqli_query($conn, $query);
    return $result;
}

function get_homework_information($id){
    global $conn;
    $query = "SELECT * FROM homework WHERE homework_id = ?";
    try{
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
    }
    catch(Exception $e ){
        echo "<script>alert('Error connecting to database')</script>";
        exit();
    }
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "No result found !";
        echo "<script type='text/javascript'>alert('$message');</script>";
        
    } else {
        
        $row = $result->fetch_assoc();
        return $row;
}
}
function add_homework($tittle, $description, $file_name, $date){
    global $conn;
   try{
        $current_submission = 0;
        $query = "INSERT INTO homework (tittle, description, file_name, date, current_submission) VALUES (?,?,?,?,?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('ssssi',$tittle, $description, $file_name, $date,$current_submission);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
   }
    catch(Exception $e){
        echo "Add homework failed !"; 
     }
}

function update_homework($homework_id ,$tittle, $description, $file_name, $date){
    global $conn;
    try{
        $query = "UPDATE homework 
        SET tittle = ?, description = ?, file_name = ? , date = ?  
        WHERE homework_id = ?;";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('ssssii',$tittle, $description, $file_name, $date,$homework_id);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo "Update homework failed !"; 
     }
}

function delete_homework($homework_id){
    global $conn;
    try{
        $query = "DELETE FROM `homework` WHERE homework_id = ?";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$homework_id);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
        echo "Delete homework failed !"; 
     }
}

// ======================= Student uploads ===============================================

function add_solution ($student_id, $homework_id,$file_name){
    global $conn;
    try {
        $query = "INSERT INTO student_homework () VALUES (?,?,?)";
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('iis',$student_id, $homework_id,$file_name);
        if ($preparedStatement->execute()){
            return true;
        }
        return false;
    }
    catch(Exception $e){
       echo "Add solution failed !"; 
    }
}



// ======================= FILE ===============================================

function sanitizeFileName($filename) {
    $filename = trim($filename); // delete leading and trailing spaces
    if (strpos($filename, '.') === 0) {   // if the file starts with '.' then remove it 
        $filename = substr($filename, 1);
    }

    $extensions = explode('.', $filename);  // delete all the found extension. only allow 1 first extension
    if (count($extensions) > 2) {
        $filename = implode('.', array_slice($extensions, 0, 2));
    }
    $pattern = '/[^A-Za-z0-9_.-]/';  // remove all the non letters,numbers,underscore,dot,hyphen
    $filename= preg_replace($pattern, '', $filename);
    return $filename;
}

function validateFile($var_name)
{
    $allowedMimeTypes = ['text/plain','application/msword','application/pdf'];
    $allowedExtensions = ['txt','doc','pdf'];
    $maxFileSize = 170000;

    $file = $_FILES[$var_name];
    $tempFile = $file['tmp_name'];

    // Check if file was uploaded successfully
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        return false;
    }

    // Check file MIME type
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $tempFile);
    echo $mimeType;
    finfo_close($fileInfo);
    if (!in_array($mimeType, $allowedMimeTypes)) {
        echo "Invalid file type. Only text,word,pdf files are allowed.";
        return false;
    }

    // Check file extension
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Invalid file extension. Only TXT files are allowed.";
        return false;
    }

    // Check file size
    if ($file['size'] > $maxFileSize) {
        echo "File size exceeds the limit.";
        return false;
    }

    return true;
}

function uploadFile($targetDir,$var_name)
{
    if ($_FILES[$var_name]['name'] != "") {
        // Where the file is going to be stored
        $fileName = $_FILES[$var_name]['name'];
        $tempFile = $_FILES[$var_name]['tmp_name'];
        
        // Sanitized file name
        $temp = basename($fileName);
        $sanitizedFilename = sanitizeFileName($temp);
        // Generate a unique file name
	  
        $uniqueName = uniqid() . '_' . $sanitizedFilename;
        $targetFile = $targetDir . $uniqueName;

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "<script>alert('Sorry, a file with the same name already exists.')</script>";
            return null;
        } elseif (!validateFile($var_name)) {
            echo "<script>alert('Invalid file.')</script>";
            return null; 
        } else {
            // Move uploaded file to the desired directory
            if (move_uploaded_file($tempFile, $targetFile)) {
                echo "<script>alert('File uploaded successfully !')</script>";
                return $targetFile;
            } else {
                echo "<script>alert('Error uploading file.')</script>";
                return null;
            }
        }
    } else {
        echo "<script>alert('No file selected.')</script>";
        return null;
    }
}


?>