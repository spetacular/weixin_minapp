//show.js
var sgsdata = require('../../utils/sgsdata.js')
//获取应用实例
var app = getApp()
Page({
  data: {
      answers:{},
      answer:{},
      checked_0:false,
      checked_1:false
  },
  //表单提交事件处理函数
  formSubmit: function(e) {
      var nextId = e.detail.value.nextId;
      if(nextId == ""){
        return;
      }
      if(nextId.indexOf('result') != -1){//result_N show result
        var results = nextId.split('_');
        wx.navigateTo({
            url: '../sgs/result?id='+results[1]
        })
      }else{
        this.setData({
            checked_0:false,
            checked_1:false,
            answer:this.data.answers[nextId]
            
        });
      }
  },
  onLoad: function () {
    var ans = sgsdata.getAnswer();
    this.setData({
        answers:ans,
        answer:ans[0]
    });
  }
})