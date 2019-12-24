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
  document.body.removeChild(document.getElementById("newForm"));
}

//input 只限輸入數字
function ValidateNumber(e, pnumber)
{
    if (!/^\d+$/.test(pnumber))
    {
        $(e).val(/^\d+/.exec($(e).val()));
    }
    return false;
}
// onkeyup="return ValidateNumber($(this),value)"