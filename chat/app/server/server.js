const express = require('express');
const config = require('../../config');
const bodyParser = require('body-parser');

const userController = require('../models/user');
const app = express();
app.use(bodyParser.json());
app.use('/api/v1/user',userController);

app.listen(config.port);
