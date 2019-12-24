  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


  <!-- bootstrap -->

  <style type="text/css">
    div.config-div {
      margin-top: 20px;
      margin-left: 40px;
    }
    div.config-div-img {
      margin-left: 68%;
    }
    div.config-div-encrypt {
      margin-left: 68%;
    }
    div.config-div fieldset {
      display: inline;
      margin-left: 40px;
      float: left;
    }
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
    }
    fieldset.config-border-img, fieldset.config-border-encrypt {
      width: 100px;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
              text-align: center;
              vertical-align: middle;
    }
    legend.config-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
      width: 130px;
    }
    .member_list_title_td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
      width:150px;
    }
    #member_list tr td
    {
      vertical-align: middle;
    }
    .member_list_input_td
    {
      width:180px;
    }
    input[type=text], .input_select
    {
      background-color: #FDFFE2;
      font-size: 16px;
      color: #000;
    }
    table{border-collapse:collapse!important}.table-bordered th,.table-bordered td{border:1px solid #ddd!important}}*,*:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:62.5%;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff}
    input,button,select,textarea{font-family:inherit;font-size:inherit;line-height:inherit}
    .btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da}.btn-info:hover,.btn-info:focus,.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{color:#fff;background-color:#39b3d7;border-color:#269abc}.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{background-image:none}.btn-info.disabled,.btn-info[disabled],fieldset[disabled] .btn-info,.btn-info.disabled:hover,.btn-info[disabled]:hover,fieldset[disabled] .btn-info:hover,.btn-info.disabled:focus,.btn-info[disabled]:focus,fieldset[disabled] .btn-info:focus,.btn-info.disabled:active,.btn-info[disabled]:active,fieldset[disabled] .btn-info:active,.btn-info.disabled.active,.btn-info[disabled].active,fieldset[disabled] .btn-info.active{background-color:#5bc0de;border-color:#46b8da}.btn-info .badge{color:#5bc0de;background-color:#fff}
    .btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:normal;line-height:1.428571429;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none}.btn:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}
  </style>
<script src="/js/myjava/jquery.ui.autocomplete.html.min.js"></script>
<link rel="stylesheet" href="/js/myjava/autocomplete.css">

<form method="post" action="/bonus/givebonus">
<input type="hidden" value="1" name="d_type"/>
  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">會員紅利轉出</legend>
		<p><?=$this->lang['subdivi'];//剩餘紅利?><span class="color01"><?=$dividend;?><?=$this->lang['pri'];//點?></span><?=$this->lang['divid'];//紅利點數?></p>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                <td class='member_list_title_td'>會員帳號</td>
                <td class='member_list_input_td'>
                  <? if($dbdata['d_id']!=''):
                      echo $dbdata['sName'].'['.$dbdata['account'].']';
                  else:?>
                    <input type="text" class="form-control" name="BID" id="d_member_name" required/>
                  <? endif;?>
                  <div id="suggesstion-box"></div>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>點數</td>
                <td class='member_list_input_td'>
                  <input type="number" min='0' value="<? echo $dbdata['d_bonus']?>" name="d_bonus" required/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>說明</td>
                <td class='member_list_input_td'>
                  <textarea name="d_content"><? echo $dbdata['d_content']?></textarea>
                </td>
            </tr>
          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="dbname" value="dividend_log">

              <input type="hidden" name="d_id" value="<?=$dbdata['d_id']?>">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='確定'>
            </td>
          </tr>       
        </table>
    </fieldset>

  </div>
 
</form>
			</div>
		</main>

<script >
$("#d_member_name").keyup(function(){
    if(($(this).val()).length>=2){
        $('#member-name').html('');
        $.ajax({
        type: "POST",
        url: "/bonus/GetBuyer",
        data:'keyword='+$(this).val(),
        success: function(data){

          $("#suggesstion-box").show();
          $("#suggesstion-box").html(data);
        }
        });
      }
  });
</script>