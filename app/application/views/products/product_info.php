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
<form method="post" action="/<?=$DataName?>/data_AED" enctype="multipart/form-data" onsubmit="return check(this)">

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">商品資料</legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <? //if($dbdata['prd_id']!=''):?>
              <tr>
                <td class='member_list_title_td'>商品狀態</td>
                <td class="member_list_input_td">
                  <select name='prd_active'  style="width: 66%;">
                    <option>請選擇變更狀態</option>
                    <option value='1' <?=($dbdata['prd_active']==1)?'selected':'';?>>尚有庫存</option>
                    <!--<option value='1' <?=($dbdata['prd_active']==1)?'selected':'';?>>商品補貨</option>-->
                    <option value='2' <?=($dbdata['prd_active']==2)?'selected':'';?>>商品下架</option>
                  </select>
                </td>
              </tr>
            <? //endif;?>
            <tr>
              <? if (!$_SESSION['provider']) { ?>
                <td class='member_list_title_td'>商品供應商</td>
                <td class="member_list_input_td">
                  <select name='supplier_id'  style="width: 66%;">
                    <option>請選擇供應商</option>
                    <? foreach ($supplier as $value) {?>
                      <? if ($value['is_provider']) { ?>
                        <option value="<?=$value['id'];?>" <?=($dbdata['supplier_id']==$value['id'])?'selected':'';?> ><?=stripslashes($value['chinese_name']);?></option>
                      <? } ?>
                    <?}?>
                  </select>
                </td>
              <? } else {?>
                <input type="hidden" name="supplier_id" value="<?=$_SESSION['provider']['id']?>">
              <? } ?>
            </tr>
            <tr>
              <td class='member_list_title_td'>商品分類</td>
              <td class='member_list_input_td'>
                <select name="prd_cid" id="prd_cid">
                  <option value="0">請選擇</option>
                  <?foreach ($protype as $pvalue):?>
                    <option value="<?=$pvalue['prd_cid']?>" <?=($dbdata['prd_cid']==$pvalue['prd_cid'])?'selected':'';?>><?=stripslashes($pvalue['prd_cname'])?></option>
                  <? endforeach;?>
                </select>
                <div id='p_sub_cid'>
					       <?if (!empty($dbdata['prd_sub_cid'])){?>
        					<select name="prd_cid" id="prd_sub_cid">
        						<!--<option value="0">無子分類</option>-->
        						<?foreach ($protype_sub as $pvalue_sub):?>
        						<option value="<?=$pvalue_sub['prd_cid']?>" <?=($dbdata['prd_sub_cid']==$pvalue_sub['prd_cid'])?'selected':'';?>><?=stripslashes($pvalue_sub['prd_cname'])?></option>
        						<? endforeach;?>
        					</select>
                 <?}?>
                </div>
              </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>商品條碼</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="prd_sn" value='<?=$dbdata['prd_sn']?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>商品編號</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="prd_no" value='<?=$dbdata['prd_no']?>'/>
                </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>商品名稱</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" placeholder='最多255個字' name="prd_name" value="<?=stripslashes($dbdata['prd_name'])?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>商品圖片</td>
              <td class='member_list_input_td'>
               <span style="color: red;">請將圖片剪裁至800px*600px再進行上傳，滑鼠左鍵拖曳選擇要的範圍<br>僅允許 png, jpg, gif 檔上傳</span>
                <input type="file" name="prd_image[]" multiple="multiple" id="imgInp"/>
                <div id="fileList2"></div>
                <br>原始圖檔:<br>
                <div id="sort">
                <? if($dbdata['prd_image']!=''){
                      $image=explode(',',$dbdata['prd_image']);
                      foreach($image as $val_img){?>
                        <div class="prdSort">
                          <img class="prdSort2" id="blah" src="<?=$this->Spath;?><?=$val_img?>" style="max-width: 175px;"/>
                          <input type="hidden" name="ck_id[]" value="<?=$val_img;?>">
                        </div>
                    <?}
                }?>
                </div>
                <input type='hidden' name='prd_image_hide' value='<?=$dbdata['prd_image']?>'>
              </td>
            </tr>

            <tr>
              <td class='member_list_title_td'>庫存數量</td>
              <td class='member_list_input_td'>
                <input type="number" min="1" required class="form-control" name="prd_amount" value='<?=($dbdata['prd_amount']!="")?$dbdata['prd_amount']:"1";?>'/>
              </td>
            </tr>
            <? if (empty($_SESSION['provider'])) { ?>
              <tr>
                  <td class='member_list_title_td'>單次購買最大數量</td>
                  <td class='member_list_input_td'>
                    <input type="number" min="1" required class="form-control" placeholder='每筆訂單允許的數量(預設值 10)' name="prd_lock_amount" value='<?=($dbdata['prd_lock_amount']!="")?$dbdata['prd_lock_amount']:"10";?>'/>
                  </td>
              </tr>
            <? } ?>

            <? if (empty($_SESSION['provider'])) { ?>
              <tr>
                  <td class='member_list_title_td'>限購數量(0為非限購品)</td>
                  <td class='member_list_input_td'>
                    <input type="number" min="0" required class="form-control" name="restrice_num" value='<?=($dbdata['restrice_num']!="")?$dbdata['restrice_num']:"0";?>'/>
                  </td>
              </tr>
            <? } ?>
			<tr>
                <td class='member_list_title_td'>安全庫存量</td>
                <td class='member_list_input_td'>
                  <input type="number" min="1" required class="form-control" name="prd_safe_amount" value='<?=($dbdata['prd_safe_amount']!="")?$dbdata['prd_safe_amount']:"1";?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>建議售價</td>
                <td class='member_list_input_td'>
                  <input type="number"  min="0.01" step="0.01" required class="form-control" name="prd_price01" placeholder='新臺幣' value='<?=$dbdata['prd_price01']?>' required/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>設定售價</td>
                <td class='member_list_input_td'>
                  <input type="number" min="0.01" step="0.01" required class="form-control" placeholder='新臺幣' name="prd_price00" value='<?=$dbdata['prd_price00']?>' required/>
                </td>
            </tr>

            <? if (empty($_SESSION['provider'])) { ?>
              <tr>
                  <td class='member_list_title_td'>員工價</td>
                  <td class='member_list_input_td'>
                    <input type="number"  min="0.01" step="0.01" required class="form-control" name="d_mprice" placeholder='新臺幣' value='<?=$dbdata['d_mprice']?>' />
                  </td>
              </tr>
            <? } ?>

            <? if (empty($_SESSION['provider'])) { ?>
              <tr>
                  <td class='member_list_title_td'>PV值</td>
                  <td class='member_list_input_td'>
                    <input type="number" min="0" step="0.1" required class="form-control" name="prd_pv" value='<?=$dbdata['prd_pv']?>' />
                    台幣金額:<span id="bonus"><?=$bonus?></span>
                  </td>
              </tr>
            <? } ?>
			<tr>
                <td class='member_list_title_td'>成本</td>
                <td class='member_list_input_td'>
                  <input type="number" min="0" step="1" required class="form-control" name="prd_cost" value='<?=($dbdata['prd_cost']!='' )?$dbdata['prd_cost']:'';?>' />
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>產品說明</td>
                <td class='member_list_input_td'>
                  <textarea name='prd_content' id=''><?=$dbdata['prd_content']?></textarea>
                </td>
            </tr>

            <tr>
              <td class='member_list_title_td'>商品品牌</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="brand" value="<?=$dbdata['brand']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>生產國別</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="country" value="<?=$dbdata['country']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>預計售價 (含稅價)</td>
              <td class='member_list_input_td'>
                <input type="number" class="form-control" min="0" name="estimated_price" value="<?=$dbdata['estimated_price']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>市場售價 (含稅價)</td>
              <td class='member_list_input_td'>
                <input type="number" class="form-control" min="0" name="market_price" value="<?=$dbdata['market_price']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>進貨價格 (含稅價)</td>
              <td class='member_list_input_td'>
                <input type="number" class="form-control" min="0" name="purchase_price" value="<?=$dbdata['purchase_price']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>包裝尺寸 (cm)</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="size" value="<?=$dbdata['size']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>包裝重量 (克)</td>
              <td class='member_list_input_td'>
                <input type="number" class="form-control" min="0" name="weight" value="<?=$dbdata['weight']?>" required/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>產品質驗報告</td>
              <td class='member_list_input_td'>
                <input type="file" name="report[]" multiple="multiple" accept="application/pdf,image/jpg" />
                <input type="hidden" name="origin_report">
                <?=!empty($dbdata['report']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['report']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>產地證明</td>
              <td class='member_list_input_td'>
                <input type="file" name="proof[]" multiple="multiple" accept="application/pdf,image/jpg" />
                <input type="hidden" name="origin_proof" value="<?$dbdata['proof']?>">
                <?=!empty($dbdata['proof']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['proof']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>代理銷售合約</td>
              <td class='member_list_input_td'>
                <input type="file" name="contract[]" multiple="multiple" accept="application/pdf,image/jpg"/>
                <input type="hidden" name="origin_contract" value="<?$dbdata['contract']?>">
                <?=!empty($dbdata['contract']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['contract']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>產品責任險</td>
              <td class='member_list_input_td'>
                <input type="file" name="insurance[]" multiple="multiple" accept="application/pdf,image/jpg" />
                <input type="hidden" name="origin_insurance" value="<?$dbdata['insurance']?>">
                <?=!empty($dbdata['insurance']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['insurance']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>食品營養標示</td>
              <td class='member_list_input_td'>
                <input type="file" name="mark[]" multiple="multiple" accept="application/pdf,image/jpg"/>
                <input type="hidden" name="origin_mark" value="<?$dbdata['mark']?>">
                <?=!empty($dbdata['mark']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['mark']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>專利證明書</td>
              <td class='member_list_input_td'>
                <input type="file" name="patent[]" multiple="multiple" accept="application/pdf,image/jpg"/>
                <input type="hidden" name="origin_patent" value="<?$dbdata['patent']?>">
                <?=!empty($dbdata['patent']) ? '原始檔案：<br>' : ''?>
                <?foreach (explode(',', $dbdata['patent']) as $key => $value) {?>
                  <a href="<?=base_url().'images/providers/'.$value?>"><?=$value?></a><br>
                <?}?>
              </td>
            </tr>


            <tr>
                <td class='member_list_title_td'>商品特點<br><button type="button" class="btn btn-default" id='add_prd_describe_col'>增加</button></td>
                <td class='table-cell-left' style="vertical-align: top;">
                <table id='prd_describe_table'>
                  <tbody id='prd_describe_table_tbody'>
                  <?php //if ($show_describe): ?>
                    <?php foreach ($prd_describe as $key => $value): ?>
                      <tr>
                        <td style="width: 441px;">
                          <input type='text' class='form-control' style="display:inline; width:71%;" name='prd_describe[]' id='prd_describe[]' value="<?=$value?>">
                          <button type='button' class='btn btn-danger del_prd_describe_col' onclick='javascript:void(0);'>移除</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php //endif; ?>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>介紹影片<br><button type="button" class="btn btn-default" id='add_prd_video_col'>增加</button></td>
              <td class='table-cell-left' style="vertical-align: top;">
                  <table id='prd_video_table' style="width: 100%;">
                    <tbody id='prd_video_table_tbody'>
                    <?php //if ($show_video_link): ?>
                      <?php foreach ($prd_video_link as $key => $value): ?>
                        <tr>
                          <td>
                            <input type='text' placeholder='影片標題' value="<?=$prd_video_name[$key]?>" class='form-control' style='display:inline; width:26%;' name='prd_video_name[]' id='prd_video_name[]' maxlength='32'>
                            <input placeholder='影片網址' type='text' class='form-control' value="<?=$prd_video_link[$key]?>" style='display:inline; width:40%;' name='prd_video_link[]' id='prd_video_link[]' maxlength='255'>
                            <button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php //endif; ?>
                    </tbody>
                  </table>
              </td>
            </tr>
          <tr>
            <td class='member_list_title_td'>商品規格<br><button type="button" class="btn btn-default" id='add_prd_specification_col'>增加</button></td>
            <td class='table-cell-left' style="vertical-align: top;">
              <table id='prd_specification_table' style="width: 100%;">
                <tbody id='prd_specification_table_tbody'>
                  <?php //if ($show_specification): ?>
                    <?php foreach ($prd_specification_content as $key => $value): ?>
                      <tr>
                        <td>
                          <input type='text' placeholder='規格名稱' class='form-control' value="<?=$prd_specification_name[$key]?>" style='display:inline; width:26%;' name='prd_specification_name[]' id='prd_specification_name[]' maxlength='16'>
                          <input placeholder='規格內容' type='text' class='form-control' value="<?=$value?>" style='display:inline; width:40%;' name='prd_specification_content[]' id='prd_specification_content[]' maxlength='128'>
                          <button type='button' class='btn btn-danger del_prd_specification_col' onclick='javascript:void(0);'>移除</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php //endif; ?>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class='member_list_title_td'>保固範圍</td>
            <td class='member_list_input_td'>
              <input type="text" placeholder='例如：產品功能故障、新品瑕疵等' class="form-control" name="prd_assurance_range" value='<?=$dbdata['prd_assurance_range']?>'/>
            </td>
          </tr>
          <tr>
            <td class='member_list_title_td'>保固期限</td>
            <td class='member_list_input_td'>
              <input type="text"  placeholder='例如：一年' class="form-control" name="prd_assurance_date" value='<?=$dbdata['prd_assurance_date']?>'/>
             </td>
          </tr>

          <? if (empty($_SESSION['provider'])) { ?>
            <tr>
                  <td class='member_list_title_td'>是否為特殊商品</td>
                  <td class='member_list_input_td'>
                    <label class="form-radio">
                      <input type="radio" name="is_vip" value="Y" <? echo ($dbdata['is_vip']=='Y')?'checked':'';?> > 是
                    </label>
                    <label class="form-radio">
                      <input type="radio" name="is_vip" value="N" <? echo ($dbdata['is_vip']<>'Y')?'checked':'';?> > 否
                    </label>
                  </td>
            </tr>
          <? } ?>

          <? if (empty($_SESSION['provider'])) { ?>
            <tr>
                  <td class='member_list_title_td'>是否為紅利商品</td>
                  <td class='member_list_input_td'>
                    <label class="form-radio">
                      <input type="radio" name="is_bonus" value="Y" <? echo ($dbdata['is_bonus']=='Y')?'checked':'';?> > 是
                    </label>
                    <label class="form-radio">
                      <input type="radio" name="is_bonus" value="N" <? echo ($dbdata['is_bonus']<>'Y')?'checked':'';?> > 否
                    </label>
                  </td>
            </tr>
          <? } ?>

          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="d_id" value="<?=$dbdata['prd_id']?>">
              <input type="hidden" name="dbname" value="<?=$dbname?>">
              <input type="hidden" name="lang_type" value="<?=$_SESSION['lang']?>">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='儲存'>
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
    if(frm.elements['prd_name'].value==''){
      alert('名稱不能空白');
      return false;
    }
 }
$('input[name="prd_pv"]').blur(function(){
   kv=<?=$kv?>;
   pv=$(this).val();
   bonus=kv*pv;
   $('#bonus').html(Math.round(bonus));
});

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


});
</script>
