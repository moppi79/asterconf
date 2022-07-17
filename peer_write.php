<?php


function get_filewrite(){

            
        //$handle = fopen('temp_peer_list.json', "r+");
        $File_to = 'temp_peer_list.json';
        
        return (json_decode(file_get_contents($File_to), true));

    
}


//add_file(time());

$file_a = get_filewrite();

require 'db_int.php';

// hier wird eine Datei erstellt aus einer Datenbank und dann ins Verzeichgniss mit einer Shell Script datei
// danachj wird der Server reloadet 
// exten => 100,1,Answer()
// same => n,NoOp(Kinder Outdail)

//    exten'].",".$single['priority'].",".$single['app']."(".$single['appdata']."
//
//


if ($file_a == ''){
    
    die('Es sind keine daten zum Speichern vorhanden');
}

foreach($file_a as $file => $tex){
    
    $new_folder = time();
    $bu = $path_asterconf."peer/old/".$new_folder."/";
    $bu_file = $path_asterconf."peer/old/".$new_folder."/".$file;
    
    print "<br>Sichere Datei ".$file." in ".$path_asterconf."peer/old/".$new_folder."<br><br>";
    
    $file_a = 'copy_file.sh 1 '.$file.' '.$new_folder.' '.$bu.' '. $bu_file.'' ;
    include 'shell_script.php';

}


    $file_a = 'copy_file.sh 2 ';
    include 'shell_script.php';
    
    $File_to = 'temp_peer_list.json';
    $file_op = fopen($File_to,'w+');
    $data_lenght =  fwrite($file_op,'');
    fclose($file_op);
            
?>
