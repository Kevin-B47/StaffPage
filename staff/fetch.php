<?php

    require_once("classes/db.class.php");

    function toCommunityID($id) {
		if (preg_match("/^STEAM_/", $id)) {
			$parts = explode(':', $id);
			return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
		} elseif (is_numeric($id) && strlen($id) < 16) {
			return bcadd($id, '76561197960265728');
		} else {
			return $id; // We have no idea what this is, so just return it.
		}
	}

    $db = new db_conn(false);
    $timedb = new db_conn(true);

    $query = $db->Query("SELECT * FROM ulibtbl WHERE accessblob LIKE '%moderator%' or accessblob LIKE '%admin%'");

    $data = $query->fetchAll();

    $parseData = Array();

    $parseString = "";

    for ($k=0;$k<count($data);$k++){ 
        $json = json_decode($data[$k]["accessblob"],true);

        $json["steamid"] = $data[$k]["uid"];
        $json["steam64"] = toCommunityID($data[$k]["uid"]);
        
		$parseData[] = $json; 
    }

   $getTime = $timedb->Query("SELECT * FROM gmod_trialmod");

   $timedata = $getTime->fetchAll();

   echo json_encode(array(
    "admins" => json_encode($parseData),
    "time" => json_encode($timedata),
   ));

?>