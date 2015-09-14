<?php
	if(isset($_GET)){error_log("get working in progress");		
		
		$myfile = fopen("/var/www/mradi/app/storage/jambo_str1.txt", "w") or die("Unable to open file!");
		$txt = implode("\n", $_GET);
		fwrite($myfile, $txt . "\n\n\n\n");
		fclose($myfile);
	}
	
	if(isset($_POST)){ error_log("post working in progress");
		
		$myfile = fopen("/var/www/mradi/app/storage/jambo_str1.txt", "a") or die("Unable to open file!");
		$txt = "";
		foreach($_POST as $k => $value){
			$txt .=  $k . "   ---   " . $value . "\n"; //implode("\n", $_POST);
		}
		$txt .= "\n\n\n**************\n";
		fwrite($myfile, $txt . "\n\n\n\n");
		fclose($myfile);
	}
echo "done";
?>
