<?php
error_reporting(-1);
ini_set("display_errors",1);

require 'db_int.php';

function new_sort($mysqli,$context,$exten){
    
    $del_arr = del_arry($mysqli);
    print"sort stort";
    print_r($del_arr);
    
    if ($result = $mysqli->query("SELECT * FROM extensions WHERE context = '".$context."' and exten = '".$exten."' ORDER BY ID ASC; ")) {
        
        $count = 0;
        
        #print_r($result);
         while($obj = $result->fetch_object()){ 
             if (!array_key_exists($obj->lslsls,$del_arr)){
                
                if ($count != $obj->id){
                    print "UPDATE `extensions` SET `id` = '".$count."' WHERE `extensions`.`lslsls` = ".$obj->lslsls."; ";
                    $mysqli->query("UPDATE `extensions` SET `id` = '".$count."' WHERE `extensions`.`lslsls` = ".$obj->lslsls."; ");
                    $count++;
                }else{
                    print $count;    
                   $count++; 
                }
                
                 
             }
         }
    }
    
}

function call_akt($mysqli,$context,$exten){//aktuellen stand ohne glösche abfragen 
    $del_arr = del_arry($mysqli);

        
    if ($result = $mysqli->query("SELECT * FROM extensions WHERE context = '".$context."' and exten = '".$exten."' ORDER BY ID ASC; ")) {
        
        $ret = array();
        
        #print_r($result);
         while($obj = $result->fetch_object()){ 
             if (!array_key_exists($obj->lslsls,$del_arr)){
                $ret[$obj->id] = array();
                
                $ret[$obj->id]['lslsls'] = $obj->lslsls;
                $ret[$obj->id]['id'] = $obj->id; 
             }
         }
    }
        return($ret);
}


