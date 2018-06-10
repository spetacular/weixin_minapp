Page({
  data: {
    item: []
  },
  onLoad: function () {
    var that = this
    var feed = wx.getStorageSync('current_news')
    if (feed) {
      feed['detail'] = 1;
      that.setData({
        item: feed
      })
    } else {
      console.log('获取新闻内容失败');
    }
  }
})