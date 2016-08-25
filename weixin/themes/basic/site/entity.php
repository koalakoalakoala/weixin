<html>

<head>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
    </script>
    <title></title>
</head>
<body>
   <!--xdcs-content  begin-->
    <div class="xdcs-content">
        <!--<h2> 首页
                       </h2>-->
    <div class="stjm-banner">
    <p>中英街跨境免税商城O2O</p>
    <span>代理加盟</span>
    </div>
         <!--stjm--top  begin-->
         <div id="stjm-topbox">
            <ul class="stjm-top">
             <li class="cur first-li "><a href="#anchor3">公司介绍</a></li>
             <li><a href="#anchor4">项目介绍</a></li>
             <li><a href="#anchor5">优劣分析</a></li>
            </ul>
            </div>
             <div id="anchor" class="anchor1"></div>
            <div class="stjm-text" id="stjm-text">
            <div id="anchor3"></div>
            <div class="stjm-text-top"><h3>公司介绍</h3></div>
             <div class="stjm-text-content">
            <p>深圳大明世纪集团，成立于2012年，位于以科技、金融为核心的前沿城市深圳。集团在全国有15家分公司，集团旗下在职员工超500人， 是获得国家认证双软高新技术及互联网电子商务示范企业。集团旗下全资子公司深圳中盾网络有限公司是“中英街跨境免税商城”的运营商，在全国33个省市开展互联网+消费金融+跨境便利店O2O业务。集团积极响应国家“互联网+传统行业及智慧社区”建设，为传统快销品行业进行商业模式、管理模式及资本模式的重构创业，营造行业独一无二的社区服务生态圈。</p>
            </div>
             </div>
            <div class="stjm-text" id="stjm-text1">
             <div id="anchor4"></div>
            <div class="stjm-text-top"><h3>项目介绍</h3></div>
            <div class="stjm-text-content">
            <p>中盾跨境免税商城是深圳中盾网络有限公司为主体运营的跨境电子商务平台。平台项目整合了中国拥军优属公益基金会、爱我忠华公益基金及深圳中英街科技有限公司等基金与供应链资源，基于B2C+O2O+LBS跨境消费金融模式，为用户提供一个创新的购物体验。</p>
            <p>中英街跨境O2O实体店是由中国拥军优属基金会直接扶持的互联网创业项目。项目以“互联网+跨境便利店+消费金融”为根基，运用E-ERP与CRM数据化管理系统，整合了跨境品牌、金融理财、平行进口汽车、票务团购、租车接送、网店、积分与平安WIFI等便利店创新盈利模式，加强便利店股权合作，发行原始股，让每一个参与者分享品牌上市的收益。</p>
            </div>
            </div>
           <div class="stjm-text" id="stjm-text2">
            <div id="anchor5"></div>
            <div class="stjm-text-top"><h3>优劣分析</h3></div>
            <div class="stjm-text-content">
            <img src="/img/menu.png">
            </div>
            </div>
             <!--stjm-top  end-->

          <div class="stjm-footerbox	">
            <ul>
                <li><a href="/site/join?type=entity">
                    <span class="stjm-imenu-icon stjm--btn1"></span>
                    <span class="stjm-itext">首页</span>
                </a></li>
                <li><a href="/site/join?type=align">
                    <span class="stjm-imenu-icon stjm--btn2"></span>
                    <span class="stjm-itext">加盟</span></a></li>
                <li><a href="/site/join?type=agency">
                    <span class="stjm-imenu-icon stjm--btn3"></span>
                    <span class="stjm-itext">代理</span></a></li>
                <li><a href="/site/join?type=case">
                    <span class="stjm-imenu-icon stjm--btn4"></span>
                    <span class="stjm-itext">案例</span></a></li>
            </ul>
        </div>

    </div>
    <!--xdcs-content  end-->
     <script type="text/javascript">
     	function getTop(e)
        {
            var offset=e.offsetTop;
            if(e.offsetParent!=null) //只要还有父元素,也就是当前元素不是根节点就继续往上累计元素的高度
                offset+=getTop(e.offsetParent);
            return offset;
        }
        var myBlockTop = getTop(document.getElementById("stjm-topbox"));
        var oneDiv=document.getElementById("stjm-topbox");
        if(!!window.attachEvent)//ie浏览器下。
        {
            window.attachEvent('onscroll',function(){
               if(document.documentElement.scrollTop/* +  (document.body.clientHeight || window.innerHTML) */>= myBlockTop)
                { $('#stjm-topbox').css('position','fixed');
                  $('#stjm-topbox').css('top','0');
                  $('#stjm-topbox').css('left','0');}
                else{  $('#stjm-topbox').css('position','static');}

            });
        }
        if(!!window.addEventListener)//非ie浏览器下
        {
            window.addEventListener("scroll",function(){//document.body.scrollTop可保证chrome的正常。
                if(document.documentElement.scrollTop/* +  (document.body.clientHeight || window.innerHTML) */>= myBlockTop||document.body.scrollTop>=myBlockTop)
                { $('#stjm-topbox').css('position','fixed');
                  $('#stjm-topbox').css('top','0');
                  $('#stjm-topbox').css('left','0');}
                else{  $('#stjm-topbox').css('position','static');}
            });
        }
     </script>
<script type="text/javascript">
       $(function(){
            var lis=$('ul.stjm-top li');
            lis.click(function(){
            $(this).addClass("cur").siblings().removeClass("cur");
             if($('#stjm-topbox').position().top==0){
                     $('#anchor3,#anchor4,#anchor5,#anchor6,#anchor7,#anchor8').css('top','-1.9rem');
                }/*else{
                       $('#anchor3,#anchor4,#anchor5,#anchor6,#anchor7,#anchor8').css('top','2.5rem');
                }*/
            });
            $('.first-li').click(function(){
                 $('#anchor3,#anchor4,#anchor5,#anchor6,#anchor7,#anchor8').css('top','-2.85rem');
            });
       })
       </script>
</body>
</html>