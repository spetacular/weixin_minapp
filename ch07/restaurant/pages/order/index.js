//index.js
var common = require('../../utils/common.js')
//获取应用实例
var app = getApp()
Page({
  data: {
    queues: null,
  },
  goToQueue: function (e) {
    var catid = e.target.dataset.catid;
    wx.navigateTo({
      url: '../order/queue?catid=' + catid
    })
  },
  onLoad: function () {
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function (userInfo) {
      //更新数据
      that.setData({
        userInfo: userInfo
      })
    })
  },
  onShow: function () {
    this.reLoad()
  },
  onPullDownRefresh: function () {
    this.reLoad();
    wx.stopPullDownRefresh();
  },
  reFresh:function(){
    this.reLoad()
  },
  reLoad: function () {
    var that = this
    wx.request({
      url: common.baseUrl + 'index.php/api/user/queues',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        that.setData({
          queues: res.data
        })
      }
    });
  },
  onShareAppMessage: function () {
    return {
      title: '我在微餐厅预定了位置，快来啊',
      path: '/pages/order/index'
    }
  }
})