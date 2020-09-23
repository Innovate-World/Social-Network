const router = require('express').Router();
const http = require('http');
const bcrypt = require('bcryptjs');

router.route('/').post((req,res) =>{
    const email = req.params.email;
    const username = req.params.username;
    const password = req.params.password;    


    // encrypting the password before storing.
    const salt = await bcrypt.genSalt(30);
    const encryptedpassword = await bcrypt.hash(password, salt);


    // we convert the data into JSON to send to the main backend server.
    var data = JSON.stringify({"email":email, "username":username, "password":encryptedpassword});

    // now we create the options.
    // host: is the domain, path: it is the path in the backend server.
    const options = {
        host:'',
        path:'',
        method:'POST',
        headers:{
            'Content-Type': 'application/json',
            'Content-Length': Buffer.byteLength(data)
        }
    };

    // here we set the options for the response. next we send and exit the request.
    var httpreq = http.request(options, function(response){
        response.setEncoding('utf8');
        response.on('data', function(retData){
            console.log(retData);
        });

        response.on('end', function() {
            res.send('ok');
        });
    });
    httpreq.write(data);
    httpreq.end();
});

module.exports = router;