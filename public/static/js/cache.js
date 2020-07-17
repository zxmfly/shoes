var cacheStr = window.sessionStorage.getItem("cache");
layui.use(['form','jquery',"layer"],function() {
    var form = layui.form,
        $ = layui.jquery,
        layer = parent.layer === undefined ? layui.layer : top.layer;

    function checkNotice(){
        var f;
        $.ajax({
            type: "get",
            url: '/index.php/notice/getNotice?action=checkNotice',
            async: false, //设为false就是同步请求
            cache: false,
            success: function (res) {
                if(res.code > 0){
                    f = 1;
                }else{
                    f = 0;
                }
            }
        });

        return f;
    }

    //判断是否处于锁屏状态【如果关闭以后则未关闭浏览器之前不再显示】
    if(window.sessionStorage.getItem("lockcms") != "true" && window.sessionStorage.getItem("showNotice") != "true"){
        if(checkNotice()) {
            showNotice();
        }
    }

    //公告层
    function showNotice(){
        layer.open({
            type: 2,
            title: "系统公告",
            area: ['360px', '301px'],
            btn: ['收到'],
            moveType: 1,
            shade: 0.8,
            content: '/index.php/notice/getNotice',
            success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.css('position', 'absolute');
                btn.css('top', '240px');
                btn.css('left', '120px');
                btn.on("click",function(){
                    tipsShow();
                });
            },
            cancel: function(index, layero){
                tipsShow();
            }
        });
    }
    function tipsShow(){
        window.sessionStorage.setItem("showNotice","true");
        if($(window).width() > 432){  //如果页面宽度不足以显示顶部“系统公告”按钮，则不提示
            layer.tips('系统公告躲在了这里', '#userInfo', {
                tips: 3,
                time : 1000
            });
        }
    }
    $(".showNotice").on("click",function(){
         if(!checkNotice()){
             layer.msg("暂无公告!",{time:1000});
             return false;
         }
        showNotice();
    })

    //锁屏
    function lockPage(){
        if($('#is_lock_screen').text() != 'lock'){
            layer.msg("请先设置锁屏密码，再来锁屏吧！",{time:1000});
            return false;
        }

        var name = $('.adminName').text();
        layer.open({
            title : false,
            type : 1,
            content : '<div class="admin-header-lock" id="lock-box">'+
                            '<div class="admin-header-lock-name" id="lockUserName">'+name+'</div>'+
                            '<div class="input_btn">'+
                                '<input type="password" class="admin-header-lock-input layui-input" autocomplete="off" placeholder="请输入密码解锁.." name="lockPwd" id="lockPwd" />'+
                                '<button class="layui-btn" id="unlock">解锁</button>'+
                            '</div>'+
                        '</div>',
            closeBtn : 0,
            shade : 0.9
        })
        $(".admin-header-lock-input").focus();

    }
    $(".lockcms").on("click",function(){
        window.sessionStorage.setItem("lockcms",true);
        lockPage();
    })
    // 判断是否显示锁屏
    if(window.sessionStorage.getItem("lockcms") == "true"){
        lockPage();
    }
    // 解锁
    $("body").on("click","#unlock",function(){
        var pwd = $(this).siblings(".admin-header-lock-input").val();
        if(pwd == ''){
            layer.msg("请输入解锁密码！");
            $(this).siblings(".admin-header-lock-input").focus();
        }else{
            $.get('/index.php/worker/unlock',{
                pwd : pwd
            },function(res){
                if(isRealNum(res.code)) {
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1000});
                        $(this).siblings(".admin-header-lock-input").val('').focus();
                    } else {
                        window.sessionStorage.setItem("lockcms", false);
                        $(this).siblings(".admin-header-lock-input").val('');
                        layer.closeAll("page");
                    }
                }else{
                    layer.msg('登录超时，请重新登录', {time: 1000});
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }
            })
        }
    });
    $(document).on('keydown', function(event) {
        var event = event || window.event;
        if(event.keyCode == 13) {
            $("#unlock").click();
        }
    });

    //退出
    $(".signOut").click(function(){
        window.sessionStorage.removeItem("menu");
        menu = [];
        window.sessionStorage.removeItem("curmenu");
    })

    function isRealNum(val){
        // 先判定是否为number
        if(typeof val !== 'number'){
            return false;
        }
        if(!isNaN(val)){
            return true;
        }else{
            return false;
        }
    }
})