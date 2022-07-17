<?php
error_reporting(-1);
ini_set("display_errors",1);
require 'db_int.php';

//require 'db_int.php';
#`lslsls``id``context``exten``priority``app``appdata`


function color_shuffel($array){ //gibt die nächste Color ID aus

    if ($array[1] == 1){

        $ret[0] = $array[0];
        $ret[1] = 2;
        $ret[2] = $ret[0].$ret[1];
    }else{

        $ret[0] = $array[0];
        $ret[1] = 1;
        $ret[2] = $ret[0].$ret[1];
    }

    return($ret);
}

function dropdown_app ($app_array,$sel,$key1,$color){ //ddrop dowon Feld von App spalte  das $app_arry ist in der db_entry.php
$ret = '';
//$ret .= '<select id="new" name="app">';
$ret ="\n";
$ret .= '<select id="'.$key1.'sel_app" name="appm" class="'.$color.'">';
foreach ($app_array as $key => $value){
    #print $key;

    if ($sel == $value){
        $ret .='<option value="'.$value.'" selected>'.$value.'</option>';
    }else{
        $ret .='<option value="'.$value.'">'.$value.'</option>';

        $ret.="\n";
    }

}
$ret .= "</select>";
  //$ret .= '</select>';
    //print($ret);
    return($ret);
}


function dropdown ($arr,$sel,$color){ //das hier ist das Dropdown feld der Kopier felder
$ret = '';
//$ret .= '<select id="new" name="app">';


foreach ($arr as $key => $value){
    #print $key;
    if ($sel == $value){
        $ret .='<option selected value="'.$value.'">'.$key.'</option>';
    }else{
        $ret .='<option value="'.$value.'">'.$key.'</option>';
    }

}
  //$ret .= '</select>';
    //print($ret);
    return($ret);
}


