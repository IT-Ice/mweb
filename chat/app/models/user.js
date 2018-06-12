const express = require('express');
const model = require('../models/model');
const util = require('../../util');
const User = model.getModel('user');
const Router = express.Router();

//测试接口
Router.get('/',function(req,res){
    return res.json({code:1,user:[{name:'ice',age:18}]});
});

//注册接口
Router.post('/register',(req, res)=>{
    const {user, password, email} = req.body;
    console.log(req.body);
    if (!util.checkEmail(email)) {
        return res.json({code:200,msg:'邮箱不合法',errCode:10003});
    }
    User.findOne({user:user},(err, doc)=>{ 
        if (doc) {
            return res.json({code:200,msg:'用户名已存在',errCode:10000});
        }
    })
})

module.exports = Router;
