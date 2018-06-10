// pages/order/queue.js
var common = require('../../utils/common.js')
var app = getApp()
Page({
  data: {
    userInfo: null,
    catid: 0,
    queue: null
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    var that = this
    that.setData({
      catid: options['catid']
    })
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function (userInfo) {
      //更新数据
      that.setData({
        userInfo: userInfo
      })
    })
  },
  onShow: function () {
    // 页面显示
    var that = this
    wx.request({
      url: common.baseUrl + 'index.php/api/user/queue_by_catid?catid=' + this.data.catid,
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        that.setData({
          queue: res.data
        })
      }
    });
  },
  queue: function (e) {
    var that = this
    wx.request({
      url: common.baseUrl + 'index.php/api/user/do_queue',
      method: 'POST',
      data: {
        catid: that.data.catid,
        guestId: app.globalData.openid,
        nickname: that.data.userInfo.nickName
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        that.showSuccess();
      }
    });
  },
  goBack: function (e) {
    wx.navigateBack({
      delta: 1
    })
  },
  showSuccess: function () {
    wx.showToast({
      title: '成功',
      icon: 'success',
      duration: 4000,
      success: function () {
        wx.switchTab({
          url: '../order/my'
        })
      }
    })
  }
})