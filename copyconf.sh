#!/bin/bash
echo "kopiere daten \n <br>"


cp temp_extensions.conf php_dailplan.conf
#chown asterisk:asterisk php_dailplan.conf
cp php_dailplan.conf /etc/asterisk/php_dailplan.conf
chown asterisk:asterisk /etc/asterisk/php_dailplan.conf
echo "daten Kopiert und Rechte gesetzt <br>"


/etc/init.d/asterisk extensions-reload
