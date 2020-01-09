<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
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
      float: left;
    }
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
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
    .prdSort {
      width: 180px;
      max-height: 215px;
      /*border: 1px solid rgb(100, 61, 113);*/
      display: inline-block;
      vertical-align: top;
      margin: 5px;
      padding: 10px;
    }
    .prdSort2 {
      width: 180px;
      max-height: 215px;
      border: 1px solid rgb(100, 61, 113);
      display: inline-block;
      vertical-align: top;
      margin: 5px;
      padding: 10px;
    }
  </style>
<?
  $pictwidth=800;
  $pictheight=600;
?>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
</head>
<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="/brands/data_AED" enctype="multipart/form-data" onsubmit="return check(this)">

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px"><?=$lang['BrandSetting']?></legend>
        <table id="member_list" class="table table-bordered table-condensed">
          <tr>
            <td class='member_list_title_td'><?=$lang['BrandName']?></td>
            <td class='member_list_input_td'>
              <input type="text" class="form-control" name="d_name" value='<?=$dbdata['d_name']?>'/>
            </td>
          </tr>
            
          <tr>
            <td class='member_list_title_td'><?=$lang['BrandStatus']?></td>
            <td class="member_list_input_td">
              <select name='d_enable'  style="width: 66%;">
                <option><?=$lang['ChooseStatusPlease']?></option>
                <option value='Y' <?=($dbdata['d_enable']=='Y')?'selected':'';?>><?=$lang['Sell']?></option>
                <!--<option value='1' <?=($dbdata['prd_active']==1)?'selected':'';?>>商品補貨</option>-->
                <option value='N' <?=($dbdata['d_enable']=='N')?'selected':'';?>><?=$lang['Remove']?></option>
              </select>
            </td>
          </tr>
          <tr>
                <td class='member_list_title_td'><?=$lang['BrandStory']?></td>
                <td class='member_list_input_td'>
                  <textarea name='prd_content' id=''><?=$dbdata['brand_content']?></textarea>
                </td>
          </tr>
          <tr>
            <td class='member_list_title_td'><?=$lang['BrandThumbnail']?></td>
            <td class='member_list_input_td'>
            <span style="color: red;"><?=$lang['ImageLimit']?><br><?=$lang['ImageTypeLimit']?></span>
              <input type="file" name="brand_image_s[]" multiple="multiple" id="imgInpS"/>
              <div id="fileList3"></div>
              <br><?=$lang['OriginImage']?>:<br>
              <div id="sortS">
              <? if($dbdata['brand_image_s']!=''){
                    $image=explode(',',$dbdata['brand_image_s']);
                    foreach($image as $val_img){?>
                      <div class="prdSort">
                        <img class="prdSort2" id="blah-s" src="<?=$this->Spath_s;?><?=$val_img?>" style="max-width: 175px;"/>
                        <input type="hidden" name="ck_id_s[]" value="<?=$val_img;?>">
                      </div>
                  <?}
              }?>
              </div>
              <input type='hidden' name='brand_image_hide_s' value='<?=$dbdata['brand_image_s']?>'>
            </td>
          </tr>
          <tr>
            <td class='member_list_title_td'><?=$lang['BrandImage']?></td>
            <td class='member_list_input_td'>
              <span style="color: red;"><?=$lang['ImageLimit']?><br><?=$lang['ImageTypeLimit']?></span>
              <input type="file" name="brand_image[]" multiple="multiple" id="imgInp"/>
              <div id="fileList2"></div>
              <br><?=$lang['OriginImage']?>:<br>
              <div id="sort">
              <? if($dbdata['brand_image']!=''){
                    $image=explode(',',$dbdata['brand_image']);
                    foreach($image as $val_img){?>
                      <div class="prdSort">
                        <img class="prdSort2" id="blah" src="<?=$this->Spath;?><?=$val_img?>" style="max-width: 175px;"/>
                        <input type="hidden" name="ck_id[]" value="<?=$val_img;?>">
                      </div>
                  <?}
              }?>
              </div>
              <input type='hidden' name='brand_image_hide' value='<?=$dbdata['brand_image']?>'>
            </td>
          </tr>

          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="prd_cid" value="<?=$dbdata['prd_cid']?>">
              <input type="hidden" name="dbname" value="<?=$dbname?>">
              <input type="hidden" name="lang_type" value="<?=$_SESSION['lang']?>">
              <input class="btn btn-default" type="button" style="width: 100px;font-size: 18px;" value='<?=$lang['GoBackList']?>' onclick="top.frames['content-frame'].location='/brands/product_brand_list'">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='<?=$lang['Save']?>'>
            </td>
          </tr>

        </table>

    </fieldset>
  </div>

