const config = require('../../config');
const mongoose = require('mongoose');
const Schema = mongoose.Schema;

//链接数据库
mongoose.connect(config.database);

//定义数据表
const models = {
    user:{
        user:{type:String, require:true},
        password:{type:String, require:true},
        email:{type:String},
        register_time:{type:Number,default:new Date().getTime()},
        sex:{type:String},
        avatar:{type:String},
        nickname:{type:String},
        address:{type:String},
        remark:{type:String}
    }
}

//创建数据表
for (let model in models) {
    mongoose.model(model, new Schema(models[model]));
}

//对外暴露接口
module.exports = {
    //获取数据表对象，返回数据表对象
    getModel:function(name) {
        return mongoose.model(name);
    }
}
