<?php
   session_start();
   include_once "config.php";
   $fname = mysqli_real_escape_string($conn, $_POST['fname']);
   $lname = mysqli_real_escape_string($conn, $_POST['lname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
    // let's check user email is valid or not
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //If email is valid
        //Let's check that email already exist in the database or not
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){ //if email already exist
           echo "$email - This email aleady exist";
        }else{
            //let's check user upload file or not
            if(isset($_FILES['file'])){ //if file is uploaded
                $file_name = $_FILES['file']['name']; //getting user uoload file name
                $tmp_name  = $_FILES['file']['tmp_name']; //this temporary name is used to save file in our folder

                //let's explode file and get the last extension like jpg png
                $file_explode = explode('.', $file_name);
                $file_ext = end($file_explode); //here we get the extension of an user uploaded file
                $extension = ['png', 'jpeg', 'jpg']; //there are same valid file ext and we're store them in array
                if(in_array($file_ext, $extension)){ //if user upload file ext is matched with any array extension
                    $time = time(); //this will return us current time
                                    //we need this time because when you uploading user img to in our folder we rename user file with curren time
                                    //so all the img file will have a unique name
                    //let's move the user uploaded img to our particular folder
                    $new_img_name = $time . $file_name;
                    $target_dir = __DIR__ . "/images/" . $new_img_name;
                    if (move_uploaded_file($tmp_name, $target_dir)) { //if user upload img move to our folder successfully
                        $status = "Active Now"; //once user singed up then this status will be active now
                        $random_id = rand(time(), 10000000); //create random id for user
                        // Hash the password before storing
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");
                                if (!$sql2) {
                                    die("SQL Error: " . mysqli_error($conn)); // Print the SQL error if query fails
                                }
                 if($sql2){ //if these data inserted
                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                    if(mysqli_num_rows($sql3) > 0){
                        $row = mysqli_fetch_assoc($sql3);
                        $_SESSION['unique_id'] = $row['unique_id']; // using this session we used user unique_id in other php file
                        echo "Success!";
                    }
                 }else{
                    echo "Something went wrong";
                 }
                }
                }else{
                    echo "Please select an image file - jpeg, jpeg, png!";
                }
            }else{
                echo "Please select an image file";
            }
        }
    }else{
        echo "$email - This is not a valid email";
    }
   }else{
       echo "All input field are required";
   }
?>
