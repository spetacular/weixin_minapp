// pages/order/my.js
var common = require('../../utils/common.js')
var app = getApp()
Page({
  data: {
    userInfo: null,
    queue: null
  },
  reFresh: function () {
    var that = this
    wx.request({
      url: common.baseUrl + 'index.php/api/user/my_queue?gusetId=' + app.globalData.openid,
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        if (res.data.msg == 'NO') {
          wx.showModal({
            title: '提示',
            showCancel: false,
            content: '您还未取号，将跳转到取号页面',
            success: function (res) {
              if (res.confirm) {
                wx.switchTab({
                  url: '../order/index'
                })
              }
            }
          })
        }
        that.setData({
          queue: res.data
        })
      }
    });
  },
  onShow: function () {
    // 页面显示
    this.reFresh();
  },
  onPullDownRefresh: function () {
    this.reFresh();
    wx.stopPullDownRefresh();
  },
  onShareAppMessage: function () {
    return {
      title: '我在微餐厅预定了位置，快来啊',
      path: '/pages/order/index'
    }
  }
})