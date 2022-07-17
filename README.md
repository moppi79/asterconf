# asterconf
Lightweight Web Configurator

##########


Rights on the Files:

mkdir asterconf/peer
mkdir asterconf/peer/old

chown -R www-data:www-data asterconf/
chmod 777 asterconf/

chmod 777 copy_file.sh
chmod 777 copyconf.sh 

########################

Mysql 
asterconf.sql <-- Import 
########################

Visodu 

add follow entrys

on /../ your path to the Files

www-data ALL=(root) NOPASSWD: /../asterconf/copy_file.sh
www-data ALL=(root) NOPASSWD: /../asterconf/copyconf.sh


#############################

entr in ASTERISK config files

Both entrys on the end of the file with the #

extensions.conf:

#include php_dailplan.conf 

pjsip.conf:

#include peer/*.conf ;das # muss vorran stehen.
