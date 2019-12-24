<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_NewProduct?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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
    <form action='/cart/product_add' method='post' name='form_product_add' id='form_product_add' enctype="multipart/form-data">
      <h3 style="font-family: '微軟正黑體';"><?=$NewProduct?></h3>
        <table class='table product_add_table' id='product_add_table' style="width:90%;">

          <tr>
            <td class='table-cell-right' style="width: 180px;"><span class='red_star'>*</span><?=$Categories?></td>
            <td class='table-cell-left'>
                <?php if (!empty($prd_c)): ?>

                  <select name='prd_cid' id='class_group' class='form-control required'>

                    <option value='0'><?=$Select?></option>

                    <?php foreach ($prd_c as $key => $value): ?>
                      <option value='<?=$value['prd_cid']?>'><?=$value['prd_cname']?></option>
                    <?php endforeach; ?>

                  </select>
                  <p id='select_class_group'></p>

                <?php else: ?>

                  <?=$GoodsWillNotAdded?>

                <?php endif; ?>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ProductName?></td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='prd_name' id='prd_name' maxlength="255" placeholder='<?=$Must225Char?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ProductPicture?></td>
            <td class='table-cell-left'>
              <p><?=$Picture600?></p>
              <p><input type='file' class='form-control required' name='prd_image' id='prd_image'></p>
              <p><img id="blah" src="#"/></p>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$StorageCapacity?></td>
            <td class='table-cell-left'><input type='number' class='form-control required' min='1' max='99999999' value='1' name='prd_amount' id='prd_amount' maxlength="8"></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$SafetyStock?></td>
            <td class='table-cell-left'>
              <input type='number' class='form-control required' min='1' max='99999999' value='1' name='prd_safe_amount' id='prd_safe_amount' maxlength="8">
              <div style='width:92%'><?=$StockEmailNotice?></div>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$OneBuyQuantity?></td>
            <td class='table-cell-left'>
              <input type='number' class='form-control required' min='1' max='99' name='prd_lock_amount' id='prd_lock_amount' value="10" placeholder='每筆訂單允許的數量(預設值 10)'>
            </td>
          </tr>

          <!-- <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>備用庫存</td>
            <td class='table-cell-left'>
              <input type='number' class='form-control required' min='1' max='99999999' value='1' name='prd_prepare_amount' id='prd_prepare_amount' maxlength="8"><br>
              <div style='width:92%'>當庫存等於0時，商品狀態將自動轉為「庫存不足」，訂購超量部分將由此扣除數量(beta)</div>
            </td>
          </tr> -->

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$SetSell?></td>
            <td class='table-cell-left'><input type='number' class='form-control required' min='1' max='99999999' name='prd_price00' id='prd_price00' maxlength="8" placeholder='<?=$TaiwanDollar?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$SuggestedRetailPrice?></td>
            <td class='table-cell-left'><input type='number' class='form-control' min='1' max='99999999' name='prd_price01' id='prd_price01' maxlength="8" placeholder='<?=$TaiwanDollar?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$ProductInfo?></td>
            <td class='table-cell-left'><textarea name='prd_content' id='prd_content'></textarea></td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$ProductFeatures?><br>
              <button type="button" class="btn btn-default" id='add_prd_describe_col'><?=$Increase?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
            <p id='prd_describe_prompt_p' style="color: #ff6600;"><?=$NoFillInFields?></p>
              <table id='prd_describe_table'>
                <tbody id='prd_describe_table_tbody'>
                </tbody>
              </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$Introductory_video?><br>
              <button type="button" class="btn btn-default" id='add_prd_video_col'><?=$Increase?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
            <p id='prd_video_prompt_p' style="color: #ff6600;"><?=$NoFillInFields?></p>
                <table id='prd_video_table' style="width: 100%;">
                  <tbody id='prd_video_table_tbody'>
                  </tbody>
                </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'>
              <?=$ProductSpecifications?><br>
              <button type="button" class="btn btn-default" id='add_prd_specification_col'><?=$Increase?></button>
            </td>
            <td class='table-cell-left' style="vertical-align: top;">
            <p id='prd_specification_prompt_p' style="color: #ff6600;"><?=$NoFillInFields?></p>
                <table id='prd_specification_table' style="width: 100%;">
                  <tbody id='prd_specification_table_tbody'>
                  </tbody>
                </table>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$WarrantyCoverage?></td>
            <td class='table-cell-left'><input type='text' class='form-control' name='prd_assurance_range' id='prd_assurance_range' maxlength="16" placeholder='<?=$ExampleProductMalfunction?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$WarrantyPeriod?></td>
            <td class='table-cell-left'><input type='text' class='form-control' name='prd_assurance_date' id='prd_assurance_date' maxlength="16" placeholder='<?=$ExampleOneYear?>'></td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <!-- <input class="myButton" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='開始上傳'> -->
              <input type='submit' class='btn btn-default' name='form_submit' value='<?=$Added?>' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='<?=$Cancel?>'>
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
<script type="text/javascript" src="/js/product_add.js"></script>