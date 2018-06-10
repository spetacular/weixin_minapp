var feed = require('../../utils/feed.js')
var common = require('../../utils/common.js')
var app = getApp()
Page({
  data: {
    item: [],
  },
  onLoad: function () {
    var that = this
    var current_blog = wx.getStorageSync('current_blog')
    if (current_blog) {
      wx.request({
        url: common.baseUrl + 'post_rss.php?id=' + current_blog['id'],
        data: {},
        header: {
          'Content-Type': 'application/json'
        },
        success: function (res) {
          current_blog['detail'] = 1;
          current_blog['content'] = feed.formatText(res['data'][0]);
          that.setData({
            item: current_blog,
          })
        }
      })
    } else {
      console.log('获取博客内容失败');
    }
  }
})