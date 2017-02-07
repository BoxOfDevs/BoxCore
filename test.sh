#!/bin/bash
# ImagicalMine & ImagicalDevTools Installation Script for Linux x86_64(master)
#  _    _            _    _______ 
# | |  | |    /\    | |  |__   __|
# | |__| |   /  \   | |     | |   
# |  __  |  / /\ \  | |     | |   
# | |  | | / ____ \ | |____ | | _ 
# |_|  |_|/_/    \_\|______||_|(_)
# 
# This file is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
# Before you start doing anything, read the license for more detail into what you are allowed to do and not do.
while :
do
clear
cat << "EOF"

  _                       _           _ __  __ _             
 (_)                     (_)         | |  \/  (_)            
  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___  
 | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \ 
 | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/ 
 |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___| 
                     __/ |                                   
                    |___/   
  
EOF

# shopt -s extglob
echo "system> Welcome to the Tesseract and ImagicalDevTools installer!"
echo "system> This installer will automatically install Tesseract and ImagicalDevTools for your server!"
echo "system> Ensure you are running Linux 64-bit, or the installer will not install properly."
z="PHP_7.0.3_x86-64_Linux.tar.gz"
l="install_log/log"
le="install_log/log_errors"
lp="install_log/log_php"
lpe="install_log/log_php_errors"
w="install_log/log_wget"
wp="install_log/log_wget_php"

	mkdir install_log
	echo "system> Installing Tesseract..."
	wget --no-check-certificate https://github.com/pmmp/PocketMine-MP/archive/master.zip >>./$w 2>>./$w
  chmod 777 master.zip >>./$l 2>>./$le
	unzip -o master.zip >>./$l 2>>./$le
	chmod 777 Tesseract-master >>./$l 2>>./$le
	cd Tesseract-master >>./$l 2>>./$le
	chmod 777 src >>../$l 2>>../$le
	cp -rf src .. >>../$l 2>>../$le
	cd .. >>../$l 2>>../$le
	rm -rf Tesseract-master >>./$l 2>>./$le
	rm -rf master.zip >>./$l 2>>./$le
        wget --no-check-certificate https://raw.githubusercontent.com/TesseractTeam/Tesseract/master/start.sh >>./$l 2>>./$le
        wget --no-check-certificate https://raw.githubusercontent.com/TesseractTeam/Tesseract/master/LICENSE.md >>./$l 2>>./$le
        chmod 755 start.sh >>./$l 2>>./$le
	echo
	echo "system> Installing PHP binary..."
	wget --no-check-certificate https://dl.bintray.com/pocketmine/PocketMine/$z >>./$wp 2>>./$wp
	chmod 777 PHP* >>./$lp 2>>./$lpe
	tar zxvf PHP* >>./$lp 2>>./$lpe
	rm -r PHP* >>./$lp 2>>./$lpe
	wget --no-check-certificate https://raw.githubusercontent.com/BoxofDevs/BoxCore/master/tests/TravisTest.php >>./$w 2>>./$w
	chmod 777 TravisTest.php >>./$l 2>>./$le
	mkdir plugins >>./$l 2>>./$le
	echo
        echo "system> ImagicalMine & Plugswork installation completed! Installing ImagicalDevTools..."
        wget --no-check-certificate -O plugins/ImagicalDevTools.phar https://github.com/pmmp/PocketMine-DevTools/releases/download/v1.11.2/PocketMine-DevTools_v1.11.2.phar >>./$w 2>>./$w
        echo
        echo "system> Installation successfully completed!"
exit 0
done
