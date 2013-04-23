#!/bin/sh

#set destination DB as fist parameter
desDB=$1;
inputData=$2;

# parse inputData and write desDB.
devId=0;
unitId=0;
while read line <&7
do
	#echo $line;
	devName=$( echo "${line}" | sed "s/\(.*\)---\(.*\)---\(.*\)/\1/g"  ) 
	devCom=$( echo "${line}" | sed "s/\(.*\)---\(.*\)---\(.*\)/\2/g"  ) 
	devNum=$( echo "${line}" | sed "s/\(.*\)---\(.*\)---\(.*\)/\3/g"  )
	echo "$devId $devName $devCom $devNum";
	#insert into DeviceName table;
	sqlite3 ${desDB} "insert into DeviceName (device_id,device_name,no_total,no_available,description) values ('${devId//\'/''}','${devName//\'/''}','${devNum//\'/''}','${devNum//\'/''}','${devCom//\'/''}');"
	#insert into DeviceUnit table
	
	echo "inserting $devNum units into DeviceUnit table .. ";
	localId=0;
	for (( i=1; i <= $devNum; i++ ))
	do
		sqlite3 ${desDB} "insert into DeviceUnit (unit_id,device_id,unit_code,description) values ('${unitId//\'/''}','${devId//\'/''}','${devId//\'/''} - ${localId//\'/''}','${devName//\'/''} - ${devCom//\'/''} - ${localId//\'/''}');"
		localId=`expr $localId + 1`;
		unitId=`expr $unitId + 1`;
	done
	devId=`expr $devId + 1`
done 7< ${inputData}
