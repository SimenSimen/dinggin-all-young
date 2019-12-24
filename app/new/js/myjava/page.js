
function changepage(Topage){

	$('#ToPage').val(Topage);
	$("#search_form").submit();
}
$(function() {
  //列表JS
	$('a[id="menu_list"]').click(function(){
		post_to_url('/admin_sys/'+$(this).attr("pagename"),'', {'del_search':'Y','headname':$(this).attr("pagename")});	
	});

  //LIST新增修改按鈕
  //list頁
  $('a[id="add_action"]').click(function(){
    post_to_url('/admin_sys/'+$('head').attr("id")+'/'+$('head').attr("id")+'_info','', {});
  });
  $("a[id='fix_action']").click(function(){
    post_to_url('/admin_sys/'+$('head').attr("id")+'/'+$('head').attr("id")+'_info','', {'d_id':$(this).attr("rel")});
  });
  $("a[id='del_action']").click(function(){
    if(confirm('確定刪除['+$(this).attr("fildname")+']資料?'))
      post_to_url('/admin_sys/'+$('head').attr("id")+'/'+'data_add_fix','', {'d_id':$(this).attr("rel"),'deltype':'Y'});
  });
})

//GET轉POST
function post_to_url(path,targets, params) {
  var form = document.createElement("form");
  form.setAttribute("method", "post");
  if(targets!=""){
  	form.setAttribute("target", targets);
  }
  form.setAttribute("action", path);
  form.setAttribute("name", "newForm");
  form.setAttribute("id", "newForm");
  //加入時間參數以免讀到舊資料
  	var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "parm");
    hiddenField.setAttribute("value", new Date().getTime());
    form.appendChild(hiddenField);
  for(var key in params) {        
    var hiddenField = document.createElement("input");        
    hiddenField.setAttribute("type", "hidden");        
    hiddenField.setAttribute("name", key);         
    hiddenField.setAttribute("value", params[key]);        
    form.appendChild(hiddenField);    
  }    
  document.body.appendChild(form);
  form.submit();
  work_mesg(true);//鎖定按鈕並顯示訊息
  document.body.removeChild(document.getElementById("newForm"));
}

//鎖定按鈕並顯示訊息
function work_mesg(disabled){
	//disabled=true;
	$("a").attr("disabled",disabled);
	$("input").attr("disabled",disabled);
	$("select").attr("disabled",disabled);
	$("textarea").attr("disabled",disabled);
    txts=(disabled==true)?"資料處理中，等待完成!":"";
	try{
		$("#mesg").html(txts);
	}
	catch(e){}
}