const express = require('express');
const cors = require('cors');
const expressip = require('express-ip');
const requestip = require('request-ip');

// to store the secret information
require('dotenv').config();


const app = express();
const port =  process.env.port || 5000;

app.use(cors());
app.use(express.json());
app.use(requestip.mw());
app.use(expressip().getIpInfoMiddleware);

const mainpage = require('./routes/mainRoute')

// Here we provide the total entire endpoints available for the client.
app.use('/',mainpage);

app.listen(port, () => {
    console.log(`Server is running on port: ${port}`);
});
