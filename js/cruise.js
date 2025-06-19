$(function(){
	var flg=true;
    $(".Father_tr .wishlist img").click(function(){
        if(flg){
            $(this).parents(".Father_tr").next().show();
            $(this).attr("src","/image/arrow-up.png");
            flg=false;
        }else{
            $(this).parents(".Father_tr").next().hide();
            $(this).attr("src","/image/arrow-down.png");
            flg=true;
        }
        
    });
    $(".Father_tr .TourName").click(function(){
        if(flg){
            $(this).parents(".Father_tr").next().show();
            $(this).parents(".Father_tr").find(".wishlist img").attr("src","/image/arrow-up.png");
            flg=false;
        }else{
            $(this).parents(".Father_tr").next().hide();
            $(this).parents(".Father_tr").find(".wishlist img").attr("src","/image/arrow-down.png");
            flg=true;
        }
    }); 
    $(".arrowup img").click(function(){
        $(this).parents(".Son_tr").hide();
        $(this).parents(".Son_tr").prev(".Father_tr").find(".wishlist img").attr("src","/image/arrow-down.png");
        flg=true;
    });
    var info=[];//存储选中的信息
    var info_id="";//复选框id
    var addtr="";//要添加到订单的字符串
    var price=[];//存储选中的线路的所有价格

    //选中复选框，添加相应的信息
    $(".wishlist input").click(function(){
        info_id=$(this).attr("id");
        if($(this).is(":checked")){
            info=$(this).parent().siblings();
            var date = new Date($(this).parent().parent().find(".arrivalDate").val());
            if(date.toDateString()=="Invalid Date"){
                $(this).parent().parent().find(".arrivalDate").css("border-color","red");
                return false;
            }
            $(this).parent().parent().find(".arrivalDate").css("border-color","#d1d1d1");
            addtr='<tr class="BgGreyBottom" id="checked_'+info_id+'"><td class="TourName">'+info[0].innerHTML+'</td><td>'+info[2].innerHTML+'</td><td class="Price"></td><td><span class="arrivedate">Arrive date:</span>'+date.toDateString()+'</td><td><a class="del" href="javascript:;">X</a><input type="hidden" value="'+info[0].innerHTML+','+info[2].innerHTML+','+date.toDateString()+'" name="tour_name[]" /></td></tr>';
            

            ////
            var flyElm = $("#gwc").clone().css('opacity','0.7');
            flyElm.css({
                'z-index': 9000,
                'display': 'block',
                'position': 'absolute',
                'top': $(this).offset().top +'px',
                'left': $(this).offset().left +'px',
                // 'width': $(this).width() +'px',
                'height': '50px'
            });

            var end_x=$('#excursions').offset().left;
            var end_y=$('#excursions').offset().top;
            

            $('body').append(flyElm);
                var move=function(){
                    flyElm.animate({
                                        left:end_x,
                                        top:end_y,
                                        width:50,
                                        height:50,
                                        },1000,
                                        function(){
                                            flyElm.remove();
                                    }); 

                }
                move();

            ////


            $("#excursions").after(addtr);
            var data=$(this).parent().parent().find(".dropdown").html();
            var reCat = /\$[0-9]+/gi;
            var arrMactches_price = data.match(reCat);
            // var reCat_people = /([0-9]\-[0-9])*([0-9])*(\+)*(\ )*(people)/gi;//匹配人数
            // var arrMactches_people = data.match(reCat_people);
            price[info_id]=arrMactches_price;
            total();
        }else{
            price[info_id]="";
            $("#checked_"+info_id).remove();
            total();
        }
    });
    //点击X删除信息，反选相应的复选框
    $(document).on("click",".del",function(){
        $(this).parents(".BgGreyBottom").remove();
        var id=$(this).parents(".BgGreyBottom").attr("id").split("_")[2];
        if($("#info_"+id).is(":checked")){$("#info_"+id).attr("checked",false)}
        price["info_"+id]="";    
        total();    
    });

    $(".people_sel").change(function(){
            total();
            $("#total_tr").show(); 
    });
});	
	
    //总价格计算
    function total(){
        var adult_num=$("select[name='adultsNumber']").val();
        var children_num=$("select[name='ChildrenNumber']").val();
        var people_num=parseInt(adult_num)+parseInt(children_num);
        var one_price;//获取各个路线的单价总和
        if(people_num<2){
            one_price=0;
        }else if(people_num==2){
            one_price=prices(0);//获取各个路线的2人单价总和
        }else if(2<people_num && people_num<6){
            one_price=prices(1);            
        }else if(5<people_num && people_num<10){
            one_price=prices(2);
        }else if(people_num>9){
            one_price=prices(3);
        }   
        if(adult_num==11 || children_num==11){
            $(".TotalPrice").html("$"+people_num*one_price+"+"); 
        }else{
            $(".TotalPrice").html("$"+people_num*one_price); 
        }
           
    }
    //返回各个路线的单价总和
    function prices(num){
        var p=0;
        for (var item in price) {
            if(price[item]!=""){
                if(price[item].length>1){
                   p+= parseInt(price[item][num].split("$")[1]);
                }else{
                   p+= parseInt(price[item][0].split("$")[1]); 
                };
            }   
        };
        return p;
    }
    //页面滑动到锚点
    function Scroll(id){
        var mao = $("#"+id); //获得锚点   
        if (mao.length > 0) {//判断对象是否存在   
             var pos = mao.offset().top;  
             var poshigh = mao.height();  
             $("html,body").animate({ scrollTop: pos-poshigh }, 1000);  
        }
    }
    // function to_top(){
    //     $("html,body").animate({ scrollTop: 0 }, 1000);
    // }
    // //滚动监听
    // $(window).scroll(function(){
    //     var top=$(document).scrollTop();   
    //     var top_controller_div=$("#top_controller");     
    //     if(top==0){
    //         top_controller_div.hide();
    //     }else{
    //         top_controller_div.show(); 
    //     }
    // });
    // $(function(){ 
    //     var top_div = $("<div id='top_controller' onclick=\"to_top();\">").css('opacity','1');
    //         top_div.css({                
    //             'height': '50px',
    //             'position':'fixed',
    //             'width':'50px',
    //             'height':'50px',
    //             'z-index':9999,
    //             'right':'0%',
    //             'bottom':'50px',
    //             'display':'none',
    //             'background':'url(/image/to-top.png)',
    //             'cursor':'pointer'
    //         });
    //    $('body').append(top_div);     
    //    var top_controller_div=$("#top_controller");      
    //    var top=$(document).scrollTop(); 
    //    $("#total_tr").hide();
    //    if(top==0){
    //         top_controller_div.hide();
    //     }else{
    //         top_controller_div.show(); 
    //     }
    // });