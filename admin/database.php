<?php


function bible_press_install_data( $filename, $log_handle ) {
	$import = new WPSQLImporter();

	$result = "";
	$path = BIBLE_PRESS_PLUGIN_PATH . $filename;

	if (file_exists($path)) {
		$import->importSQL($path, $log_handle);
	}
	else {
		$result = "File does not exist:" . $path . "\n";
		$result .= "Make sure import file is in plugin directory";
	}

	return $result;
}


function bible_press_uninstall_data() {
	global $wpdb;
	$sql = "";

	$sql .= "ALTER TABLE `chapters` DROP FOREIGN KEY `chapters_ibfk_1`;";
	$sql .= "ALTER TABLE `footnotes` DROP FOREIGN KEY `footnotes_ibfk_1`;";
	$sql .= "ALTER TABLE `sections` DROP FOREIGN KEY `sections_ibfk_1`;";
	$sql .= "ALTER TABLE `verseinfo` DROP FOREIGN KEY `verseinfo_ibfk_1`;";
	$sql .= "ALTER TABLE `versesegment` DROP FOREIGN KEY `versesegment_ibfk_1`;"; 

	$sql .= "DROP TABLE IF EXISTS `books`;";
	$sql .= "DROP TABLE IF EXISTS `chapters`;";
	$sql .= "DROP TABLE IF EXISTS `crossReferences`;";
	$sql .= "DROP TABLE IF EXISTS `footnotes`;";
	$sql .= "DROP TABLE IF EXISTS `intro_outline`;";
	$sql .= "DROP TABLE IF EXISTS `intro_paragraph`;";
	$sql .= "DROP TABLE IF EXISTS `sections`;";
	$sql .= "DROP TABLE IF EXISTS 'verseinfo';";
	$sql .= "DROP TABLE IF EXISTS `versesegment`;";

	$wpdb->query($sql);
	
}







class WPSQLImporter{
    /**
     * Loads an SQL stream into the WordPress database one command at a time.
     *
     * @params $sqlfile The file containing the mysql-dump data.
     * @return boolean Returns true, if SQL was imported successfully.
     * @throws Exception
     */
    public static function importSQL($sqlfile, $log_handle){    
	//load WPDB global
	global $wpdb;
        // read file into array
        $file = file($sqlfile);
		// import file line by line
        // and filter (remove) those lines, beginning with an sql comment token
        $file = array_filter($file,
                        create_function('$line',
                                'return strpos(ltrim($line), "--") !== 0;'));
       // and filter (remove) those lines, beginning with an sql notes token
        $file = array_filter($file,
                        create_function('$line',
                                'return strpos(ltrim($line), "/*") !== 0;'));
        $sql = "";
        $del_num = false;
		
        foreach($file as $line){
            $query = trim($line);
            try
            {
                $delimiter = is_int(strpos($query, "DELIMITER"));
                if($delimiter || $del_num){
                    if($delimiter && !$del_num ){
                        $sql = "";
                        $sql = $query."; ";
						fwrite ($log_handle, "OK\n");
                        $del_num = true;
                    }else if($delimiter && $del_num){
                        $sql .= $query." ";
                        $del_num = false;
						fwrite ($log_handle, $sql . "DO\n");
                        $wpdb->query($sql);
                        $sql = "";
                    }else{                            
                        $sql .= $query."; ";
                    }
                }else{
                    $delimiter = is_int(strpos($query, ";"));
                    if($delimiter){
                        $wpdb->query("$sql $query");
						fwrite ($log_handle, $sql . $query . "--\n");
                        $sql = "";
                    }else{
                        $sql .= " $query";
                    }
                }
            }
            catch (\Exception $e)
            {
				fwrite ($log_handle, $e->getMessage() . "<br /> <p>The sql is: $query</p>");
            }
            
        }
    }
}





function import_button_action( $import_filename ) {
	
	echo '<div id="message" class="updated fade"><p>'
		.'The "Import Database" button was clicked.' . '</p></div>';
	echo '<p>Filename to import: ' . $import_filename . '</p>';
	$path = BIBLE_PRESS_PLUGIN_PATH . 'bible-press-import-log.txt';
	$log_handle = fopen($path,"w");

	if ($log_handle == false) {
		echo '<p>Could not write the log file to the temporary directory: ' . $path . '</p>';
	}
	else {
		echo '<p>Please check logfile: ' . $path . '</p>';
		//date_default_timezone_set('America/Chicago');
		fwrite ($log_handle, "Call import button clicked on: " . date("D j M Y H:i:s", time()). "\n");
		fwrite ($log_handle, "log file: " . $path .  "\n");
		try {
			$error = 'Always throw this error';
			$result = bible_press_install_data( $import_filename, $log_handle );
			fwrite ($log_handle, "import data result: " . $result .  "\n");
		} catch (Exception $e) {
			fwrite ($log_handle, 'Caught exception: ' . $e->getMessage() . "\n");
		}
		fwrite ($log_handle , "import finished: " . date("D j M Y H:i:s", time()));
		fclose ($log_handle);
	}
	
}  