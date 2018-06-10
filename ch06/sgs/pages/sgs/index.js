//index.js
//获取应用实例
var app = getApp()
Page({
  //事件处理函数
  start: function() {
    wx.navigateTo({
      url: '../sgs/show'
    })
  }
})