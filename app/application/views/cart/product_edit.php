<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$EditProduct?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--新增商品分類form-->
    <form action='/cart/product_edit' method='post' name='form_product_edit' id='form_product_edit' enctype="multipart/form-data">
      <h3 style="font-family: '微軟正黑體';"><?=$EditProduct?></h3>
        <table class='table product_add_table' id='product_add_table' style="width:90%;">
            
          <tr>
            <td class='table-cell-right'><?=$ProductStatus?></td>
            <td>
              <select name='cset_active' class='form-control' style="width: 66%;">
                <option><?=$ClickStatus?></option>
                <option value='0' <?=$prd_active_select[0]?>><?=$ThereStock?></option>
                <option value='1' <?=$prd_active_select[1]?>><?=$ProductReplenishment?></option>
                <option value='2' <?=$prd_active_select[2]?>><?=$OffShelf?></option>
              </select>
              <!-- <input type='button' class="btn btn-danger" id='del_product' value='刪除此商品'> -->
            </td>
          </tr>

          <tr>
            <td class='table-cell-right' style="width: 180px;"><span class='red_star'>*</span><?=$ProductContent?></td>
            <td class='table-cell-left'>
                <?php if (!empty($prd_c)): ?>

                  <select name='prd_cid' id='class_group' class='form-control required'>

                    <option value='-1'><?=$Select?></option>

                    <?php foreach ($prd_c as $key => $value): ?>
                      <option value='<?=$value['prd_cid']?>' <?=$prd_c_select[$value['prd_cid']]?>><?=$value['prd_cname']?></option>
                    <?php endforeach; ?>
                    
                    <option value='0' <?=$prd_c_select[0]?>><?=$NoClass?></option>

                  </select>
                  <p id='select_class_group'></p>

                <?php else: ?>

                  <?=$NotAnyClass?>

                <?php endif; ?>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ProductName?></td>
            <td class='table-cell-left'><input value='<?=$prd['prd_name']?>' type='text' class='form-control required' name='prd_name' id='prd_name' maxlength="255" placeholder='最多255個字'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ProductPicture?></td>
            <td class='table-cell-left'>
              <p><?=$PicSize_600?></p>
              <p><input type='file' class='form-control' name='prd_image' id='prd_image'></p>
              <p><img id="blah" src="<?=$img_url.$prd['prd_image']?>"/><input type='hidden' name='prd_image_hide' value='<?=$prd['prd_image']?>'></p>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$StorageCapacity?></td>
            <td class='table-cell-left'><input value="<?=$prd['prd_amount']?>" type='number' class='form-control required' min='1' max='99999999' name='prd_amount' id='prd_amount' maxlength="8"></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$SafetyStock?></td>
            <td class='table-cell-left'>
              <input value="<?=$prd['prd_safe_amount']?>" type='number' class='form-control required' min='1' max='99999999' name='prd_safe_amount' id='prd_safe_amount' maxlength="8">
              <div style='width:92%'><?=$LessNumEmail?></div>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$SinglePurchase?></td>
            <td class='table-cell-left'>
              <input value="<?=$prd['prd_lock_amount']?>" type='number' class='form-control required' min='1' max='99' name='prd_lock_amount' id='prd_lock_amount' placeholder='<?=$AllowNumber?>'>
            </td>
          </tr>

          <!-- <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>備用庫存</td>
            <td class='table-cell-left'>
              <input value="<?=$prd['prd_prepare_amount']?>" type='number' class='form-control required' min='1' max='99999999' name='prd_prepare_amount' id='prd_prepare_amount' maxlength="8"><br>
              <div style='width:92%'>當庫存等於0時，商品狀態將自動轉為「庫存不足」，訂購超量部分將由此扣除數量</div>
            </td>
          </tr> -->

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$SetPrice?></td>
            <td class='table-cell-left'><input value="<?=$prd['prd_price00']?>" type='number' class='form-control required' min='1' max='99999999' name='prd_price00' id='prd_price00' maxlength="8" placeholder='新臺幣'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$SuggestPrice?></td>
            <td class='table-cell-left'><input value="<?=$prd['prd_price01']?>" type='number' class='form-control' min='1' max='99999999' name='prd_price01' id='prd_price01' maxlength="8" placeholder='新臺幣'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$ProductContent?></td>
            <td class='table-cell-left'><textarea name='prd_content' id='prd_content'><?php if ($prd['prd_content'] != ''): ?><?=$prd['prd_content']?><?php endif; ?></textarea></td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$ProductFeature?><br>
              <button type="button" class="btn btn-default" id='add_prd_describe_col'><?=$New?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
              <table id='prd_describe_table'>
                <tbody id='prd_describe_table_tbody'>
                <?php if ($show_describe): ?>
                  <?php foreach ($prd_describe as $key => $value): ?>
                    <tr>
                      <td style="width: 441px;">
                        <input type='text' class='form-control' style="display:inline; width:71%;" name='prd_describe[]' id='prd_describe[]' value="<?=$value?>">
                        &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_describe_col' onclick='javascript:void(0);'>移除</button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
              </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$IntroductionMovie?><br>
              <button type="button" class="btn btn-default" id='add_prd_video_col'><?=$New?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
                <table id='prd_video_table' style="width: 100%;">
                  <tbody id='prd_video_table_tbody'>
                  <?php if ($show_video_link): ?>
                    <?php foreach ($prd_video_link as $key => $value): ?>
                      <tr>
                        <td>
                          <input type='text' placeholder='<?=$MovieTitle?>' value="<?=$prd_video_name[$key]?>" class='form-control' style='display:inline; width:26%;' name='prd_video_name[]' id='prd_video_name[]' maxlength='32'>
                          <input placeholder='<?=$MovieUrl?>' type='text' class='form-control' value="<?=$prd_video_link[$key]?>" style='display:inline; width:40%;' name='prd_video_link[]' id='prd_video_link[]' maxlength='255'>
                          &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$ProductSpecification?><br>
              <button type="button" class="btn btn-default" id='add_prd_specification_col'><?=$New?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
                <table id='prd_specification_table' style="width: 100%;">
                  <tbody id='prd_specification_table_tbody'>
                  <?php if ($show_specification): ?>
                    <?php foreach ($prd_specification_content as $key => $value): ?>
                      <tr>
                        <td>
                          <input type='text' placeholder='<?=$SpecificationsName?>' class='form-control' value="<?=$prd_specification_name[$key]?>" style='display:inline; width:26%;' name='prd_specification_name[]' id='prd_specification_name[]' maxlength='16'>
                          <input placeholder='<?=$SpecificationsContent?>' type='text' class='form-control' value="<?=$value?>" style='display:inline; width:40%;' name='prd_specification_content[]' id='prd_specification_content[]' maxlength='128'>
                          &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_specification_col' onclick='javascript:void(0);'>移除</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$WarrantyCoverage?></td>
            <td class='table-cell-left'><input value="<?=$prd['prd_assurance_range']?>" type='text' class='form-control' name='prd_assurance_range' id='prd_assurance_range' maxlength="16" placeholder='<?=$ProductMalfunction?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$WarrantyPeriod?></td>
            <td class='table-cell-left'><input value="<?=$prd['prd_assurance_date']?>" type='text' class='form-control' name='prd_assurance_date' id='prd_assurance_date' maxlength="16" placeholder='<?=$ExYear?>'></td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='hidden' name='prd_id' id='prd_id' value='<?=$prd['prd_id']?>'>
              <input type='submit' class='btn btn-default' name='form_submit' value='<?=$SaveEdit?>' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='<?=$Cancle?>'>
            </td>
          </tr>
        </table>
        <input type='hidden' name='success' id='success' value='<?=$success?>'>
      </form>
    <!--end 新增商品分類form-->
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">

  h3 { font-family: 'Microsoft Jhenghei'; }
  .btn { font-size: 16px; font-family: 'Microsoft Jhenghei'; }
  #product_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

  /*form*/
  .form-control { display: inline-block; width: 90%; }
  .red_star { color: red; }
  .table-cell-right { vertical-align: middle; text-align: center; font-size: 18px; }
  .table-cell-left { vertical-align: middle; text-align: left; }

  /*validate*/
  label.error { padding-left: 10px; font-size: 16px; color: red; font-family: '微軟正黑體'; }
  label.success { padding-left: 0px; }

</style>

<!--bottom script-->
<script type="text/javascript" src="/js/product_edit.js"></script>