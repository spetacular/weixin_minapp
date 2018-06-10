// pages/menu/index.js
var common = require('../../utils/common.js')
Page({
  data: {
    menus: null
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    var that = this
    wx.request({
      url: common.baseUrl + 'index.php/api/menu/get_menus',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        that.setData({
          menus: res.data
        })
      }
    });
  },
  preview: function (e) {
    var imgsrc = e.target.dataset.imgsrc;
    wx.previewImage({
      current: imgsrc, // 当前显示图片的http链接
      urls: [imgsrc] // 需要预览的图片http链接列表
    })
  },
  onShareAppMessage: function () {
    return {
      title: '我在微餐厅点菜，快来啊',
      path: '/pages/menu/index'
    }
  }
})