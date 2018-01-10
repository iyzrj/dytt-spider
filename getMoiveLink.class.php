<?php 
require_once __DIR__.'../simple_html_dom.php';
class getMoiveLink{

    public $url = null;
    public function __construct($keyword)
    {

        $keyword = iconv('utf-8','gb2312//IGNORE',$keyword);
        $keyword = urlencode($keyword);
        $this->url = 'http://s.dydytt.net/plus/so.php?kwtype=0&searchtype=title&keyword='.$keyword;
    }


    public function getMoiveHandle()
    {
        $content = $this->curl_post($this->url);
        $html = str_get_html($content);
        $detail = [];
        $detail_url = 'http://www.ygdy8.com';
        foreach($html->find('tbody td b a') as $element) 
        {

               $detail[] = $detail_url.$element->href;
        }

        $res = '';
        foreach ($detail as  $val) {
            # code...
            $content = $this->curl_post($val);
            $html = str_get_html($content);
           $res .=  $this->dw_addr($html);
        }

        if(empty($res)) $res = '没有找到资源或者你输入的电影名字有误';
        return $res;
        exit;
    }

/**
 * 获取首页最新电影
 * @return [type] [description]
 */
    public function getLatest()
    {
        $url = 'http://www.dytt8.net';

        $content = $this->curl_post($url);
        $html = str_get_html($content);
        $table = $html->find('table',1);
        foreach($table->find('tr td a') as $element) 
        {   
            if($element->plaintext !='最新电影下载')
            {
                $name[] = $element->plaintext;
            }
        }

        return $name;
    }




    function curl_post($url)
    {
        $headers = array("application/x-www-form-urlencoded","Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","Cache-Control: no-cache","Pragma: no-cache");
        $ch  = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36');  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //返回数据不直接输出
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); 
        // curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file); //存储提交后得到的cookie数据
        $content = curl_exec($ch);                    //执行并存储结果
       $content =  iconv('gb2312','utf-8//IGNORE',$content);

        curl_close($ch);
        return $content;
    }


/**
 * 获取下载标题和下载链接
 * @param  [type] $html [description]
 * @return [type]       [description]
 */
    public  function dw_addr($html)
    {
        $data ='';
        if(!$html) return $data;
        $url = [];
        $title = "\r\n迅雷下载:\r\n";
        foreach($html->find('table tr td a') as $element) 
        {
            if(strstr($element->href,'ftp'))
            {
           $url[] = $this->ftp2thunder($element->href);

            }elseif(strstr($element->href,'thunder')){
                $url[] = $element->href;
            }
        }

         foreach($html->find('div h1 font') as $element1) 
        {
            $title .= $element1->plaintext;
        }

        if(!empty($url[0]))
        {
        $data = $title.": ".$url[0];
        }
        // $data = [
        //     'title'=>$title,
        //     'down_url'=>$url

        // ];


        return $data;
    }

/**
 * [ftp下载链接转为迅雷链接]
 * @param  [type] $ftp_link [description]
 * @return [type]           [description]
 */
   public function ftp2thunder($ftp_link)
    {
        $link = 'AA'.$ftp_link.'ZZ';
        $link = base64_encode($link);
        $link = 'thunder://'.$link;
        return $link;

    }



}


 ?>