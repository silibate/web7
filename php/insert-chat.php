<?php 
 session_start();
 if (isset($_SESSION['unique_id'])) {
  include_once "config.php";
  $outgoing_id = $_SESSION['unique_id'];
  $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);
  if (!empty($message)) {
    if (isset($_FILES['image'])) {
      $img_name = $_FILES['image']['name'];
      $img_type = $_FILES['image']['type'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $img_explode = explode('.',$img_name);
      $img_ext = end($img_explode);
      $extensions = ["jpeg", "png", "jpg"];

      if (in_array($img_ext, $extensions) === true) {
        $time = time();
        $new_img_name = $time.$img_name;
        move_uploaded_file($tmp_name,"images/".$new_img_name); 
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, png)
    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$new_img_name}')") or die();
       }

      elseif($img_ext=="mp4") {
        $time = time();
        $new_img_name = $time.$img_name;
        move_uploaded_file($tmp_name,"videos/".$new_img_name);
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, video)
    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$new_img_name}')") or die();
      }
      elseif($img_ext=="pdf" || $img_ext=="docx"){
        $time = time();
        $new_img_name = $time.$img_name;
        move_uploaded_file($tmp_name,"file/".$new_img_name);
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, myfile)
    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$new_img_name}')") or die();
      }
      else{
        $new_img_name = "";
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, png)
   VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$new_img_name}')") or die();
    }
      
     }
     
   
  }
 }
 else {
  header("location: ../login.php");
 }
?>