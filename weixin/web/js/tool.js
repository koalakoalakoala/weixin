$.extend({
    /**
     * 是否整数
     */
    isInt: function(s){
        return (/^-?\d+$/).test(s);
    },
    /**
     * 是否正整数 包括第一位是0
     */
    isPint: function(s){
        return (/^\d+$/).test(s);
    },
    
    /**
     * 是否正整数 1 . 2 . 3 ...
     */
    isRPint: function(s){
        return (/^[1-9]\d*$/).test(s);
    },

    /**
     * 是否大于零的整数
     */
    isGint: function(s){
        return (/^\d+$/).test(s) ? ((/^0+$/).test(s)? false : true) : false;
    },

    /**
     * 是否浮点数
     */
    isFloat: function(s){
        return (/^(-?\d+)(\.\d+)?$/).test(s);
    },

    /**
     * 是否非负浮点数
     */
    isPfloat: function(s){
        return (/^\d+(\.\d+)?$/).test(s);
    },

    /**
     * 数组查询
     */
    indexOf:function(arr,substr,start){
        var ta,rt,d='\\0';
        if(start!==null){
            ta=arr.slice(start);
            rt=start;
        }else{
            ta=arr;
            rt=0;
        }
        var str=d+ta.join(d)+d,t=str.indexOf(d+substr+d);
        if(t==-1){
            return -1;
        }
        rt += str.slice(0,t).replace(/[^\0]/g,'').length;
        return rt;
    },
    
    /**
     * 检查帐号或密码的合法性
     * 账号由4-12位英文字母、数字、下划线组成，且第一位不能是下划线
     */
    isUsername: function(s){
        return (/^[a-zA-Z0-9]+[a-zA-Z0-9_]{3,11}$/).test(s);
    },

    /**
     * 检查密码的合法性 4-12
     */
    isPassword: function(s){
        return (/^[^\u4e00-\u9fa5]{1,16}$/).test(s);
    },
    
    /**
     * 检查真实姓名
     */
    isRealName: function(s){
        return (/^[\u4e00-\u9fa5]{2,8}$/).test(s);
    },
    
    /**
     * 检查身份证
     */
    isIdCard: function(s){
        return (/^[0-9a-zA-Z]{18,18}$/).test(s);
    },
    
    /*
     * 检查email
     */
    isEmail: function(s){
        return (/^([A-Za-z0-9_])+@([A-Za-z0-9_-]+[.])+([A-Za-z]{2,3})$/).test(s);
    },

    /*
     * 检查mobile手机格式
     */
    isMobile: function(s){
        return (/^(13|14|15|18|17)[0-9]{9}$/).test(s);
    },
            
    /**
     * 检查日期的合法性
     * ins : input array
     * start: start index
     * msg: alter masseger if wrong
     * return array[时间戳, eg:1999-2-6 12:9:8, eg:1999-02-06 12:09:08]
     */
    isValidDate: function(ins, start, msg) {
        start = start || 0;
        for(var i=start; i<6; i++){
            if(!$.isPint(ins[i].value)){//判断是否整数
                alert(msg);
                ins[i].select();
                return false;
            }
        }
        var t = [parseInt(ins[start].value, 10), parseInt(ins[start + 1].value, 10)-1, parseInt(ins[start + 2].value, 10), parseInt(ins[start + 3].value, 10), parseInt(ins[start + 4].value, 10), 0];
        var fd = new Date(t[0], t[1], t[2], t[3], t[4], t[5]);
        if(fd.getFullYear() !== t[0] || fd.getMonth() !== t[1] || fd.getDate() !== t[2] || fd.getHours() !== t[3] || fd.getMinutes() !== t[4]){
            alert(msg);
            if(t[0]<1970){
                ins[start].select();//year
            }else if(t[1]>11){
                ins[start + 1].select();//mouth
            }else if(t[3]>23){
                ins[start + 3].select();//hour
            }else if(t[4]>59){
                ins[start + 4].select();//minute
            }else{
                ins[start + 2].select();//day
            }
            return false;
        }
        return [fd, t[0]+'-'+(t[1]+1)+'-'+t[2]+' '+t[3]+':'+t[4]+':0', ins[start].value+'-'+ins[start + 1].value+'-'+ins[start + 2].value+' '+ins[start + 3].value+':'+ins[start + 4].value+':00'];
    },
            
    /**
     *选择某个元素，并将光标定位到此元素上
     */
    selectEm : function(em){
        setTimeout(function(){em.focus();em.select();}, 0); //解决ie focus bug，使用延迟选择
    },
            
    /**
     * 验证传入的form元素的合法性，根据最后确定的边界值调整
     * 使用此方法，需要在元素里面加属性 valid, 另外请确定你的valid值在msgs和switch里面
     */
    validateEm: function(em){
        var type = $(em).attr('valid');
        var val = em.value;
        var re = true;
        var msgback = function(){
            var msg = {
                'name':     '名称由2-16位字符组成',
                'account':  '账号由4-12位英文字母、数字、下划线组成，且第一位不能是下划线',
                'password': '密码由6-16位字符组成',
                'epassword':'密码由6-16位字符组成',
                'amount':   '金额由不大于9位的正整数组成',
                'order':    '优先顺序由1-999的整数组成',
                'hour':     '小时为24时制小时格式',
                'minute':   '分钟为24时制分钟格式',
                'days':     '日期不正确！',
                'email':    '邮箱格式不正确',
                'mobile':   '手机格式不正确',
                'tel':   '电话格式不正确',
                'safe': '数据格式不正确',
                'select': '请选择分类',
                'tag':'标签由4-10位字母组成',
                'qq': 'QQ号码格式不正确',
                'uid': 'UID格式不正确',
                'url':'url格式不正确',
                'num':'不是数字',
                'idcard':"身份证号码不合法"
            };
            alert(msg[type]); 
            $.selectEm(em);
        };
        
        switch(type){
            case 'idcard':
                re = (/^[0-9a-zA-Z]{18,18}$/).test(val);
            break;
             case 'name':
                re = (/.{1,16}/).test(val);
            break;
            case 'account':
                re = (/^[a-zA-Z0-9]+[a-zA-Z0-9_]{3,11}$/).test(val);
            break;
            case 'password':
                re = (/^[^\u4e00-\u9fa5]{4,16}$/).test(val);
            break;
            case 'epassword':
                re = (/^[^\u4e00-\u9fa5]{4,16}$/).test(val);
            break;
            case 'amount':
                re = (/^[1-9]\d{0,8}$/).test(val);
            break;
            case 'order':
                re = (/^[1-9]\d{0,2}$/).test(val);
            case 'hour':
                var hour = parseInt(val,10);
                re = !(!(/^\d(\d)?$/).test(val) || hour > 23 || hour < 0);
            break;
            case 'minute':
                var minute = parseInt(val,10);
                re = !(!(/^\d(\d)?$/).test(val) || minute > 59 || minute < 0);
            break;
            case 'days':
                re = (0 < val && val <= ($.getDaysOfMon()));
            break;
            case 'email':
                re = (/^([A-Za-z0-9_])+@([A-Za-z0-9_-]+[.])+([A-Za-z]{2,3})$/).test(val);
            break;
            case 'mobile':
                re = (/^1[3|4|5|8|7][0-9]\d{8}$/).test(val);
            break;
            case 'tel':
                re = (/^(([0\+]\d{2,3}-)?(0\d{2,3})-?)?(\d{7,8})(-(\d{3,}))?$/).test(val);
            break;
            case 'safe':
                re = (/^[\w|\u4e00-\u9fa5]+$/).test(val);
            break;
            case 'select':
                re = (/\d/).test(val);
            break;
            case 'tag':
                re = (/[A-Z]{4,10}/).test(val);
            break;
            case 'qq':
                re = (/^[1-9]\d{4,11}$/).test(val);
            break;
            case 'uid':
                re = (/^068\d{8}$/).test(val);
            break;
            case 'url':
                re = (/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/).test(val);
            break;
            case 'num':
                re = (/^\d+$/).test(val);
            break;

            default:
            break;
        }
        if(!re){msgback();}
        return re;
    },
    
    /**
     * 验证一个form里面的元素，只验证带有valid属性的元素
     */
    validateForm: function(form){
        var ems = form.elements;
        for(var i = 0; i < ems.length; i++){
            if($(ems[i]).attr('valid') && !$.validateEm(ems[i])){
                return false;
            }
        }
        return true;
    }, 
    
    /**
     * 得到某月的天数,默认当前月
     */
    getDaysOfMon:function(date){
        var dt = '';
        if(date){
            dt = new Date(date); //得到当前时间
        }else{
            dt = new Date(); //得到当前时间
        }
        dt = new Date(dt.getFullYear(), dt.getMonth() + 1, 0); //得到本月最后一天
        return(dt.getDate()); // 本月最后一天即为本月的天数
    },
            
   /**
     * 文件上传函数
     */
    fileUpload: function(url, id) {
        $("#pop_up_pos").css("display","block");
        id = typeof(id) == 'undefined' ? 1 : id;
        $.ajaxFileUpload({
            url: url, //用于文件上传的服务器端请求地址
            secureuri: false, //一般设置为false
            fileElementId: 'repair_attached_file' + id, //文件上传空间的id属性  <input type="file" id="file" name="file" />
            dataType: 'json', //返回值类型 一般设置为json
            success: function(data, status){  //服务器成功响应处理函数
                $("#pop_up_pos").css("display","none");
                alert(data.msg);
                if (data.success == 1){
                    //增加
                    //显示图片
                    $("#file_imgshowli" + data.index).attr('src', ' ');
                    $("#file_imgshowli" + data.index).attr('src', data.imageurl);
                    $("#profileimage" + data.index).val(data.imagepath);
                }
            }
        });
        return false;
    },

});
