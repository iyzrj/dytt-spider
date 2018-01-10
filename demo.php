<?php 
require_once './simple_html_dom.php';
require_once './getMoiveLink.class.php';

//根据名字搜索电影资源
$obj = new getMoiveLink("光辉岁月");
$content = $obj->getMoiveHandle();
echo $content;


//获取首页最新电影名字列表
$list = $obj->getLatest();
print_r($list);
//  ?>