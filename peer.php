<?php 
include('db_int.php');

function add_file($file){

            
        //$handle = fopen('temp_peer_list.json', "r+");
        $File_to = 'temp_peer_list.json';
        
        $inhalt = json_decode(file_get_contents($File_to), true);
        
        if (!isset($inhalt[$file])){
            
            $inhalt[$file] = 1;
            
            //print_r($inhalt);
            //print json_encode($inhalt);
            $file_op = fopen($File_to,'w+');
            
            $data_lenght =  fwrite($file_op,json_encode($inhalt));

            //print "Daten in Temporäre geschrieben geschrieben: ".$data_lenght." Byte";
            
            fclose($file_op);
            
        }    
    
}

function get_filewrite(){

            
        //$handle = fopen('temp_peer_list.json', "r+");
        $File_to = 'temp_peer_list.json';
        
        return (json_decode(file_get_contents($File_to), true));

    
}


function zerlegen ($v,$file){ 
    // Zerlegen der einer Datei zu einem Array mit dessen rückgabe, Typ wird geziehl überprüft 
    $file_op = fopen($v.$file,'r+'); //open File
    //print $verzeichniss.$file;
    $ret = array(); //retuern Array deklariern
    $type = ''; //Wert wird vom Typ her gefüllt
    while (($buffer = fgets($file_op, 4096)) !== false) {
        //if ($buffer[0] != ';'){
        //echo $buffer;
        $next = 1;
            if ($buffer[0] == '['){//prüfung ob es ein neuer container ist 
                //print "#####".$buffer."######";
                //print strlen($buffer);
                $coun = 1;
                $a = ''; //hier wird der string in einzelteile zerlegt bis er ] erreicht
                while ($coun < strlen($buffer)){
                    //print $coun;
                    if ($buffer[$coun] != "]"){
                    $a .= $buffer[$coun];
                    
                    ++$coun;
                    }else{
                        $next = 0; #hier setzen von suche 
                        $coun = strlen($buffer);
                        $type = '';
                    }
                }//ende While $coun <= $buffer
                
                //print_r ($a);
            }//ende [ abfrage
            
            $teile = explode("=", $buffer); //noch mal prüfen wenn ein = im Text ist (PW z.b.)
            
            
            $t1 = trim($teile[0], $characters = " \n\r\t\v\x00");//leerzeichen Entfernen
            
            if ($t1 != '' && $next == 1){ //wenn daten in Zeile vorhanden ist
                if ($t1 == 'type'){ //wenn die type erhalten ist, und somit erster eintrag im Container -- Wenn es vom Script erstellt wurde
                   $type = trim($teile[1], $characters = " \n\r\t\v\x00");//leerzeichen Entfernen
                   $ret[$type] = array();
                   //print "hier ist Type";
                }else{
                    //print $type."aaaa<br>";
                    $ret[$type][$t1] = $teile[1]; //Daten ins array einfügen
                    //print $t1."<br>";
                }
            }
        //}
        
    }
    
    if (!isset($ret['endpoint']['context'])){ //wenn ein Container keinen Endpoint oder Context enthält wird eine dummy erstellt 
        
        $ret['endpoint']['context'] = 'no Context';
        
    }
    return($ret);
}


//print_r($_POST);

