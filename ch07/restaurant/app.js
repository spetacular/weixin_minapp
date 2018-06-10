//app.js
var common = require('./utils/common.js')
App({
  onLaunch: function () {
  },
  getUserInfo: function (cb) {
    var that = this
    if (this.globalData.userInfo) {
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
      //调用登录接口
      wx.login({
        success: function (res) {
          wx.getUserInfo({
            success: function (res) {
              console.log(res);
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
          
          if (res.code) {
            console.log(res);
            //发起网络请求
            wx.request({
              url: common.baseUrl + 'index.php/api/user/wxlogin',
              data: {
                code: res.code
              },
              success: function (res) {                
                that.globalData.openid = res.data.openid
                wx.setStorage({
                  key: "openid",
                  data: res.data.openid
                })
              }
            })
          } else {
            console.log('获取用户登录态失败！' + res.errMsg)
          }
        }
      })
    }
  },
  globalData: {
    userInfo: null,
    openid: null
  }
})