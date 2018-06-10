//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    color:'black'
  },
  onLoad: function () {
    console.log('onLoad')
  },
  changeColor: function(e) {
    this.setData({
      color: getRandomColor()
    })
  },
})
//获取随机颜色
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}