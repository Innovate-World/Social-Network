<?php
    include 'connect.php';

    //Creating Tables in the database
    //Admin Table (Contains ServerID, AuthKey)
    $adminTable = "CREATE TABLE IF NOT EXISTS
                    `admin` (
                          `ID` bigint(255) NOT NULL,
                          `securityKey` varchar(255) NOT NULL,
                          `authKey` varchar(255) NOT NULL,
                          PRIMARY KEY (`ID`),
                          UNIQUE KEY `securityKey` (`securityKey`)
                      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

   //Users Table Contains users Data
   $usersTable = "CREATE TABLE IF NOT EXISTS
                    `users`(
                        `userID` varchar(255) NOT NULL,
                        `userName` varchar(255) NOT NULL,
                        `userFullname` varchar(512) NOT NULL,
                        `userEmail` varchar(255) NOT NULL,
                        `userPassword` varchar(512) NOT NULL,
                        `userPhone` int(10) NOT NULL,
                        `userAge` int(3) NOT NULL,
                        `userGender` varchar(10) NOT NULL,
                        `profilePic` varchar(512) NOT NULL,
                        `userBio` varchar(255) NOT NULL,
                        `Country` varchar(50) NOT NULL,
                        `userIP` varchar(255) NOT NULL,
                        `userCreatedDate` varchar(255) NOT NULL,
                        PRIMARY KEY (`userID`),
                        UNIQUE KEY `userName` (`userName`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

   //Posts table contains information about the POSTS
   $postsTable = "CREATE TABLE IF NOT EXISTS
                    `posts`(
                        `postID` varchar(255) NOT NULL,
                        `userID` varchar(255) NOT NULL,
                        `caption` varchar(512) NOT NULL,
                        `imageURL` varchar(512) NOT NULL,
                        `postCreatedDate` varchar(255) NOT NULL,
                        `likesCount` INT(10) NOT NULL DEFAULT 0,
                        PRIMARY KEY (`postID`),
                        FOREIGN KEY (`userID`) REFERENCES users(`userID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    //Contains the likes for all the posts
    $likesTable = "CREATE TABLE IF NOT EXISTS
                    `likes`(
                        `likeID` varchar(255) NOT NULL,
                        `postID` varchar(255) NOT NULL,
                        `userID` varchar(255) NOT NULL,
                        `likeDate` varchar(255) NOT NULL,
                        PRIMARY KEY (`likeID`),
                        FOREIGN KEY (`postID`) REFERENCES posts(`postID`),
                        FOREIGN KEY (`userID`) REFERENCES users(`userID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";


    if($conn->query($adminTable) === TRUE){
        echo "Admin Table Created";
    }
    if($conn->query($usersTable) === TRUE){
        echo "Users Table Created";
    }
    if($conn->query($postsTable) === TRUE){
        echo "Posts Table Created";
    }
    if($conn->query($likesTable) === TRUE){
        echo "Likes Table Created";
    }
?>
