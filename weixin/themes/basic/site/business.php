<html>

<head>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
    </script>
    <title></title>
</head>

<body>
<!--xdcs-content  begin-->
    <div class="xdcs-content">
        <!-- <h2> 提交资料  </h2>-->
        <!--xd-content-center  begin-->
        <div class="xd-content-center">
            <div class="xd-no">创业单位</div>
             <!--xdcc-list  begin-->
            <form class="xdcc-list" action="" method="post">
             <!--xdcc-inputbox  begin-->
                 <div class="xdcc-inputbox">
                     <label class="xdcc-card-txt">企业名称<i>*</i></label>
                     <div class="xdcc-input ">
                         <input type="text" class="xdcc-text" placeholder="请输入企业名称"> </div>
                 </div>
             <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">企业性质<i>*</i></label>
                    <div class="xdcc-input">
                        <div class="xdcc-select">请选择  </div>
                        <span class="xdcc-icon"></span>
                        </div>
                </div>
                <div class="xdcc-valid-text">请选择相应选项！</div>
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">成立时间<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入成立时间"> </div>
                </div>
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">注册资本<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="xdcc-text" class="xdcc-text" placeholder="请输入注册资本"> </div>
                </div>
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">控股比例<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入控股比例"> </div>
                </div>
                <!--<div class="xdcc-valid-text">您输入的有误，请重新输入！</div>-->
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">员工人数<i>*</i></label>
                    <div class="xdcc-input ">
                          <input type="text" class="xdcc-text" placeholder="如：50人以上"> </div>
                </div>
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">经营场所<i>*</i></label>
                    <div class="xdcc-input">
                        <input type="text" class="xdcc-text" placeholder="如：写字楼"> </div>
                </div>
                 <!--xdcc-inputbox end-->
                  <!--xdcc-inputbox  begin-->
                 <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">设备情况<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入设备情况"> </div>
                </div>
                 <!--xdcc-inputbox  begin-->
            </form>
               <!--xdcc-list  end-->
        </div>
        <div class="xdcs-apply button">
            <button type="submit" class="xdcs-apply-button">下一步</button>
        </div>
         <!--xd-content-center end-->
    </div>
    <!--xdcs-content end-->
    <!--弹框S-->
    <div class="bomb-box">
        <div class="bomb-bg"> </div>
        <div class="bomb-main">
            <ul class="bomb-main-ul">
                <div class=bomb-main-texts>企业性质<span class="bom-close"></span></div>
                <li><div class=bomb-main-text>私营股份<i></i></div></li>
                <li><div class=bomb-main-text>私营有限<i></i></div></li>
                <li><div class=bomb-main-text>私营合伙<i></i></div></li>
                <li><div class=bomb-main-text>私营独资<i></i></div></li>
                <li><div class=bomb-main-text>个体<i></i></div></li>
            </ul>
            <ul class="bomb-main-ul1">
                <div class=bomb-main-texts>房产性质<span class="bom-close"></div>
                		  <li><div class=bomb-main-text>保障房<i></i></div></li>
                		  <li><div class=bomb-main-text>统建房<i></i></div></li>
                		  <li><div class=bomb-main-text>集资房<i></i></div></li>
                		  </ul>
  					 <ul class="bomb-main-ul2">
                   		  <div class=bomb-main-texts>是否有车<span class="bom-close"></span></div>
                <li><div class=bomb-main-text>有<i></i></div></li>
                <li><div class=bomb-main-text>无<i></i></div></li>
            </ul>
        </div>
    </div>
    <!--弹框E-->
    <script type="text/javascript">
    //点击表单
    $(".xdcc-text,.xdcc-select").click(function() {
        $(".xdcc-input").removeClass('xdcc-border');
        $(this).parents(".xdcc-input").addClass('xdcc-border');
    });
    /*弹窗 S*/
    $('.xdcc-select').click(function() {
        $('.bomb-box,.bomb-main-ul').show();
        $('.bomb-main-ul1,.bomb-main-ul2').hide();
    });
    $('.xdcc-select1').click(function() {
        $('.bomb-box,.bomb-main-ul1').show();
        $('.bomb-main-ul,.bomb-main-ul2').hide();
    });
    $('.xdcc-select2').click(function() {
        $('.bomb-box,.bomb-main-ul2').show();
        $('.bomb-main-ul1,.bomb-main-ul').hide();
    });
    $('.bom-close,.bomb-main-ul li, .bomb-main-ul1 li, .bomb-main-ul2 li').click(function() {
        $('.bomb-box ').hide();
    });
    var bt = $(".xdcc-inputbox ").offset().top;
    var bh = $(".xdcc-inputbox ").height();
    var bc = bt - bh + 20;
    $(window).scroll(function() {
            if($(".bomb-box").css("display") != "none") { //弹出窗口时不允许滚动条滚动
                $(window).scrollTop(bc);
            }
        })
        /*弹窗 E*/
    </script>
</body>

                   		  </ul>
                		  </div>
                	  </div>
                	  <!--弹框E-->
        <script type="text/javascript">
              //点击表单
              $(function(){
                       $(".xdcc-text,.xdcc-select").click(function(){
                           $(".xdcc-input").removeClass('xdcc-border');
                           $(this).parents(".xdcc-input").addClass('xdcc-border');
                       });

                       /*弹窗 S*/
                         $('.xdcc-select').click(function(){
                                         $('.bomb-box,.bomb-main-ul').show();
                                            $('.bomb-main-ul1,.bomb-main-ul2').hide();
                                    });
                                      $('.xdcc-select1').click(function(){
                                         $('.bomb-box,.bomb-main-ul1').show();
                                            $('.bomb-main-ul,.bomb-main-ul2').hide();
                                                 });
                                     $('.xdcc-select2').click(function(){
                                                $('.bomb-box,.bomb-main-ul2').show();
                                                   $('.bomb-main-ul1,.bomb-main-ul').hide();
                                                        });
                                     $('.bom-close,.bomb-main-ul li, .bomb-main-ul1 li, .bomb-main-ul2 li').click(function(){
                                           $('.bomb-box ').hide();
                                      });
                                           $('.bomb-box li').click(function(){
                    $('.bomb-box ').hide();
                    $('.bomb-box li').find('i').removeClass('checkimg');
                    $(this).find('i').addClass('checkimg');
                    var text=$(this).text();
                    if($(this).parent().hasClass('bomb-main-ul')){
                    	$('.xdcc-select').text(text);
                    }
                    else if($(this).parent().hasClass('bomb-main-ul1')){
                    	$('.xdcc-select1').text(text);
                    }
                    else if($(this).parent().hasClass('bomb-main-ul2')){
                    	$('.xdcc-select2').text(text);
                    }
               });
                                      })
                          /*弹窗 E*/
        </script>


    </body>

</html>