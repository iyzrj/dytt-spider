# 注意：已失效
# dytt-spider
## 用PHP实现抓取电影天堂资源的脚本。
* 爬取到页面后采用的是`simple_dom_html`作的解析。
* 在电脑上，用curl获取页面内容执大概是1.5秒左右，直接采用simple_dom_html获取的时间大概在3秒左右
* 原始的下载链接是ftp的，我转成了迅雷下载。
* 功能没写太复杂，就写了获取首页`最新电影`列表和`根据电影名字获取迅雷的下载链接`
