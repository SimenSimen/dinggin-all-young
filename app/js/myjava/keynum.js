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
//浮點數相加
function FloatAdd(arg1, arg2)
{
  var r1, r2, m;
  try { r1 = arg1.toString().split(".")[1].length; } catch (e) { r1 = 0; }
  try { r2 = arg2.toString().split(".")[1].length; } catch (e) { r2 = 0; }
  m = Math.pow(10, Math.max(r1, r2));
  return (FloatMul(arg1, m) + FloatMul(arg2, m)) / m;
}
//浮點數相減
function FloatSubtraction(arg1, arg2)
{
  var r1, r2, m, n;
  try { r1 = arg1.toString().split(".")[1].length } catch (e) { r1 = 0 }
  try { r2 = arg2.toString().split(".")[1].length } catch (e) { r2 = 0 }
  m = Math.pow(10, Math.max(r1, r2));
  n = (r1 >= r2) ? r1 : r2;
  return ((arg1 * m - arg2 * m) / m).toFixed(n);
}
//浮點數相乘
function FloatMul(arg1, arg2)
{
  var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
  try { m += s1.split(".")[1].length; } catch (e) { }
  try { m += s2.split(".")[1].length; } catch (e) { }
  return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}
//浮點數相除
function FloatDiv(arg1, arg2)
{
  var t1 = 0, t2 = 0, r1, r2;
  try { t1 = arg1.toString().split(".")[1].length } catch (e) { }
  try { t2 = arg2.toString().split(".")[1].length } catch (e) { }
  with (Math)
  {
    r1 = Number(arg1.toString().replace(".", ""))
    r2 = Number(arg2.toString().replace(".", ""))
    return (r1 / r2) * pow(10, t2 - t1);
  }
}
function chgMoneyBigInnerHtml(arg,addr){ //位置呼叫innerHTML
    abc=chgMoneyBigMoney(arg,addr);
}

function chgMoney2Big1(arg,addr){ //位置呼叫input
	var obj = document.getElementById(arg);
	var obj = document.getElementById(arg);
    var money1 = obj.value;
    abc=chgMoneyBigMoney(money1,addr);
}
function chgMoney2Big(arg,addr){ //位置呼叫input
    var retval="",retval1="",dec = "點";;
	var obj = document.getElementById(arg);
	if(obj.value!=""){
	    if(!isNaN(obj.value)){
	        var tt =obj.value.split(".");
	        if(tt.length<=2){
	            var  money1= (parseFloat(obj.value)).toFixed(0);
                var ar = money1.split(".");
                if(ar.length==2){
                    retval1 = dec + chgMoneyBigMoney(ar[1],addr);//如果有小數點,先處裡小數點
                }
                retval=chgMoneyBigMoney(ar[0],addr)+retval1;
            }
        }
    }
    document.getElementById(addr).innerHTML = retval;  
}
function chgMoneyBigMoney(num,addr){
    var char = new Array("零","一","二","三","四","五","六","七","八","九");
    var dw = new Array("","十","佰","仟","","萬","億","兆");
    var retval = "";
    var retval1="";
    var str=new Array();
    var out=new Array();
    if(num == 0){ 
        retval = '零';
    }
    else{
        if(num != ""){
            str=num.split("");
            str.reverse(); 
            for(i=0;i<str.length;i++){
                out[i] = char[str[i]];
                if(str[i]!="0"){
                    out[i] += dw[i%4];
                }
                if(parseInt(str[i]+str[i-1],10) == 0){
                    out[i] = "";
                }
                if((i%4) == 0){
                    out[i] += dw[4+Math.floor(i/4)];
                }
            }
            out.reverse();
            retval = out.join("")+retval1;
        }
        retval=retval.replace(new RegExp("億萬","g"),"億");
        retval=retval.replace(new RegExp("零萬","g"),"萬");
        retval=retval.replace(new RegExp("一十","g"),"十");
    }
    return retval;
}
function chgMoneyBigMoney1(money,addr){ //金額小寫轉成大寫
	var Big,Num,str
	str="";
	if(money!=""){
		if(!isNaN(money)){
			if(money.length<70){
				Big = new Array("元","十","佰","仟","萬","十","佰","仟","億","十","佰","仟","兆","十","佰","仟","京","十","佰","仟","垓","十","佰","仟","秭","十","佰","仟","穰","十","佰","仟","溝","十","佰","仟","澗","十","佰","仟","正","十","佰","仟","載","十","佰","仟","極","十","佰","仟","恆河沙","十","佰","仟","阿僧祇","十","佰","仟","那由他","十","佰","仟","不可思議","十","佰","仟","無量大數")
				Num = new Array("零","一","二","三","四","五","六","七","八","九")
				for(i=1;i<money.length+1;i++){
				    if(Num[money.substr(i-1,1)]!="零"){
				        if(Big[money.length-i]=="十"){
				            if(i==1){
				                if(Num[money.substr(i-1,1)]!="一"){
				                    str += Num[money.substr(i-1,1)];
				                }
				            }
				            else{
				                str += Num[money.substr(i-1,1)];
				            }
					    }
					    else{
					        str += Num[money.substr(i-1,1)];
					    }
					    
					    str += Big[money.length-i];
					}
					else{
					    if(Big[money.length-i]!="十" && Big[money.length-i]!="佰" && Big[money.length-i]!="仟"){
					        if(((money.length)>=69) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="無量大數"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=65) && ((money.length)<69) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="不可思議"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=61) && ((money.length)<65) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="那由他"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=57) && ((money.length)<61) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="阿僧祇"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=53) && ((money.length)<57) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="恆河沙"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=49) && ((money.length)<53) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="極"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=45) && ((money.length)<49) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="載"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=41) && ((money.length)<45) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="正"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=37) && ((money.length)<41) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="澗"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=33) && ((money.length)<37) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="溝"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=29) && ((money.length)<33) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="穰"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=25) && ((money.length)<29) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="秭"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=21) && ((money.length)<25) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="垓"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=17) && ((money.length)<21) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="京"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=13) && ((money.length)<17) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="兆"))){
					            str += Big[money.length-i];
					        }
					        else if(((money.length)>=9) && ((money.length)<13) && ((Big[money.length-i]=="元") | (Big[money.length-i]=="億"))){
					            str += Big[money.length-i];
					        }
					        else if((money.length)<=8){
					                str += Big[money.length-i];
					            
					        }
					    }
                    }
				}
			}else{
				str = "數目太大了";
			}
			document.getElementById(addr).innerHTML = str;
		}else{
			str = "請輸入數字!";
			document.getElementById(addr).innerHTML = str;
		}
	}
}