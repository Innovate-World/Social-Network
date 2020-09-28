<?php

    function isValidServerID($serverAuthKey, $serverID){
        require_once('connect.php');
        $getAuthKey = $conn->prepare("SELECT authKey FROM admin WHERE securityKey=?");
        $getAuthKey->bind_param('s', $serverID);
        $getAuthKey->execute();

        $results = $getAuthKey->get_result();
        if(mysqli_num_rows($results) > 0){
            while($row = mysqli_fetch_assoc($results)){
                if($serverAuthKey == $row["authKey"]){
                    //It is a valid Server and has authorization key
                    return TRUE;
                }
            }
        }
        //No matching Authorization Key from the server.
        return FALSE;
    }

    function getAuthKey($serverID){
        $authKey = password_hash($serverID, PASSWORD_BCRYPT, ["cost"=>12, "salt"=>"82sdd7k239kd2;3923dkw03"]);
        return $authKey;
    }

    //A cron job will be run every day to update the serverID and authKey in database and on server
    function createAuthKey(){
        require_once('connect.php');

        //Giving An serverID for initiating instance
        $serverID = "server-".md5(rand());

        //Generate Temporary Authentication Key for Server (Change Salt)
        $authKey = getAuthKey($serverID);
        $authKey_generate = $conn->prepare("INSERT INTO admin(securityKey, authKey) VALUES(?,?)");
        $authKey_generate->bind_param('ss', $serverID, $authKey);

        if($authKey->execute()){
            //If auth key is successfully added return serverID
            return $serverID;
        }else{
            //Sends Server Error Response
            http_response_code(500);
        }
    }

?>
