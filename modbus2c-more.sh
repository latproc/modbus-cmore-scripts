#!/bin/bash

TMPFILE=`/bin/tempfile`
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

mv /tmp/TagDB.csv /tmp/TagDB.csv.1

pushd $1
./iod /opt/latproc/config/trunk/ -t -i /opt/latproc/config/persist.dat -m /opt/latproc/config/modbus_mappings.txt
popd

${DIR}/lib/modbus2c-more.php -i /opt/latproc/config/modbus_mappings.txt -o ${TMPFILE}

cat ${TMPFILE} | (read -r; printf "%s\n" "$REPLY"; sort) > /tmp/TagDB.csv
rm -rf  ${TMPFILE} 
diff -u /tmp/TagDB.csv.1 /tmp/TagDB.csv

