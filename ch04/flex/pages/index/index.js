//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    
  },
  //事件处理函数
  gotodemo: function(e) {
    console.log(e);
    var route = e.currentTarget.dataset.route;
    console.log(route);
    wx.navigateTo({
      url: route
    })
  },
  onLoad: function () {
    console.log('onLoad')
  }
})
