<?php
header('Access-Control-Allow-Origin: *');
$code="nothing";

	function gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			
			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),
			
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,
			
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,
			
			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
	}

//$unique_counter=gen_uuid();
extract($_POST);
extract($_GET);
if($unique_counter==null){
	$unique_counter=gen_uuid();
}
$old = umask(0);
mkdir("./working_directory/$unique_counter", 0777  ) or die("<br>Can not create working directory");//a working directory is made for every user where data related to him would be stored
umask($old);

$working_directory="./working_directory/".$unique_counter."/";

echo $code;
$fp = fopen($working_directory.'code.c', 'w') or die("cannot open file");
fwrite($fp, $code);
fclose($fp);

$host="localhost";
$port =5100;//port number
$fp = fsockopen($host, $port, $errno, $errstr);
if( !$fp)
{
	die ("couldnot connect to server");
}
socket_set_timeout($fp, 300);
if (!$fp)
{
	$result = "Error: could not open socket connection";
	echo $result;
}
else
{
	$str="e ".$unique_counter;
	fputs ($fp, $str);
	$msg="";
	$msg=fgets($fp,17);
	sleep(5);
	echo "message from server.c is $msg <br>";
	close($fp);
}

?>