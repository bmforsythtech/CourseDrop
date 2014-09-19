<?php
        date_default_timezone_set('America/New_York');
        
        chdir(__DIR__);
        chdir('..');
        
	//Required files
        require('config.php');
	require(DIR_CLASSES .'/mysql.php');
	require(DIR_FUNCTIONS . '/emails.php');
	require(DIR_FUNCTIONS . '/logs.php');
	
	define('ALERT_INT', 86400);
	
	//Connect to MySQL
	$mysql = new Mysqlidb(MY_HOST, MY_USER, MY_PASS, MY_DATA);
	
        //Load the config
        $config = array();
        foreach ($mysql->get('config') as $value) {
            $config[$value['ckey']] = $value['value'];
        }
        
	//Check Instructors who haven't completed their part
	$query = "SELECT * FROM forms WHERE status_code = 1 AND ? > idue AND deleted = ?";
	$params = array(time(), 0);
	$results = $mysql->rawQuery($query, $params);

	foreach($results as $result){
		instructor_request($result);
		$data = array('idue' => $result['idue'] + ALERT_INT);
		
		$mysql->where('id', $result['id']);
		$mysql->update('forms', $data);
	}
	
	//Check Records non approved
	$query = "SELECT * FROM forms WHERE status_code = 2 AND ? > rdue AND deleted = ?";
	$params = array(time(), 0);
	$results = $mysql->rawQuery($query,$params);

	foreach($results as $result){
		records_alert($result);
		$data = array('rdue' => $result['rdue'] + ALERT_INT);
		
		$mysql->where('id', $result['id']);
		$mysql->update('forms', $data);
	}
        
        //Send weekly deans email
        $query = "SELECT * FROM emails WHERE sent = 0 AND ? > tosend";
	$params = array(time());
	$results = $mysql->rawQuery($query,$params);
        
        $divisions = array();
        foreach ($results as $result){
            $data = unserialize($result['email_data']);
            if (isset($data['division']) && !empty($data['division'])){
                $divisions[$data['division']][] = $result;
            }
        }
        
        foreach ($divisions as $division=>$emails){
            $dataset = array();
            foreach ($emails as $email){
                $dataset[] = unserialize($email['email_data']);
            }

            if (deans_email($division, $dataset)){
                foreach ($emails as $email){
                    $mysql->where('id', $email['id']);
                    $mysql->update('emails', array('sent'=>'1'));
                }
            }
        }
?>