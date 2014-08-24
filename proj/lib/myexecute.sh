echo "compiling and running the code.c file";
cd ../static/working_directory/$1;
gcc code.c 2> output

echo "<?php header('Access-Control-Allow-Origin: *'); echo '" > flagfile.php;

cat output >> flagfile.php;

echo "';?>" >> flagfile.php;

cat flagfile.php > flagfile2.php;