function create_new($context,$exten,$id,$color){ //hier wird der Button für ein neuss Feld erzeugt -- db_entry.php $_POST['work'] == 'neu_eintrag'
    $send_value['work']='neu_eintrag';

        //wenn Felder '' sind werden sie hier mit null_null gefüllt damit sie im JS nicht durch eine Andere Rutine nicht crashen lässt.
        if ($context == ''){
            $send_value['context'] = 'null_null';
        }else{
            $send_value['context'] = $context;
        }
            if ($exten == ''){
            $send_value['exten'] = 'null_null';
        }else{
            $send_value['exten'] = $exten;
        }

        if ($id == ''){
            $send_value['id'] = 'null_null';

            $field = $send_value['context'].$send_value['exten'].$send_value['id'] ; // ID Input feld wir hier erzeugt

            $send_value['lslsls'] = $field; // das ist zum Steuern das JS, um damit den filed wieder einzukürzen

            $field .= 'new_name'; //das eigentliche Feld was später wieder nach PHP geht

            $send_value[$field]=''; //zum mittelen welche ID JS auslesen soll
        }else{
            $send_value['id'] = $id;
            $send_value['new_name'] = 'null_null';
        }



    if ($id == ''){
        #return('<Form action="db_entry.php" method="post"><input type="text" name="new_name" value="" size="20"><input type="hidden" name="work" value="neu_eintrag"><input type="hidden" name="context" value="'.$context.'"><input type="hidden" name="exten" value="'.$exten.'"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="neu" value="neu" size="20"></form>');
        return('<input type="text" id="'.$field.'" name="test" value="" size="20" class="'.$color.'"><input type="submit" name="Delete_button" value="neu" onclick=PHP_submit2(\''.json_encode($send_value).'\')  class="'.$color.'">');

    }else{
        #return('<Form action="db_entry.php" method="post"><input type="hidden" name="new_name" value=""><input type="hidden" name="work" value="neu_eintrag"><input type="hidden" name="context" value="'.$context.'"><input type="hidden" name="exten" value="'.$exten.'"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="neu" value="neu" size="20"></form>');
        return('<input type="submit" name="Delete_button" value="neue Line" onclick=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color.'">');

    }

}

function  del_button($name,$id,$color){ //der Lösch button für eine ID  --db_entry.php $_POST['work'] == 'delete'

    $send_value['work']='delete';
    $send_value['name']=$name;
    $send_value['id']=$id;
    #$ret = '<Form action="db_entry.php" method="post"><input type="hidden" name="work" value="delete"><input type="hidden" name="name" value="'.$name.'"><input type="hidden" name="id" value="'.$id.'"><input type="submit" name="neu" value="Delete" size="20"><input type="submit" name="updae_button" value="update" onclick=PHP_submit2(\''.json_encode($send_value).'\'</form>';
    $ret = '<input type="submit" name="Delete_button" value="Delete" onclick=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color.'">';

    return($ret);
}

function  updown_button($id,$funk,$color){ #Funk ist plus oder mninus damit man die Felder huch und Runter stellen kann -- db_entry.php $_POST['work'] == 'ud'
    $send_value['work']='ud';
    $send_value['id']=$id;
    $send_value['funk']=$funk;


    if ($funk == 'minus'){
        $ret = '<input type="submit" name="neu" value="minus" onclick=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color.'">';
    }else{

        $ret = '<input type="submit" name="neu" value="plus" onclick=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color.'">';
    }

    //$ret = '<Form action="db_entry.php" method="post"><input type="hidden" name="work" value="ud"><input type="hidden" name="funk" value="'.$funk.'"><input type="hidden" name="id" value="'.$id.'">'.$button.'</form>';

    return($ret);
}


function context($name,$id,$color){ //erstellen vom abschnitt Context


    $ret = "".del_button($name,$id,$color)." #####################  ".create_new($name,'','',$color)."";


    return($ret);
}

function exten($name,$del_id,$del_ext,$color){ //erstellen von abschnitt Kontext

    $ret = " ".del_button($name,$del_id,$color)." "; // *copy button (drop down)*
    return($ret);
}

function app_data($id,$del_ext,$color){ //erstellen von den einzeel Feldern mit der App Data
    $todropdown = array();
    foreach($del_ext as $key => $value){
        foreach($value as $key2 => $value2){
            $arr1 = explode(',',$value2);
            $todropdown[$key.' -- '.$key2] = $arr1[0];
        }
    }

    $send_value['work']='copy';
    $send_value['lslsls']=$id;

    #print_r($todropdown);
    $drop = '';
    $drop .= '<select id="'.$id.'sel_copy_app" name="app" onselect=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color.'">'; # onchange="JSFUNK('TARGT_ID_TO COPY')">
    $drop .= '<option selected value=""></option>';
    $drop .= dropdown ($todropdown,'',$color);
    $drop .= "</select>";

    #$ret = "".del_button('solo',$id)." ".$drop." ".updown_button($id,'plus')." ".updown_button($id,'minus')." ".create_new('','',$id);
    $ret = '';
    $ret.= "<table>\n
            <tr>\n
            <td>\n
            ".updown_button($id,'plus',$color)."
            </td>\n
                        <td>\n
            ".updown_button($id,'minus',$color)."
            </td>\n
                        <td>\n
            ".create_new('','',$id,$color)."
            </td>\n
                        <td>\n
            ".del_button('solo',$id,$color)."
            </td>\n
                        <td>\n

            </td>\n
            </tr>\n
            </table>\n";


    //".$drop."



    return($ret);
}


$ret= array();
$del_ext= array();
$del_con= array();
#ORDER BY context, exten ASC, id ASC

if ($result = $mysqli->query("SELECT * FROM extensions ")) {


    #print_r($result);
     while($obj = $result->fetch_object()){
         if (!array_key_exists($obj->lslsls,$del_arr)){



             $context = $obj->context;
             $exten = $obj->exten;
             $id  = $obj->id;
             if (!array_key_exists($context,$ret)){
                $ret[$context] = array();
                $del_con[$context] = '';
             }else{

                $del_con[$context] .= ',';
             }

            if (!array_key_exists($exten,$ret[$context])){
                 $ret[$context][$exten] = array();
                $del_ext[$context][$exten] = '';
            }else{
                $del_ext[$context][$exten] .= ',';

            }

             $ret[$context][$exten][$id] = array();
            $del_con[$context] .= $obj->lslsls;
            $del_ext[$context][$exten] .= $obj->lslsls;
            foreach($obj as $key => $value){

                $ret[$context][$exten][$id][$key] = $value;
            }
         }
     }

}

$lib = $ret;
ksort($del_con);
ksort($del_ext);
ksort($ret);
foreach($lib as $key1 => $arr1){
//print($key1);
    #print_r($key1);
    ksort($ret[$key1]);
    foreach($arr1 as $key2 => $arr2){
        ksort($ret[$key1][$key2]);
        //print_r($key2);

    }


}

#print_r($del_con);
#print_r($del_ext);
#print_r($ret);

//$color_context = 'context_id1'; //context_id1
//$color_exten = 'ext_id1'; //ext_id2
//$color_line = 'id1 '; //id2





$color_arr['context'] = array('context_id','2','');
$color_arr['ext'] = array('ext_id','2','');
$color_arr['id'] = array('id','2','');

$color_arr['context'] = color_shuffel($color_arr['context']);
$color_arr['ext'] = color_shuffel($color_arr['ext']);
$color_arr['id'] = color_shuffel($color_arr['id']);

$ret_html = '';
$ret_html .= create_new('','','','');
foreach($ret as $key1 => $arr1){
    $color_arr['context'] = color_shuffel($color_arr['context']);
    $ret_html .= '<table id="'.$key1.'" class="'.$color_arr['context'][2].'"><tr><td>'.$key1.' -- '.context($key1,$del_con[$key1],$color_arr['context'][2]).'<td></tr><tr><td>';
    foreach ($arr1 as $key2 => $arr2){
        $color_arr['ext'] = color_shuffel($color_arr['ext']);
        $ret_html .= '<table id="'.$key2.'" class="'.$color_arr['ext'][2].'"><tr><td>'.$key2.' '.exten($key2,$del_ext[$key1][$key2],$del_ext,$color_arr['ext'][2]).'<td></tr><tr><td>';

        #print_r($arr2);
        foreach ($arr2 as $key3 => $arr3){
            $color_arr['id'] = color_shuffel($color_arr['id']);
            $ret_html .= '<table id="'.$key3.'" class="'.$color_arr['id'][2].'"><tr>';

            $send_value['work']='update';
            #$send_value['2']='3';
            #$send_value['3']='2';
            #$send_value['4']='1';
            $ret_html .= "\n";
            #$ret_html .= '<tr><form action="db_entry.php" method="post">';
            //$ret_html .= '<tr>';
            $ret_html .= "\n";
            $temp = array();
            foreach ($arr3 as $key4 => $value){
                #`lslsls``id``context``exten``priority``app``appdata`
                if ($key4 == "priority"){
                    #$ret_html .= '<td>('.$key3.')<input type="text" name="priority" value="'.$value.'" size="5"> </td>';
                    $temp['priority']= $value;
                }
                if ($key4  == "app"){
                    #$ret_html .= '<td>'.dropdown_app ($app_array,$value,$key4).' </td>'; //<input id="'.$key4.'" type="text" name="'.$key4.'" value="'.$value.'" size="20">
                    $temp['app']= $value;
                }
                if ($key4  == "appdata"){
                    $new_str = str_replace(';dOuBlE_QouTE','&quot;',$value);
                    $new_str = str_replace(';SinGlE_QouTE',"'",$new_str);
                    $temp['appdata']= $new_str;
                    #$ret_html .= '<td><input type="text" name="app_data" value="'.$value.'" size="40"> </td>';
                }
                if ($key4  == "lslsls"){
                    $temp['lslsls']= $value;
                    //$key5 = $value;
                }
             #$ret_html .= '<td><input type="submit" name="updae_button" value="update" > <input type="hidden" name="work" value="update" </form></td>';
            }
            $send_value['lslsls']=$temp['lslsls'];
            $send_value[$temp['lslsls'].'app_data']='';
            $send_value[$temp['lslsls'].'sel_app']='';
            $send_value[$temp['lslsls'].'priority']='';
            $ret_html .= '<td><input type="text" id="'.$temp['lslsls'].'priority" value="'.$temp['priority'].'" size="5" class="'.$color_arr['id'][2].'"> </td>';
            $ret_html .= '<td>'.dropdown_app ($app_array,$temp['app'],$temp['lslsls'],$color_arr['id'][2]).' </td>';
            $ret_html .= '<td><input type="text" id="'.$temp['lslsls'].'app_data" value="'.$temp['appdata'].'" size="40" class="'.$color_arr['id'][2].'"> </td>';


            $ret_html .= "\n";
            $ret_html .= '<td><input type="submit" name="updae_button" value="update" onclick=PHP_submit2(\''.json_encode($send_value).'\') class="'.$color_arr['id'][2].'")></td>';
            $ret_html .= "\n";
            $ret_html .= '<td>'.app_data($temp['lslsls'],$del_ext,$color_arr['id'][2]).'</td></tr></table>';
            //$ret_html .= '</table>';
        }


        $ret_html .= '</td></tr></table>';
    }


    $ret_html .= '</td></tr></table>';
}


print $ret_html;
#print_r($ret);
?>