if (isset($_POST['new_name'])){
    
    $file =  trim($_POST['file']);
    $handle = fopen($verzeichniss.$file, "w+");
    fclose($handle); 
    $_POST['file'] =$file;
}
//if ($_POST['file'] !=''){
  if (isset($_POST['file'])){ //wenn daten per Post übermittelt werden und File vorhonden
    
    if (isset($_POST['data_new_write'])){
        
        //print_r($_POST['data_new_write']);
        
        $a = json_decode($_POST['data_new_write'], true);
        //print_r($a);
        //print_r($a['new_value_insert']);
        
        foreach($a['new_value_insert'] as $keyaa => $tex){
            //print_r ($keyaa);//."<br>";
            
            if ($tex['value'] != 'nullnull'){
                
                $insert = array();
                $insert['value'] = 'New_value';
                $insert['key'] = $a['new_value_insert'][$keyaa]['value'];
                $insert['akt'] = 'true';
                //print "<br>hier;<br>";
                
                //print "<br>".$a['insert_convert_name'][$keyaa]['value']."<br>";
                
                if (isset($a[$a['insert_convert_name'][$keyaa]['value']])){
                    //print_r($insert);
                    //print "ja ist da";
                    $a[$a['insert_convert_name'][$keyaa]['value']]['999'] = array();
                    $a[$a['insert_convert_name'][$keyaa]['value']]['999'] = $insert;
                }else{
                    //print_r($insert);
                    $a[$a['insert_convert_name'][$keyaa]['value']] = array();
                    $a[$a['insert_convert_name'][$keyaa]['value']]['1'] = array();
                    $a[$a['insert_convert_name'][$keyaa]['value']]['1'] = $insert;
                    //print $a['insert_convert_name'][$keyaa]['value'];
                    //$a[$a['insert_convert_name'][$keyaa]['value']][1] == array();
                    //$a[$a['insert_convert_name'][$keyaa]['value']][1]['value'] == "neuer wert"; 
                }
                
            }
        
        }
        
        //print_r($a);
        unset($a['insert_convert_name']);
        unset($a['new_value_insert']);
        $file = '';
        $name = explode('.',$_POST['file']);
        //print_r ($name);
        foreach($a as $key => $arr){
            $file .= "[".$name[0]."]\n";
            $file .= "type=".$key."\n";
            foreach($arr as $key2 => $tex){
                //print "<br>";
                //print_r($tex);
                if (!$tex['akt'] == 'true'){
                    $file .= ";";
                    
                }
                $file .= $tex['key']."=".$tex['value']."\n";
            }
            $file .= "\n";
        }
        
        //print "<br> <br> <textarea cols='100' rows='30'>".$file."</textarea><br><br>";
        
        $handle = fopen($verzeichniss.$_POST['file'], "w+");
        
        $data_lenght =  fwrite($handle,$file);

        //print "Daten in Temporäre geschrieben geschrieben: ".$data_lenght." Byte";

        fclose($handle); 

        add_file($_POST['file']);
    }
    $a = zerlegen($verzeichniss,$_POST['file']); //File an Classe zum zerlegen schicken
    
    //print_r($a);
    if ($a['endpoint']['context'] == 'no Context'){
        //print count($a['endpoint']);
        unset($a['endpoint']['context']);
        //print count($a['endpoint']);
        //print count($a);
        
        if (count($a['endpoint']) == 0){
            
            unset($a['endpoint']);
        }
    }
    
    //$file_op = fopen($verzeichniss.$_POST['file'],'r+');
    print "<table border='0'><tr><td style='width:500'>"; //Main Sub  Table Left
    print "<table>"; //input table
    print "<tr><td colspan='3'>".$_POST['file']."</td><td></td><td></td><td></td></tr>"; //name von der Datei anzeigen
    $send_value = array(); //array erstellen
    foreach($a as $key1 => $arr1){ //das zurück gelieferte Array zerlegen
        $send_value[$key1] = array(); //das Array für JS/JSON erzeugen. zum auslesen der HTML felder 
     //print $key1;
        
    print "<tr><td colspan='3'>".$key1."</td><td></td><td></td><td></td></tr>"; //anzeigen der Funktiuon
    
    print "<tr><td>Delete</td><td>Aktive</td><td></td><td></td></tr>"; //Optische info für den Nutzer
        
        $count_f = 1;
        foreach($a[$key1] as $key2 => $text){ //inhalt anzeigen
            $send_value[$key1][$key2] = $count_f; //daten für das JSON abfrage system
            $nr = $key1."_".$count_f; //counter_HTML
            #echo $buffer."<br>";
            print "<tr>"; 
            $first = explode(";", $key2); 
            
            if ($key2[0] == ";" ){ //prüfen ob zeile deaktiv ist 
                
                //$de_ak = "true";
                $de_ak = "<input type='checkbox' id='hide_".$nr."' name='subscribe' >";
                
                $key2_1 = substr($key2,1);
                
                
            }else{
                
                //$de_ak = "false";
                $de_ak = "<input type='checkbox' id='hide_".$nr."' name='subscribe' checked>";
                $key2_1 = $key2;
            }
            
            $del_ch =  "<input type='checkbox' id='del_".$nr."' name='subscribe' >"; //Lösch Icon
            #print_r($first);
            
            #print "##### ".count($first)." ######";
            
            
            print "<td>".$del_ch."</td><td>".$de_ak."</td><td>".$key2_1."<input type='hidden' id='key_".$nr."' value='".$key2_1."'></td><td><input type='text' id='val_".$nr."' value='".trim($text)."'></td>"; //die dargestellte zeile
            print "</tr>";
            
             ++$count_f; //Count für HTML erhöhen
        }
        print "<tr><td height='20'></td><td></td><td></td><td></td></tr>"; //Leer ZEile 
    }
    $fill_A = ''; //Rechte seite Menü HTMKL Füller
    $send_value['new_value_insert'] = array(); //JSON HTML/JS daten
    $send_value['insert_convert_name'] = array(); //JSON HTML/JS daten
    $count2 = 1;
    foreach($config_array as $key_funk => $value){ //Arrays aus db_int.php hier in Dropdown zerlegen
        $send_value['new_value_insert'][$key_funk] = $count2;
        $send_value['insert_convert_name'][$key_funk] = $count2;
        $fill_A .= '<input type="hidden" id="del_insert_convert_name_'.$count2.'"><input type="hidden" id="hide_insert_convert_name_'.$count2.'"><input type="hidden" id="val_insert_convert_name_'.$count2.'" value="'.$key_funk.'"><input type="hidden" id="key_insert_convert_name_'.$count2.'" value="'.$key_funk.'">';
        $drop = '';
        $drop .= '<select id="val_new_value_insert_'.$count2.'" name="app" class="">'; # onchange="JSFUNK('TARGT_ID_TO COPY')">
        $drop .= '<option selected value="nullnull"></option>';
        foreach($value as $val){
            $drop .= '<option value="'.$val.'">'.$val.'</option>';
            
        }
        $drop .= "</select>";
        
        //print $drop;
        $fill_A .= '<tr><td>'.$key_funk.'</td><td>'.$drop.'</td><td><input type="hidden" id="hide_new_value_insert_'.$count2.'"><input type="hidden" id="key_new_value_insert_'.$count2.'""><input type="hidden" id="del_new_value_insert_'.$count2.'""></td></tr>'; //zeile fpr Rechte seit
        ++$count2;
    }
    //print_r ($send_value['new_value_insert'] );
    print '<tr><td><input type="submit" name="updae_button" value="update" onclick=peer_submit(\''.$_POST['file'].'\',\''.json_encode($send_value).'\') class="")></td><td></td><td></td></tr>'; //Letzte Zeile Links
    print "</table>";
    
    print "</td><td  style='text-align:right;vertical-align:top'>";//Main Subtable Right 
    print "<table>".$fill_A."</table>"; 
    
    print "</td></tr></table>"; // HTML Ende 
    
    //print  json_encode($send_value);
}else{ // anzeigen Ordner inhalt

    $dir_peer = opendir($verzeichniss); //$verzeichniss Liegt in db_int-php
    
    $data_exist = get_filewrite();
    
    while (($file = readdir($dir_peer)) !== false) { // Verzeichniss auslesen
        
        if (!(($file == ".") || ($file == '..') || ($file == 'old'))) { //Auto daten und Backup Ordner ausblenden
            
            if (!isset($data_exist[$file])){
                echo "<a href='#' onclick='PHP_peer(\"".$file."\")'>".$file."</a> "; //Link erzeugen
            }else{
                echo "(!) <a href='#' onclick='PHP_peer(\"".$file."\")'>".$file."</a> "; //Link erzeugen
            }
            
            //zerlegen($verzeichniss,'daniel_telefon_1.conf');
            $a = zerlegen($verzeichniss,$file);
            //print_r($a);
            if ($a['endpoint']['context'] != ''){
                
                echo "  --> ".$a['endpoint']['context']."<br>";  //anzeigen des context auf der seite 
            }else{
                 echo "<br>";
                
            }
            
        }
        
        
    }
    closedir($dir_peer);

}
?>
