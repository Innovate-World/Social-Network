const router = require('express').Router();
const bcrypt = require('bcryptjs');

router.route('/').post((req,res) =>{
    const username = req.params.username;
    const password = req.params.password;

    /*
    isCC: is correct credintials
    isUSer: if the given user is already a user to the service
    in this code , we check for the username
    1.if not present, send the response as 
        isUser:False
        isCC:False
    2.if the user is present in the database and credintials are correct, send
        isUser:True
        isCC: True
        id: the object id of the user.
    3.if the user is present in the DB and credits are false then send
        isUSer:True
        isCC: false
    4.if there is error with the retrival, then
        log the error in the server
        and then the respose as 500
    */


});

module.exports = router;