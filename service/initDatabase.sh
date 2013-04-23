#!/bin/sh

sampleDB=celab.empty.sqlite
destDB=celab.sqlite
#Copy to 
cp ${sampleDB} ${destDB}

#Init 

#BorrowStatus
sqlite3 ${destDB} "insert into BorrowStatus values(0,'Muon muon','Muon muon va dang cho duoc accept');" 
sqlite3 ${destDB} "insert into BorrowStatus values(1,'Dang muon','Dang muon va chua co y dinh tra');"
sqlite3 ${destDB} "insert into BorrowStatus values(2,'Muon tra','Muon tra va dang cho duoc accept');"
sqlite3 ${destDB} "insert into BorrowStatus values(3,'Da tra','Da tra mot cach thanh cong');"

#BorrowType
sqlite3 ${destDB} "insert into BorrowType values(0,'Tai phong','Muon va su dung trong phong lab');"
sqlite3 ${destDB} "insert into BorrowType values(1,'Ve nha','Muon va su dung ngoai phong lab');"