</form>
<script type="text/javascript" src="/js/admin/system_center/build_ckeditor.js"></script>
<script src="/js/myjava/product.js"></script>
<script type="text/javascript" src="/js/imgareaselect/jquery.imgareaselect.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/js/imgareaselect/imgareaselect-animated.css" />

<p style="height:200px;"></p>

</body>
</html>
<script>
// function check(frm)
// {
//   if(frm.elements['restrice_num'].value!='0'){
//     if(frm.elements['prd_lock_amount'].value>frm.elements['restrice_num'].value){
//       alert('單次購買數量不得大於限購數量');
//       return false;
//   }
//   }else
//     return true;
// }
 function check(frm)
 {
    if(frm.elements['d_name'].value==''){
      alert('名稱不能空白');
      return false;
    }
 }

$(document).on('change', '#prd_cid', function(){
  var prd_cid = $('#prd_cid :selected').val();//注意:selected前面有個空格！
  var prd_sub_cid = '<?=$dbdata['prd_sub_cid']?>';
    $.ajax({
        url:"/products/ajax_product",
        method:"POST",
        data:{
           prd_cid:prd_cid,
           prd_sub_cid:prd_sub_cid
        },
        success:function(data){
          $('#p_sub_cid').html(data);
        }
     });//end ajax
});

$(function(){
  $('#sort').sortable();
  var imagesPreview = function(input, placeToInsertImagePreview,filename) {
    if (input.files) {
      for (i = 0; (i < 10 && i<input.files.length); i++) {
        loadallFileReader(input,placeToInsertImagePreview,filename,i);
      }
    }
  }
  function loadallFileReader(input,placeToInsertImagePreview,filename,i) {
  //  filenamei=filename+''+i;不可以...因為非同步問題
    reader = new FileReader();
    reader.onload = function(event) {
      $(placeToInsertImagePreview).append('<img id="photo'+filename+''+i+'" src="'+event.target.result+'"><br>');
    }
    reader.onloadend = function(event) {
      if (filename=='d_Files'){
        $img=$('#photo'+filename+''+i);
        if ($img.prop("naturalWidth")><?php echo $pictwidth?>){
          setwidth=<?php echo $pictwidth?>;
        }else{
          setwidth=$img.prop("naturalWidth");
        }
        if ($img.prop("naturalHeight")><?php echo $pictheight?>){
          //sethight=<?php echo $pictheight?>;
          sethight=(setwidth*3)/4;
        }else{
          sethight=(setwidth*3)/4;
        }
        outstr='<input type="hidden" name="x1'+filename+''+i+'" value="0" />';
        outstr+='<input type="hidden" name="y1'+filename+''+i+'" value="0" />';
        outstr+='<input type="hidden" name="x2'+filename+''+i+'" value="'+setwidth+'" />';
        outstr+='<input type="hidden" name="y2'+filename+''+i+'" value="'+sethight+'" />';
        outstr+='<input type="hidden" name="width'+filename+''+i+'" value="'+setwidth+'" />';
        outstr+='<input type="hidden" name="height'+filename+''+i+'" value="'+sethight+'" />';
        $(placeToInsertImagePreview).append(outstr);
        $('#photo'+filename+''+i).imgAreaSelect({aspectRatio: '4:3',x1:0,y1:0,x2:setwidth,y2:sethight,width:setwidth,height:sethight,minWidth:80,maxWidth: <?php echo $pictwidth?>,handles: true,
        onSelectChange: d_Filespreview });
      }
    }
    reader.readAsDataURL(input.files[i]);
  }

  function movelog(filename,img,selection) {
    if (!selection.width || !selection.height)
      return;
    id=img.id;
    i=id.substring(('phpto'+filename).length);//phpto d_Files...
    filenamei=filename+''+i;
    $("[name=x1"+filenamei+"]").val(selection.x1);
    $("[name=y1"+filenamei+"]").val(selection.y1);
    $("[name=x2"+filenamei+"]").val(selection.x2);
    $("[name=y2"+filenamei+"]").val(selection.y2);
    $("[name=width"+filenamei+"]").val(selection.width);
    $("[name=height"+filenamei+"]").val(selection.height);
  }
  function d_Filespreview(img, selection) {
    filename='d_Files';
    movelog(filename,img, selection);
  }
  $('#imgInp').on('change', function() {
    $("div#fileList2").empty();
    imagesPreview(this, 'div#fileList2','d_Files');
  });
  $('#imgInpS').on('change', function() {
    $("div#fileList3").empty();
    imagesPreview(this, 'div#fileList3','d_Files');
  });


});
</script>
