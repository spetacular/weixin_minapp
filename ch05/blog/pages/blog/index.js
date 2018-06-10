//index.js
//获取应用实例
var feed = require('../../utils/feed.js')
var common = require('../../utils/common.js')
var app = getApp()
Page({
  data: {
    feeds: {},
  },
  upper:function(){
    this.updateBlogs()
  },
  onPullDownRefresh: function() {
    this.updateBlogs()
  },
  updateBlogs: function () {
    var that = this
    wx.request({
      url: common.baseUrl + 'blog_rss.php',
      data: {
      },
      header: {
        'Content-Type': 'application/json'
      },
      success: function (res) {
        var feeds = feed.getBlogs(res.data);
        wx.setStorage({
          key: "blog_feeds",
          data: feeds
        })

        that.setData({
          feeds: feeds
        })
      }
    })
  },
  //事件处理函数
  bindViewTap: function (e) {
    var blogid = e.currentTarget.dataset.blogid;
    var current = feed.findBlog(blogid, this.data.feeds);
    try {
      wx.setStorageSync('current_blog', current)
    } catch (e) {
    }
    wx.navigateTo({
      url: '../blog/post'
    })
  },
  
  onLoad: function () {
    var that = this
    var feeds = wx.getStorageSync('blog_feeds')
    if (feeds) {
      that.setData({
        feeds: feeds
      })
    } else {
      that.updateBlogs()
    }
  },
  imageError: function (e) {
    console.log('image发生error事件，携带值为', e.detail.errMsg)
  }
})