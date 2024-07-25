<?php 
 session_start();
 if (isset($_SESSION['unique_id'])) {
  include_once "config.php";
  $outgoing_id = $_SESSION['unique_id'];
  $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
  $output = "";
  $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
   WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
   OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
  $query = mysqli_query ($conn, $sql);
  if (mysqli_num_rows($query) > 0) {
   while ($row = mysqli_fetch_assoc($query)) {
    if ($row['png'] != ""){
    if ($row['outgoing_msg_id'] == $outgoing_id) {
        $output .= '<div class="chat outgoing">        
         <div class="details">         
         <img src="php/images/'.$row['png'].'" alt="">
          <p>'. $row['msg'] .'</p>
         </div>
        </div>';
       }
       else {
        $output .= '<div class="chat incoming">
         <div class="details">         
         <img src="php/images/'.$row['png'].'" alt="">
          <p>'. $row['msg'] .'</p>
         </div>
        </div>';
    }
}



    elseif($row['video']!= ""){
        if ($row['outgoing_msg_id'] == $outgoing_id) {
            $output .= '<div class="chat outgoing">        
             <div class="details">         
             <video src="php/videos/'.$row['video'].'" alt="Смешнойкот." height="200" controls="controls""></video>
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
           }
           else {
            $output .= '<div class="chat incoming">
             <div class="details">         
             <video src="php/videos/'.$row['video'].'" alt="Смешнойкот." height="200" controls="controls""></video>
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
        };
    }

    elseif($row['myfile']!= ""){
        if ($row['outgoing_msg_id'] == $outgoing_id) {
            $output .= '<div class="chat outgoing">        
             <div class="details">   
             <a class="nav-link" href="../web7/php/file/'.$row['myfile'].'">Открыть файл</a>     
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
           }
           else {
            $output .= '<div class="chat incoming">
             <div class="details">         
             <a class="nav-link" href="../web7/php/file/'.$row['myfile'].'">Открыть файл</a>   
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
        };
    }



    else{
        if ($row['outgoing_msg_id'] == $outgoing_id) {
            $output .= '<div class="chat outgoing">
             <div class="details">
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
           }
           else {
            $output .= '<div class="chat incoming">
             <div class="details">
              <p>'. $row['msg'] .'</p>
             </div>
            </div>';
    }


   
    }
  }
  echo $output;
 }
 else {
    $output .= '<div class="chat incoming">
             <div class="details">
              <p>Вы ещё не начали диалог. Попробуйте ввести и отправить сообщение.</p>
             </div>
            </div>';
    echo $output;
}
 }
?>