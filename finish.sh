#!/bin/sh
clear

# ezt kell beleírnom : mysqldump --host="mysql" --user="root" --password="root" laravel > laravel.sql

# - CONFIG START -

# SQL szerver config
sqluser=root
sqlpassword=B594tC56@tapai

# GIT szerver config
repository_url=

# FTP szerver 1 config
scpserver=192.168.2.98
scpserverprootort=22
scpserveruser=tapaizoltan
scpserverpassword=B594tC56@tapai
scpserverremotepath=Desktop

# Szerver vagy helyi mentési beállítás. Az értéke lehet: scpserver1, scpserver2, remotefolder, local
selectedserver=local

# - CONFIG END -

echo "•••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••"
echo "••     BrunchMAN Helyi vagy Felhőzött Biztonságimentő Script     ••"
echo "••           BrunchMAN Local or Cloudy Backup Script             ••"
echo "••                      v2.2 build221114                         ••"
echo "•••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••"
rm /var/www/html/backuplog.txt

sleep 2

echo $(date) ••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••• >> /var/www/html/backuplog.txt
echo $(date) ••     BrunchMAN Helyi vagy Felhőzött Biztonságimentő Script     •• >> /var/www/html/backuplog.txt
echo $(date) ••           BrunchMAN Local or Cloudy Backup Script             •• >> /var/www/html/backuplog.txt
echo $(date) ••                     v2.2 build221114                          •• >> /var/www/html/backuplog.txt
echo $(date) ••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••• >> /var/www/html/backuplog.txt

echo "4/1-es fázis - Korábbi adatmentések törlése..."
echo $(date) 4/1-es fázis - Korábbi adatmentések törlése... >> /var/www/html/backuplog.txt
sleep 1
rm /var/www/html/backup/brunchman_backup_*.zip
echo ""
echo "4/1-es fázis - Adatok törlése megtörtént!"
echo $(date) 4/1-es fázis - Adatok törlése megtörtént! >> /var/www/html/backuplog.txt

sleep 1

echo ""
echo "4/2-es fázis - SQL adatbázis mentése..."
echo $(date) 4/2-es fázis - SQL adatbázis mentése... >> /var/www/html/backuplog.txt
sleep 1
today="$(date '+%Y-%m-%d')"
rm /var/www/html/brunchman/backup/*.sql
mysqldump --user="$sqluser" --password="$sqlpassword" brunchman > /var/www/html/brunchman/backup/brunchman-$today.sql
echo ""
echo "4/2-es fázis - SQL adatbázis mentése megtörtént!"
echo $(date) 4/2-es fázis - SQL adatbázis mentése megtörtént! >> /var/www/html/backuplog.txt

sleep 1

echo ""
echo "4/3-as fázis - Fájlok tömörítése..."
echo $(date) 4/3-as fázis - Fájlok tömörítése... >> /var/www/html/backuplog.txt
sleep 1
zip -r brunchman_backup_$today.zip /var/www/html/brunchman/
echo ""
echo "4/3-as fázis - Fájlok tömörítése megtörtént!"
echo $(date) 4/3-as fázis - Fájlok tömörítése megtörtén! >> /var/www/html/backuplog.txt

sleep 1

if [ "$selectedserver" = local ];
	then
        echo ""
        echo "4/4-as fázis - A biztonsági mentés helyi mappába sikerült!"
        echo $(date) 4/4-as fázis - Adatmentés helyi mappába sikerült! >> /var/www/html/backuplog.txt
		sleep 1
		echo "További szép napot!"
        echo $(date) További szép napot! >> /var/www/html/backuplog.txt
		sleep 3
		clear
    fi
if [ "$selectedserver" = remotefolder ];
	then
        echo ""
        echo "4/4 - Adatmentés helyi mappába..."
        echo $(date) 4/4-as fázis - Adatmentés mentése helyi mappába... >> /var/www/html/backuplog.txt
        sleep 1
        mv venture_flame_full_backup_$today.zip /var/www/html/backup/venture_flame_full_backup_$today.zip
        echo ""
        echo "A biztonsági mentés helyi mappába sikerült!"
        echo $(date) 4/4-as fázis - Adatmentés helyi mappába megtörtén! >> /var/www/html/backuplog.txt
		sleep 1
		echo "További szép napot!"
		sleep 2
		clear
    fi
if [ "$selectedserver" = scpserver1 ];
	then
        echo ""
        echo "4/4 - Adatmentés feltöltése felhőbe..."
        echo $(date) 4/4-as fázis - Adatmentés feltöltése felhőbe... >> /var/www/html/backuplog.txt
        sleep 1
        mv venture_flame_full_backup_$today.zip /var/www/html/backup/venture_flame_full_backup_$today.zip
        sshpass -p $scpserverpassword1 scp -P$scpserverport1 venture_flame_full_backup_$today.zip $scpserveruser1@$scpserver1:/$scpserverremotepath1/
        echo ""
        echo "A biztonsági mentés feltöltése sikerült!"
        echo $(date) 4/4-as fázis - Adatmentés feltöltése megtörtén! >> /var/www/html/backuplog.txt
		sleep 1
		echo "További szép napot!"
		sleep 2
		clear
	fi
if [ "$selectedserver" = scpserver2 ];
	then
        echo ""
        echo "4/4 - Adatmentés feltöltése felhőbe..."
        echo $(date) 4/4-as fázis - Adatmentés feltöltése felhőbe... >> /var/www/html/backuplog.txt
        sleep 1
        mv venture_flame_full_backup_$today.zip /var/www/html/backup/venture_flame_full_backup_$today.zip
		sshpass -p $scpserverpassword2 scp -P$scpserverport2 venture_flame_full_backup_$today.zip $scpserveruser2@$scpserver2:/$scpserverremotepath2/
        echo ""
        echo "A biztonsági mentés feltöltése sikerült!"
        echo $(date) 4/4-as fázis - Adatmentés feltöltése megtörtén! >> /var/www/html/backuplog.txt
		sleep 1
		echo "További szép napot!"
		sleep 2
		clear
	fi
