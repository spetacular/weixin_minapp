//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    text:'改变文字'
  },
  onLoad: function () {
    console.log('onLoad')
  },
  changeText: function(event) {
    console.log(event)
    var name = event.target.dataset.name;
    this.setData({
      text: name+':文字已经发生改变'
    })
  },
})