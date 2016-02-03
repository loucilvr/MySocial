#!/bin/bash
  
EXPECTED_ARGS=3
E_BADARGS=65
MYSQL=`which mysql`

#U1="CREATE USER IF NOT EXISTS $2@localhost;"
#U2="SET PASSWORD FOR $2@localhost=PASSWORD('$3');"
U1="GRANT ALL PRIVILEGES ON $1.* TO $2@localhost;"
Q1="CREATE DATABASE IF NOT EXISTS $1;"
Q2="GRANT ALL PRIVILEGES ON $1.* TO $2@localhost IDENTIFIED BY '$3';"
Q3="FLUSH PRIVILEGES;"
SQL="${U1}${Q1}${Q2}${Q3}"
  
if [ $# -ne $EXPECTED_ARGS ]
then
  echo "Usage: $0 database-name database-user database-password"
  exit $E_BADARGS
fi
  
$MYSQL -uroot -p -e "$SQL"
