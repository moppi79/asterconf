<?php 
//copyconf.sh
//zum ausführen muss der $file_a frisch gesetzt sein 

//$file = "test.sh"; 


$lalal =  shell_exec('sudo '.$path_asterconf.$file_a);//kopiert daten nach /etc/asterisk und startet den Asterisk neu 

//print $lalal;

echo nl2br($lalal);


?>