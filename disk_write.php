<?php
require 'db_int.php';

// hier wird eine Datei erstellt aus einer Datenbank und dann ins Verzeichgniss mit einer Shell Script datei
// danachj wird der Server reloadet 
// exten => 100,1,Answer()
// same => n,NoOp(Kinder Outdail)

//    exten'].",".$single['priority'].",".$single['app']."(".$single['appdata']."
//
//


$con = '';
$ex = '';
$count = '';
$pri = ''; 
$file = '';


//$data_lenght = 'ERROR!!!!!';

if ($result = $mysqli->query("SELECT * FROM extensions ORDER BY context, exten ASC, id ASC ")) { //daten aus DB abfragen
    
    while($obj = $result->fetch_object()){ 
        if (!array_key_exists($obj->lslsls,$del_arr)){
            //print $obj->lslsls;
        
            if ($con != $obj->context){
                $con = $obj->context;
                $ex = '';
              $file .= "\n[".$obj->context."] \n";  
                
            }
        $new_str = str_replace(';dOuBlE_QouTE','"',$obj->appdata);
        $new_str = str_replace(';SinGlE_QouTE',"'",$new_str);
         if ($ex != $obj->exten ){
            $ex = $obj->exten;

            $file .= "\nExten => ".$obj->exten.",1,".$obj->app."(".$new_str.") \n";   
            $count = 2; 
         }else {
            $file .= "Same => ".$obj->priority.",".$obj->app."(".$new_str.") \n";   
            
            
         }
        }
        
    }
    
};




$handle = fopen("temp_extensions.conf", "w+");

$data_lenght =  fwrite($handle,$file);

print "Daten in Temporäre geschrieben geschrieben: ".$data_lenght." Byte";

fclose($handle); 

print "<br> <br> <textarea cols='100' rows='30'>".$file."</textarea><br><br>

";

$file_a = 'copyconf.sh';

include 'shell_script.php';

?>
