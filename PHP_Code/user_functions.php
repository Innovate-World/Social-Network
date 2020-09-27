<?php
	//Checking User Data for logging In
	function isValidUser($userName){
		include 'connect.php';

		//SQL Injection Prevention
		$userCheckQuery = $conn->prepare("SELECT userName, userPassword FROM users WHERE userName=?");
		$userCheckQuery->bind_param('s', $userName);		//Binding Parameter as a String

		if($userCheckQuery->execute()){
			$results = $userCheckQuery->get_result();
			if(mysqli_num_rows($results) > 0){
	            while($row = mysqli_fetch_assoc($results)){
	                //Return userName and Password as Array to convert to json format
					$user = array($row["userName"], $row["userPassword"]);
					return $user;
	            }
	        }
		}
		return array();
	}

	//User Sign Up Process
	function CreateUser($user){
		include 'connect.php';

		//Creating Hashed UserID and userPassword
		$userID = password_hash($user['userName']."-".$user['userIP'], PASSWORD_BCRYPT);
		$userPassword = password_hash($user['userPassword'], PASSWORD_BCRYPT, ["cost"=>12, "salt"=>"82sdd7k239kd2;3923dkw03"]);

		//To Prevent SQL Injection
		$CreateUserQuery = "INSERT INTO users(userID, userName, userFullname, userEmail, userPassword, userPhone, userAge, userGender, profilePic, userBio, Country, userIP, userCreatedDate)
							VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $conn->prepare($CreateUserQuery);
		$stmt->bind_param('sssssiissssss',
							$userID,
							$user['userName'],
							$user['userFullname'],
							$user['userEmail'],
							$userPassword,
							$user['userPhone'],
							$user['userAge'],
							$user['userGender'],
							$user['profilePic'],
							$user['userBio'],
							$user['Country'],
							$user['userIP'],
							$user['userCreatedDate']
						);

		if($stmt->execute()){
			return TRUE;
		}else{
			return FALSE;
		}

	}

?>
