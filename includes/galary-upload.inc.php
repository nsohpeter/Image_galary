<?php
 if(isset($_POST["submit"])){
   $newFileName = $_POST["filename"];
    if (empty($_POST["filename"])) {
        $newFileName  = "galary";
    }else{
        $newFileName = strtolower(str_replace(" ", "-",  $newFileName));
    }
     $filetitle = $_POST["filetitle"];
     $filedesc = $_POST["filedesc"];
     $file = $_FILES["file"];
    //print_r($file);

     // for error handling purposes
     $filename = $file["name"];
     $filType = $file["type"];
     $fileTempName = $file["tmp_name"];
     $fileError = $file["error"];
     $fileSize = $file["size"];

     // getting the file extension
     $fileExt = explode(".", $filename);
     $fileActExt = strtolower(end($fileExt));

     // the type of img file you want to allow
     $allowed = array("jpg", "jpeg", "png");
       $errors = array();
      // cheching if the right file type exist in the array
     if (in_array($fileActExt, $allowed)) {
        // cheching if there is an error when uploading the file
        if ($fileError === 0) {
            # code...
            if ( $fileSize < 2000000) {
              $fileFullName = $newFileName . "." . uniqid("", true) . "." . $fileActExt;
              $fileDestination  = "../images/gallery/" . $fileFullName;
              include_once '../db_connect.php';
              if (empty($filetitle) || empty($filedesc)) {
                  array_push($errors, "the file title and description is empty");
               }else{
                 $sql = "SELECT * FROM galary";
                 $stmt = mysqli_stmt_init($conn);
                  $stmt_prepare = mysqli_stmt_prepare($stmt, $sql);
                   if($stmt_prepare){
                     mysqli_stmt_execute($stmt);
                     $result = mysqli_stmt_get_result($stmt);
                     $rowCount = mysqli_num_rows($result);
                     $setImageOrder = $rowCount + 1;

                      $sql = "INSERT INTO galary (titleGalary, descGalary, imageFullNameGalary, orderGalary) VALUES (?,?,?,?)";

                     $stmt = mysqli_stmt_init($conn);
                     $stmt_prepare = mysqli_stmt_prepare($stmt, $sql);
                      if($stmt_prepare){
                            mysqli_stmt_bind_param($stmt,'ssss', $filetitle, $filedesc,  $fileFullName,  $setImageOrder);
                            mysqli_stmt_execute($stmt);

                            move_uploaded_file( $fileTempName,  $fileDestination);
                           
                            header("Location: ../galary.php?upload = success");
                        }else{
                           die("Something went wrong;");
                        }
                    }else{
                    array_push($errors, "something went wrong");
                   }
                }

            }else{
              echo "the file size is too large";
              exit();
            }
        }else{
          echo "sorry there is an error in uploading the file";
          exit();
        }
     }else{
        echo "you need to uplode the right file type";
        exit();
     }
 }

?>