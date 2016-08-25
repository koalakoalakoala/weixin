<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no,width=device-width,initial-scale=1" /><!--设置viewport，适应移动设备的显示宽度-->
        <meta name="apple-mobile-web-app-capable" content="yes" /><!--隐藏safari导航栏及工具栏-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!--所有浏览器都以最新模式显示-->
        <title>支付成功</title>
        <link href="css/comm.css" rel="stylesheet" type="text/css" />
        <link href="css/wglobal.css" rel="stylesheet" type="text/css" />
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <script src='js/jquery-1.9.1.min.js' type="text/javascript"></script>
        <!--<script src='js/websrcipt.js' type="text/javascript"></script>-->
    </head>
    <body>
        <div class="mod_container">
            
            <!--404内容 S-->
                <div class="err-content">
                    <img src="/img/404.png">
                    <p>很抱歉，您访问的页面已丢失</p>
              </div>
           <!--404内容 E--> 
           <!--按钮 S-->
             <div class="err-btn">
                <a href="/home/home">
                    返回首页（<span id="z-time">3</span>s）
                </a>
             </div>
           <!--按钮 E-->
        </div>
        <script type="text/javascript">
             /*定时跳转页面 S*/
           $(function(){
                var obj = {
                    time:3,
                    run:function(){
                        var $this=this;
                        setInterval(function(){
                            $this.time=$this.time-1;
                            $("#z-time").text($this.time);
                            if($this.time<=0){
                                window.location.href="<?=Url::to(['/'])?>";
                            }
                        },1000);
                    }
                };
                obj.run();
            })
           /*定时跳转页面 E*/ 
        </script>   
    </body>
</html>