if (!$_POST == []){
    print_r($_POST);
    
     if ($_POST['work'] == 'copy'){
         
         print "copy";
         
     }
    
    
    if ($_POST['work'] == 'update'){
            
        
        
        $new_str = str_replace(';amp;','&',$_POST['app_data']);
        $new_str = str_replace('"',';dOuBlE_QouTE',$new_str);
        $new_str = str_replace("'",';SinGlE_QouTE',$new_str);
        $new_str = str_replace(';plus;','+',$new_str);
        print "<br>";
        print $new_str;
        #Array ( [priority] => n [app] => Playback [app_data] => hello [updae_button] => update [work] => update ) 
         print "UPDATE `extensions` SET `appdata` = '".$new_str."',`priority` = '".$_POST['priority']."',`app` = '".$_POST['sel_app']."'  WHERE `extensions`.`lslsls` = ".$_POST['lslsls']."; ";
         $mysqli->query("UPDATE `extensions` SET `appdata` = '".$new_str."',`priority` = '".$_POST['priority']."',`app` = '".$_POST['sel_app']."'  WHERE `extensions`.`lslsls` = ".$_POST['lslsls']."; ");
        
    }
    if ($_POST['work'] == 'neu_eintrag'){//Volständig neuer contgext
        
        $val_arr =array('context','exten','id','new_name'); 
        
        foreach($val_arr as $key){
            if ($_POST[$key] == 'null_null'){
                $_POST[$key] = '';
            }
        }
        
    
        if (($_POST['new_name'] != '') AND ($_POST['context'] == '')){
            //print "new context";
            
            print "INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['new_name']."', '_.!', '1', 'NoOp', 'Call on Catch all');";
            $mysqli->query("INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['new_name']."', '_.!', '1', 'NoOp', 'Call on Catch all');");
            
        }
        
            
        if (($_POST['new_name'] != '') AND ($_POST['context'] != '')){
            print "new exten";
            $new_str = str_replace(';plus;','+',$_POST['new_name']);
            print "INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['context']."', '".$new_str."', '1', 'NoOp', 'New exten');";
            $mysqli->query("INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['context']."', '".$new_str."', '1', 'NoOp', 'New exten');");
        }
    
    
    
        if ($_POST['id'] != ''){
         #$mysqli->query("INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['new_name']."', '._!', '1', 'NoOp', 'Call on Catch all');");
         
         //print "INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '0', '".$_POST['new_name']."', '._!', '1', 'NoOp', 'Call on Catch all');";
         
             if ($result = $mysqli->query("SELECT * FROM extensions WHERE lslsls = ".$_POST['id']." ")) {
                while($obj = $result->fetch_object()){ 
                 print "<br>";
                 $temp = call_akt($mysqli,$obj->context,$obj->exten);
                 $count = 0 ;
                 foreach ($temp as $a){
                     #print "A:".$a['id'];
                     #print "POST:".$_POST['id'];
                     #print "count:".$count;
                     #print "<br>";
                     if ($a['lslsls'] == $_POST['id']){
                        ++$count;   
                        print "INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '".$count."', '".$obj->context."', '".$obj->exten."', 'n', 'NoOp', 'New Line');";
                        $mysqli->query("INSERT INTO `extensions` (`lslsls`, `id`, `context`, `exten`, `priority`, `app`, `appdata`) VALUES (NULL, '".$count."', '".$obj->context."', '".$obj->exten."', 'n', 'NoOp', 'New Line');");
                     }else{
                         
                         if ($a['id'] != $count){
                         
                         print "UPDATE `extensions` SET `id` = '".$count."' WHERE `extensions`.`lslsls` = ".$a['lslsls']."; ";
                         $mysqli->query("UPDATE `extensions` SET `id` = '".$count."' WHERE `extensions`.`lslsls` = ".$a['lslsls']."; ");
                         }
                     
                     }
                     ++$count;
                     //print_r($a['id']);
                 }
                 
                    
                }
            }
         
        }
    }
    
    if ($_POST['work'] == 'delete'){//löschen einer zeile
        
        $te = explode(',',$_POST['id']);
        
        if ($result = $mysqli->query("SELECT * FROM extensions WHERE lslsls = ".$te[0]." ")) {
            while($obj = $result->fetch_object()){ 

                print ("INSERT INTO `Deleted_ID` (`ID`, `date`, `context`, `exten`, `Del_ID`) VALUES (NULL, '".date("d.m.Y H:i:s")."', '".$obj->context."', '".$obj->exten."', '".$_POST['id']."'); ");
                $mysqli->query("INSERT INTO `Deleted_ID` (`ID`, `date`, `context`, `exten`, `Del_ID`) VALUES (NULL, '".date("d.m.Y H:i:s")."', '".$obj->context."', '".$obj->exten."', '".$_POST['id']."'); ");
                new_sort($mysqli,$obj->context,$obj->exten);
            }
        }
        
        #$mysqli->query("INSERT INTO `Deleted_ID` (`ID`, `date`, `context`, `exten`, `Del_ID`) VALUES (NULL, '345', 'sa', 's', '12'); ");
        
    }
    
    
    if ($_POST['work'] == 'ud'){ //das sortiern und verrücken der einzenen abschiutte den in den Zellen.
        
        if ($result = $mysqli->query("SELECT * FROM extensions WHERE lslsls = ".$_POST['id']." ")) {
            while($obj = $result->fetch_object()){ 

                #$mysqli->query("SELECT * FROM extensions WHERE `context` = '4dtms1' AND `exten` = '_.!' AND id IN ('2','3'); ");
                
                $akt = call_akt($mysqli,$obj->context,$obj->exten);
                
                if ($_POST['funk'] == 'plus'){
                    $other_row = $obj->id - 1;
                    
                }else{
                    
                    $other_row = $obj->id + 1;
                }
                if (array_key_exists($other_row,$akt)){
                 print ("SELECT * FROM extensions WHERE `context` = '".$obj->context."' AND `exten` = '".$obj->exten."' AND id IN ('".$akt[$other_row]['lslsls']."','".$obj->lslsls."'); ");
                    if ($result2 = $mysqli->query("SELECT * FROM extensions WHERE `context` = '".$obj->context."' AND `exten` = '".$obj->exten."' AND lslsls IN ('".$akt[$other_row]['lslsls']."','".$obj->lslsls."'); ")) {
                        
                        //print_r($result2);
                        
                        
                        if ($result2->num_rows == 2){//abfrage ob es wirklich 2 datensätze sind
                            while($obj2 = $result2->fetch_object()){ 
                             //print_r($obj2);
                             
                             if ($obj2->id == $obj->id){
                                 print "UPDATE `extensions` SET `id` = '".$akt[$other_row]['id']."' WHERE `extensions`.`lslsls` = ".$obj2->lslsls."; ";
                                 $mysqli->query("UPDATE `extensions` SET `id` = '".$akt[$other_row]['id']."' WHERE `extensions`.`lslsls` = ".$obj2->lslsls."; ");
                             }else{
                                 
                                 print "UPDATE `extensions` SET `id` = '".$obj->id."' WHERE `extensions`.`lslsls` = ".$obj2->lslsls."; ";
                                 $mysqli->query("UPDATE `extensions` SET `id` = '".$obj->id."' WHERE `extensions`.`lslsls` = ".$obj2->lslsls."; ");
                             }
                            }
                        }
                    }
                }
                
            }
            
            
        }
        
    }
    
    
}


print'<br><br><br><a href="dialplan_load.php">zurück</a>'

?>
