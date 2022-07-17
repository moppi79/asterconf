<?php
error_reporting(-1);
ini_set("display_errors",1);
require 'db_int.php';
//require 'dialplan_load.php';

//Liste an Asterisk Apps 
//$app_array = array('','Set','System','SIPAddHeader','Return','dial','Answer','Hangup','WaitExten','Set','NoOp','Goto','Background','Playback','VoiceMail','VoiceMailMain','GotoIfTime','MusicOnHold','ConfBridge');




#".$_POST['']."
print"
<html>
<style>
.id1 {
background-color: #d3b53f;
}

.id2 {
background-color: #bababa;
}

.ext_id1 {
background-color: #ad81ab; color: #ddd467;
}

.ext_id2 {
background-color: #af3d80; color: #ded23c;
}

.context_id1 {
background-color: #549e92; color: #b12a78;
}

.context_id2 {
background-color: #007865; color: #ffffff;
}

.new {
background-color: #d6d5b7;
}

.up_butt {
  background-color: #ff6060; 
  border: none;
  color: black;
  padding: 15px 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
}

.context_style_td {
width: 150;
}

.context_style_table {
    
    border : 1px solid black;
    
  
    
}

</style>
<script src='main.js' type='text/javascript'></script>


<body>
";


print "<table><tr><td id='main'>"; #haupt Table (ausgabe Table kommt nun )


//print $ret_html; #print out dialplan_load.php


print "</td><td valign='top'>
<table><tr>
<td id='buttons'>";#rechte seite haupt table

print "<input class='up_butt' value='Dialplan Reload' onclick='PHP_call(\"disk_write.php\")'><br>"; //action='index.php'

print "<br><a href='#' onclick='PHP_call(\"dialplan_load.php\")'>Dialplan</a><br><br>";

print "<input class='up_butt' value='Trunks Reload' onclick='PHP_call(\"peer_write.php\")'>"; //action='index.php'



//print "<br><a href='#' onclick='PHP_call_peer(\"peer.php\")'>Peers</a>";

//print "<br><a href='#' onclick='peer_print_list(\"peer.php\")'>Peer test</a>";
print "<br>";

print "</td>

</tr>
<tr>
<td id='infotable'></td>
</tr>
<tr>
<td id='trunks_list'> Liste <br> an <br> Trunks</td>
</tr>
<tr>
<td id='Trunk_crate'><input type='text' id='new_peer' value=''> <input type='submit' name='' value='new_peer' onclick=peer_new()></td>
</tr>
</tr></table>";#ende Haupt table



print "


</body></html>
<script>

PHP_call(\"dialplan_load.php\")
PHP_call_peer(\"peer.php\")
</script>

";



?>
