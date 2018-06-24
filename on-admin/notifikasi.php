<?php

require '../config.php';
$sql_check = "SELECT id, pesan 
                  FROM notifikasi where flag = 0 LIMIT 1" 
                       ;

    $check_log = $dbconnect->query($sql_check);
      
    while ( $data = $check_log->fetch_array() ) {
           $pesan = $data['pesan'];
           $id = $data['id'];
           echo $pesan;

       }
       if(isset($id)) {
       $sql_check = "update notifikasi set flag=1 where id = $id" 
                       ;

    $check_log = $dbconnect->query($sql_check);
}
            ?>