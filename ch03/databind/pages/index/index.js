//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    message: 'Hello MINA!',
    id: 0,
    condition_yes:true,
    condition_no:false,
    a:1,
    b:2,
    c:3,
    length:6,
    block:true,
    zero:0
  },
  onLoad: function () {
    console.log('onLoad')
  }
})