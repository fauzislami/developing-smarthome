<?php
//definisikan nama file log, berubah tiap bulannya
$timenow = date('Y-m-d H:i:s');
date_default_timezone_set('Asia/Jakarta'); 
$_logfilename = "log_".date("Y-m"); //nama log: log_2011-02
echo $timenow;
 
// jika file log belum ada, buat dulu
if(!file_exists($_logfilename)){
    $_logfilehandler = fopen($_logfilename,'w'); #buat file dengan akses tulis penuh
    fwrite($_logfilehandler, "/* File log untuk aktifitas yang terjadi di rumah */\n"); #tulis header untuk file log, jika perlu
    fclose($_logfilehandler);
}else{
    $_logfilehandler = fopen($_logfilename,'a'); #akses file dengan modus buka/tulis
}
 
// misalnya untuk aksi A
fwrite($_logfilehandler,'User X melakukan aksi A');
fclose($_logfilehandler);