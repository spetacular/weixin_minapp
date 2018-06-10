//result.js
var sgsdata = require('../../utils/sgsdata.js')
//获取应用实例
var app = getApp()
Page({
  data: {
      result:{}
  },
  onLoad: function (options) {
    var id = options['id']
    var results = sgsdata.getResult();
    this.setData({
        result:results[id]
    });
  },
  onShareAppMessage: function () {
    return {
      title: '我是三国杀中的'+this.data['result']['name']+'，快来测测你是谁吧',
      path: 'pages/sgs/index'
    }
  }
})