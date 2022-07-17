var total_array = {};

function PHP_call(file) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            print_out(xhttp.responseText);
        }
    };
    xhttp.open("POST", file, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    //xhttp.send('opt=' + cat + '&data=' + data);

}


function print_out(data) {
    document.getElementById('main').innerHTML = data;
    PHP_call_peer("peer.php")
    //console.log('data_search');
  
}


function PHP_call_peer(file) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            peer_print_list(xhttp.responseText);
        }
    };
    xhttp.open("POST", file, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    //xhttp.send('opt=' + cat + '&data=' + data);

}


function peer_print_list(data) {
    console.log('data_search');
    document.getElementById('trunks_list').innerHTML = data;
    //console.log('data_search');
  
}


function PHP_submit2(file) {

//alert(file);
var a = {}
a = JSON.parse(file)

var send_text ='';
for (const [key, value] of Object.entries(a)) {
    
    if (send_text != ''){
        send_text += '&';
    }
    
    if (value !=''){
        console.log('das !=')
        send_text += key+'='+value;    
    }else{
        console.log('wenn der wert leer ist')
        console.log(document.getElementById(key).value);
        var tt = document.getElementById(key).value;
        
        var tt = tt.replace('+', ';plus;')
        var new_key = key.split(a['lslsls'])//id vom key löschen
        console.log(new_key[1]);
        if (new_key[1] == 'app_data'){
           var uuj = tt.replace(/&/g, ';amp;')//Kaufmänisch und entfernen
           send_text += new_key[1]+'='+uuj
            
        }else{
        
            send_text += new_key[1]+'='+tt; 
        }
    }
    
    
}

//a.forEach(b => console.log(b));
console.log(send_text);

console.log(a)

    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            print_out_datasend(xhttp.responseText);
        }
    };
    xhttp.open("POST", 'db_entry.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(send_text);
    
    
    
}

function print_out_datasend(data) {
    document.getElementById('infotable').innerHTML = data;
    //console.log('data_search');
    PHP_call('dialplan_load.php')
    PHP_call_peer("peer.php")
}



function peer_submit(file,submit) {

//alert(file);
var a = {}
a = JSON.parse(submit)
//var aa = 111;
var json_data = {} ;
for (const [key, value] of Object.entries(a)) {
    console.log(key)
    console.log(value)
    json_data[key] = {}; 
    for (const [key1, value1] of Object.entries(value)) {
        if (!document.getElementById('del_'+key+'_'+value1).checked){
            
            console.log(key1)
            console.log(value1)
            console.log('hier werden nun daten abgefragt  --> del_'+key+'_'+value1)
            //console.log(document.getElementById('val_'+key+'_'+value1).value )
            console.log(document.getElementById('hide_'+key+'_'+value1).checked )
            console.log(document.getElementById('del_'+key+'_'+value1).checked )
            json_data[key][value1] = {}
            var tt = document.getElementById('val_'+key+'_'+value1).value;
            var ta = document.getElementById('key_'+key+'_'+value1).value;
            tt = tt.replace('+', ';plus;')
            tt = tt.replace(/&/g, ';amp;')
            json_data[key][value1]['value'] = tt;
            json_data[key][value1]['key'] = ta;
            json_data[key][value1]['akt'] = document.getElementById('hide_'+key+'_'+value1).checked ;
        }
        
    }

}

//a.forEach(b => console.log(b));
//console.log(send_text);

console.log(a)


    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            print_peer(xhttp.responseText);
        }
    };
    xhttp.open("POST", 'peer.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('file=' + file + '&data_new_write=' + JSON.stringify(json_data));
    
    
    
}



function PHP_peer(file,data) {
    
    
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            print_peer(xhttp.responseText);
        }
    };
    xhttp.open("POST", 'peer.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xhttp.send();
    xhttp.send('file=' + file + '&data=' + data);

}



function peer_new() {
    
    var new_name;
    new_name = document.getElementById('new_peer').value;
    
    new_name = new_name + '.conf';
    
    console.log(new_name);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(data)
            //console.log(xhttp.responseText)
            print_peer(xhttp.responseText);
        }
    };
    xhttp.open("POST", 'peer.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xhttp.send();
    xhttp.send('file=' + new_name + '&new_name=1');

}

function print_peer(data) {
    document.getElementById('main').innerHTML = data;
    //console.log('data_search');
    PHP_call_peer("peer.php")
}




