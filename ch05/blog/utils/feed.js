var common = require('./common.js')
//从rss xml里解析出文章列表
function getItems(jsonStr) {
    var channel = jsonStr['rss']['channel']['title'];
    var feeds = new Array();
    for (var i=0;i<20;i++){
        var item = jsonStr['rss']['channel']['item:'+i];
        var description = item['description'];            
        var image = formatImage(description);
        description = formatText(description);
        var short_description = description.substring(0,80);
        var feed= {
            'title':item['title'],
            'link':item['link'],
            'pubDate':formatTime(item['pubDate']),
            'guid':item['guid'],
            'short_description':short_description,
            'description':description,
            'image' : image
        }
        feeds.push(feed);
    } 
   return feeds;
}

//从blog xml里解析博客列表
function getBlogs(jsonStr){
    var feeds = new Array();
    for (var x in jsonStr['entry']){    
        var item = jsonStr['entry'][x];            
        var author = item['author'];
        var name = author['name'];        
        var avatar = typeof author['avatar'] == 'string' ?common.baseUrl + "proxy.php?url="+author['avatar'] : '/images/avatar.png';       
        var feed= {
            'title':formatText(item['title']),
            'id':item['id'],
            'pubDate':formatPubedtime(item['published']),
            'summary':item['summary'],
            'diggs':item['diggs'],
            'views':item['views'],
            'comments':item['comments'],
            'link':item['link']['@attributes']['href'],
            'name':name,
            'avatar' : avatar
        }
        feeds.push(feed);      
  }
  return feeds;
}

//获取某篇文章内容
function findArticle(link,feeds){
    for (var x in feeds){
        if(feeds[x]['link'] == link){
            return feeds[x];
        }
    }
    return null;
}

//获取某篇博客文章信息
function findBlog(blogid,feeds){
    for (var x in feeds){
        if(feeds[x]['id'] == blogid){
            return feeds[x];
        }
    }
    return null;
}

//解析新闻时间
//Thu, 13 Oct 2016 07:22:57 GMT ==> 13 Oct 2016
function formatTime(str){
    var pattern = /,\s+(.*\d{4})/;
    var matches = str.match(pattern);
    if(undefined == matches[1]){
        return str;
    }else{
        return matches[1];
    }   
}

//解析博客时间
//2016-10-14T11:55:00+08:00 ==> 2016-10-14 11:55:00
function formatPubedtime(str){
    var pattern = /(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2}:\d{2})/;
    var matches = str.match(pattern);
    if(undefined == matches[1]){
        return str;
    }else{
        return matches[1]+' '+matches[2];
    } 
}

//解析图片
function formatImage(str){
    var pattern = /src="(.*?)"/;
    var matches = str.match(pattern);
    var url;
    if(undefined == matches[1]){
        url = "";
    }else if(matches[1].indexOf('http:') == -1){
        url = 'http:'+matches[1];
    }else{
        url = matches[1];
    }
    if(url.indexOf('rssclick') == -1){
        return url;
    }else{
        return "";
    }
}

//格式化文本
function formatText(str){
    if(str.length == 0){
        return ""; 
    }     
    str = str.replace('<![CDATA[', "");//移除CDATA开头
    str = str.replace(/<.*?>/g,"");//移除html tag起始部分，如<strong>
    str = str.replace(/<img.*\/>/g,"");//移除图片    
    str = str.replace(/<\/p>/g,"\n");//p标签变为换行符，实现换行
    str = str.replace(/<\/.*?>/g,"");//移除html tag结束部分，如</strong>
    str = str.replace(/\]\]>/g,"");//移除CDATA结尾
    
    str = str.replace(/&ldquo;/g,"\"");//替换左引号
    str = str.replace(/&rdquo;/g,"\"");//替换右引号
    str = str.replace(/&nbsp;/g,"");//替换空格
    str = str.replace(/&gt;/g,">");//替换大于号
    str = str.replace(/&lt;/g,"<");//替换小于号
    str = str.replace(/&quot;/g,"\"");//替换引号
    str = str.replace(/&middot;/g,"·");//替换圆点
    str = str.replace(/&mdash;/g,"—");//替换破折号
    str = str.replace(/&amp;/g,"&");//替换&符号
    return str
}

module.exports = {
  getItems: getItems,
  findArticle:findArticle,
  getBlogs:getBlogs,
  findBlog:findBlog,
  formatText:formatText
}