//route.js
Page({
  data: {
    option_id: 0
  },
  onLoad: function (option) {
    this.setData({
      option_id:option['id']
    })
  }
})