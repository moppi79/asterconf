#!/bin/bash

if (( $1 == 1 ));then

echo "mkdir "$4 
echo "cp /etc/asterisk/peer/"$2 $5
echo "cp peer/"$2 "/etc/asterisk/peer/"$2
mkdir $4
cp /etc/asterisk/peer/$2 $5
cp peer/$2 /etc/asterisk/peer/$2
chown asterisk:asterisk /etc/asterisk/peer/$2
fi

if (( $1 == 2 ));then
echo "hier Server neu starten<br>"
/etc/init.d/asterisk reload
fi




