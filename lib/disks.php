<?php

namespace lib;

class Disks{

	public static function Disks() {
    
    $result = array();
    
    exec('lsblk --pairs', $disksArray);
    
    for ($i = 0; $i < count($disksArray); $i++) { 
		$string = str_replace('"', "", $disksArray[$i]);
		$string = str_replace(' ', "&", $string);
		parse_str($string, $output);		
		$result[$i]['name'] = $output["NAME"];     
		$result[$i]['maj:min'] = $output["MAJ:MIN"];     
		$result[$i]['rm'] = $output["RM"];     
		$result[$i]['size'] = $output["SIZE"];     
		$result[$i]['ro'] = $output["RO"];     
		$result[$i]['type'] = $output["TYPE"];     
		$result[$i]['mountpoint'] = $output["MOUNTPOINT"];     
    }
    
    return $result;
	}  
}

?>