//index.js
//获取应用实例
var feed = require('../../utils/feed.js')
var common = require('../../utils/common.js')
var app = getApp()
Page({
  data: {
    feeds: {},    
  },
  updateNews: function(){
    var that = this
    wx.request({
              url: common.baseUrl + 'news_rss.php',
              data: {},
              header: {
                  'Content-Type': 'application/json'
              },
              success: function(res) {
                var feeds = feed.getItems(res.data);
                wx.setStorage({
                  key:"news_feeds",
                  data:feeds
                })

                that.setData({
                  feeds:feeds
                })
              }
    })
  },
  //事件处理函数
  bindViewTap: function(e) {
   var currentArticle =  e.currentTarget.dataset.currentarticle;
   var current = feed.findArticle(currentArticle,this.data.feeds);
   try {
      wx.setStorageSync('current_news', current)
   } catch (e) {    
   }
    wx.navigateTo({
      url: '../news/article'
    })
  },
  onPullDownRefresh:function(){
    this.updateNews()
  },
  upper:function(){
    this.updateNews()
  },
  onLoad: function () {
    var that = this
    var feeds = wx.getStorageSync('news_feeds')
    if (feeds) {
        that.setData({
            feeds:feeds
        })
    }else{
        that.updateNews();
    }  
  }
})