<?php
	//Get the Server ID if it is the first time server request for user login credentials
	//If the user has already logged in then get the userID along with serverID and create a authentication Key
	//for user operations such as Posting an info, following people, liking post, chating with other user.

	$data = json_decode(file_get_contents('php://input'));

	if(!empty($data)){
		//Reason for server request
		$reason = $data->Request;

		if($reason == "userLogin"){
			//Splitting the data obtained into serverID and userName
			$serverID = $data->serverID;
			$userName = $data->userName;

			//Checking if the information is not empty
			if(!empty($serverID) && !empty($userName)){
				require_once('authorization.php');

				$serverAuthKey = getAuthKey($serverID);
				if(isValidServerID($serverAuthKey, $serverID)){
					//Authorized Server Request Proceeding to username/password validation
					require_once('func.php');

					//Returning username and password to the server in json encoded Format
					$user = json_encode(isValidUser($userName));
					return $user;
				}else{
					http_response_code(404);
				}
			}else{
				http_response_code(404);
			}
		}
		else if($reason == "userSignUp"){

			$serverID = $data->serverID;
			if(!empty($serverID)){
				require_once('authorization.php');

				$serverAuthKey = getAuthKey($serverID);
				if(isValidServerID($serverAuthKey, $serverID)){
					//Authorized Server Request Proceeding to Create User
					require_once('user_functions.php');

					//Getting User Details for Sign Up Process and storing it in an Associative Array(UserObject)
					$user = array(
						"userName" => $data->userName,
						"userFullname" => $data->userFullname,
						"userEmail" => $data->userEmail,
						"userPassword" => $data->userPassword,
						"userPhone" => $data->userPhone,
						"userAge" => $data->userAge,
						"userGender" => $data->userGender,
						"profilePic" => $data->profilePic,
						"userBio" => $data->userBio,
						"Country" => $data->Country,
						"userIP" => $data->userIP,
						"userCreatedDate" => date("d-m-Y H:i:s")
					);

					//Creating User and Return Status of Execution
					return CreateUser($user);
				}else{
					http_response_code(404);
				}
			}else{
				http_response_code(404);
			}
		}

	}
	include 'PageNotFound.html';

?>
