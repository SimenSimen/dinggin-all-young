/*
選單頁專用
*/
var gTimerID;
// function flushLoginSessions(){
// 	clearTimeout(gTimerID);
// 	//var url ="index.php?mainAction=manager&subAction=rear&subAction-1=flushLoginSession&parm="+new Date().getTime();
// 	//location.href=url;
// 	$.post("/admin_sys/index/rear/index",
//     	{
//         	ajax:"ajax",
//         	parm:new Date().getTime()
//         },
//        		function(data,status){
//         		if(status=="success"){
//         			//$("#flushLoginSessions_mesg").html(data);
// 				}
//         	}
//         );
// }
// function runtime(){
// 	flushLoginSessions();
// 	gTimerID=setTimeout("runtime()", 1000*180);// 3分鐘
// }
//初始化
$(function() {
	//runtime();
	$(".menu_title").click(function(){
		$(".menu_div > ul > li").hide();
		$(this).parents("ul").children("li").show();
		console.log($(this).html());
	});
	$("a[id='menu_list']").click(function(){
		post_to_url($(this).attr("d_url"),'', {'del_search':'Y','menu_type':$(this).attr("d_id")});		
	});
	$("#header_w").click(function(){
		post_to_url($(this).attr("d_url"),'', {});		
	});
	//查詢
	$("#search_action").click(function(){
		$("#do_type").val("_search");
		$("#search_form").submit();
	});
	//刪除
	$("#del_action").click(function(){
		if(confirm('是否刪除勾選資料')){
			$("#do_type").val("_del");
			$("#parm").val(new Date().getTime());
			$("#search_form").submit();
		}
	});
	//啟用//公開
	$("#open_action").click(function(){
		var txt="啟用";
		if($(this).attr("class")=="btn_open1" || $(this).attr("class")=="btn_open1_h"){
			var txt="公開";
		}
		else if($(this).attr("class")=="btn_open2" || $(this).attr("class")=="btn_open2_h"){
			var txt="加入";
		}
		if(confirm('是否'+txt+'勾選資料')){
			$("#do_type").val("_enable_Y");
			$("#parm").val(new Date().getTime());
			$("#search_form").submit();
		}
	});
	//停用//下架
	$("#close_action").click(function(){
		var txt="停用";
		if($(this).attr("class")=="btn_close1" || $(this).attr("class")=="btn_close1_h"){
			var txt="下架";
		}
		else if($(this).attr("class")=="btn_close2" || $(this).attr("class")=="btn_close2_h"){
			var txt="拒絕";
		}
		if(confirm('是否'+txt+'勾選資料')){
			$("#do_type").val("_enable_N");
			$("#parm").val(new Date().getTime());
			$("#search_form").submit();
		}
	});
	//排序
	$("#sort_action").click(function(){
		if(confirm('是否排序資料')){
		$("#do_type").val("_sort");
		$("#parm").val(new Date().getTime());
		$("#search_form").submit();
		}
	});
	$("#select_action").click(function(){//全選
		$("input[type='checkbox'][name='ids[]']").prop("checked",true);
	});
	$("#cancel_action").click(function(){//取消
		$("input[type='checkbox'][name='ids[]']").prop("checked",false);
	});
	//跳頁
	$("#FirstPage").click(function(){$("#ToPage").val("1");$("#search_form").submit();});//監控第一頁
	$("#PrevPage").click(function(){$("#ToPage").val(FloatSubtraction($("#ToPage").val(),1));$("#search_form").submit();});//監控上一頁
	$("#ToNowPage").change(function(){$("#ToPage").val($("#ToNowPage").val());$("#search_form").submit();});//監控指定頁
	$("#NextPage").click(function(){$("#ToPage").val(FloatAdd($("#ToPage").val(),1));$("#search_form").submit();});//監控下一頁
	$("#LastPage").click(function(){$("#ToPage").val($("#LastPage").attr("rel"));$("#search_form").submit();});//監控最後一頁
	//list頁
	$("#add_action").click(function(){
		post_to_url('/admin_sys/'+$("thead").attr("id")+'/'+$("thead").attr("id")+'_add/index','', {});
	});
	$("input[name='fix_action']").click(function(){
		post_to_url('/admin_sys/'+$("thead").attr("id")+'/'+$("thead").attr("id")+'_fix/index','', {'d_id':$(this).attr("rel")});
	});
	//add頁
	//新增
	$("#add_data_action").click(function(){
		//if(confirm('確定新增資料')){
			$("#parm").val(new Date().getTime());
			$("#add_fix_form").attr('action','/admin_sys/'+$("filed").attr("id")+'/'+$("filed").attr("id")+'_add/add_data')
			$("#add_fix_form").submit();
		//}
	});
	//fix頁
	//修改
	$("#fix_data_action").click(function(){
		//if(confirm('確定修改資料')){
			$("#parm").val(new Date().getTime());
			$("#add_fix_form").attr('action','/admin_sys/'+$("filed").attr("id")+'/'+$("filed").attr("id")+'_fix/fix_data')
			$("#add_fix_form").submit();
		//}
	});
	//回上頁
	$("#return_now_action").click(function(){
		post_to_url('/admin_sys/'+$("body").attr("id")+'/'+$("body").attr("id")+'_list/index','', {});
	});
});