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
            <div class="xd-no">保单信息</div>
             <!--xdcc-list  begin-->
            <form class="xdcc-list" action="" method="post">
             <!--xdcc-inputbox  begin-->
                 <div class="xdcc-inputbox">
                     <label class="xdcc-card-txt">保险公司<i>*</i></label>
                     <div class="xdcc-input ">
                         <input type="text" class="xdcc-text" placeholder="如：太平洋"> </div>
                 </div>
             <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">险种名称<i>*</i></label>
                    <div class="xdcc-input">
                       <input type="text" class="xdcc-text" placeholder="请输入险种名称"> </div>
                </div>
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">约定缴费年限<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入约定缴费年限"> </div>
                </div>
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">生效时间<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="xdcc-text" class="xdcc-text" placeholder="请输入生效时间"> </div>
                </div>
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">月保费金额<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入月保费金额"> </div>
                </div>
                <!--<div class="xdcc-valid-text">您输入的有误，请重新输入！</div>-->
                 <!--xdcc-inputbox  end-->
                 <!--xdcc-inputbox  begin-->
                <div class="xdcc-inputbox">
                    <label class="xdcc-card-txt">总保额<i>*</i></label>
                    <div class="xdcc-input ">
                        <input type="text" class="xdcc-text" placeholder="请输入总保额"> </div>
                </div>
                <!--<div class="xdcc-valid-text">您输入的有误，请重新输入！</div>-->
                 <!--xdcc-inputbox  end-->
            </form>
               <!--xdcc-list  end-->
        </div>
        <div class="xdcs-apply button">
            <button type="submit" class="xdcs-apply-button">下一步</button>
        </div>
         <!--xd-content-center end-->
    </div>
    <!--xdcs-content end-->

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

</html>