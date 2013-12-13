#!/bin/sh
if [ -d ./PHPExcel ]
then
	echo Class exists running git pull
	cd PHPExcel
	git pull master -t master
	exit
fi
# We need the php classes for from PHPExcel
git init PHPExcel
cd PHPExcel
git remote add master https://github.com/PHPOffice/PHPExcel.git
echo Classes/ >> .git/info/sparse-checkout
git pull master -t master


