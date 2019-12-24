<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_EditSignUpForm?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/uform_add.css">

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/messages_<?=$lang?>.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script><!-- ckeditor -->
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function(){

      //取消按鈕關閉視窗
      $('#cancel').click(function(){
        if(confirm('<?=$SureCancleEdit?>'))
        {
          window.close();
        }
      });

      $('#prompt_tr').hide();

      <?php if ($ufm_col_name_number == 0): ?>
        //onchange column number
        $('#c_col_table').hide();
        $('#c_col_hr').hide();
      <?php endif; ?>

      if($('#success').val() == 1)
      {
        alert('<?=$EditFinal?>');
        opener.window.parent.location.reload(); 
        window.close();
      }

      //validate
      $('#form_uform_edit').validate({
          success: function(label) {
              label.addClass("success").text("");
          }
      });

      //sortable
      $('#col_table_tbody').sortable();

    });
  </script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>
    <form action='/business/uform_edit/<?=$uform['ufm_id']?>' method='post' name='form_uform_edit' id='form_uform_edit'>
    <h3 style="font-family: '微軟正黑體';"><?=$EditSignUpForm?></h3>
    <h5 style="font-family: '微軟正黑體';">※&nbsp;<?=$FillActivityEx?></h5>
      <table class='table' id='uform_table'>
        <tr>
          <td class='table-cell-right'><?=$ActivityName?></td>
          <td><input type='text' value='<?=$uform['ufm_name']?>' class='form-control required' style="display:inline;" name='ufm_name' maxlength="64"></td>
        </tr>
        <tr>
          <td class='table-cell-right'><?=$ClassType?></td>
          <td>
            <select name="ufm_cid" style="height: 34px; padding: 6px 12px; color: #555; border: 1px solid #ccc; font-size: 14px;">
              <option value="0"><?=$NoClass?></option>
            <?php foreach ($uform_category as $key => $value): ?>
              <option value="<?=$value['cid']?>" <?=$value['selection']?>><?=$value['name']?></option>
            <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'><?=$ActivityEx?></td>
          <td> </td>
        </tr>
        <tr>
          <td colspan="2" ><textarea class='' name="ufm_aim" id="ufm_aim" ><?=$uform['ufm_aim']?></textarea></td>
        </tr>


        <tr>
          <td class='table-cell-right'>
              <?=$ColumnPosition?><br>

              <select class='form-control' id='select_form_item' style="display:inline; width: 80px;">
                <option value='0'><?=$Add?></option>
                  <?php foreach ($form_item as $key => $value): ?>
                      <option value='<?=$key+1?>'><?=$value['item_name']?></option>
                  <?php endforeach; ?>
              </select>

          </td>
          <td class='table-cell-left'>
              <table id='h_col_table'>
                  <tr><td><?=$FixedFieldName?></td></tr>
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[0]?>' placeholder='<?=$RequiredName?>' class='form-control' style="display:inline;" name='ufm_col_0' id='ufm_col_name1' maxlength='32'></td></tr>
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[1]?>' placeholder='<?=$RequiredPhone?>' class='form-control' style="display:inline;" name='ufm_col_1' id='ufm_col_name2' maxlength='32'></td></tr>
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[2]?>' placeholder='<?=$RequiredEmail?>' class='form-control' style="display:inline;" name='ufm_col_2' id='ufm_col_name3' maxlength='32'></td></tr>
              </table>
              <table id='c_col_table'>
                <tr><td id='c_col_hr'><hr></td></tr>
                <tr>
                    <td><?=$CheckLeft?>&nbsp;<i class="fa fa-bars"></i>&nbsp;<?=$CanDragSequence?></td>
                </tr>
              </table>
              <table id='col_table'>
                <tbody id='col_table_tbody'>

                  <?php if (!empty($ufm_col_content)): ?>
                    <?php foreach ($ufm_col_content as $key => $value): ?>

                      <?php if ($value[0] == 1): ?>

                        <!--date-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="1">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$DateBirthday?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 2): ?>

                        <!--text-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="2">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$StrCampanyPhone?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 3): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="3">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$RadioVehicle?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                            <i class="fa fa-bars"></i><br>
                            <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="<?=$RadioMotorcycleTaxiCar?>" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                            <a href="#" class="why" tabindex = "-1">?</a>
                            <div class="prompt-box">
                              <p><?=$RadioScan?></p>
                              <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="<?=$Vehicle?>" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger"><?=$Remove?></button>&nbsp;<i class="fa fa-bars"></i></p>
                              <p><input class="form-control" type="text" readonly="true" value="<?=$VehicleValue?>" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                              <p><?=$AddBlank?></p>
                              <p><?=$NoSpaceAdd?></p>
                              <p><?=$NotAddField?></p>
                            </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 4): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="4">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$DropVehicle?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                            <i class="fa fa-bars"></i><br>
                            <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="<?=$DropMotorcycleTaxiCar?>" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                            <a href="#" class="why" tabindex = "-1">?</a>
                            <div class="prompt-box">
                              <p><?=$DropScan?></p>
                              <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="<?=$Vehicle?>" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger"><?=$Remove?></button>&nbsp;<i class="fa fa-bars"></i></p>
                              <p><input class="form-control" type="text" readonly="true" value="<?=$VehicleValue?>" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                              <p><?=$AddBlank?></p>
                              <p><?=$NoSpaceAdd?></p>
                              <p><?=$NotAddField?></p>
                            </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 5): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="5">
                          <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                          <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$CheckSpecialty?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                          <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                          <i class="fa fa-bars"></i><br>
                          <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="<?=$CheckWebUI?>" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                          <a href="#" class="why" tabindex = "-1">?</a>
                          <div class="prompt-box">
                            <p><?=$CheckScan?></p>
                            <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="<?=$Specialty?>" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger"><?=$Remove?></button>&nbsp;<i class="fa fa-bars"></i></p>
                            <p><input class="form-control" type="text" readonly="true" value="<?=$WebUIValue?>" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                            <p><?=$AddBlank?></p>
                            <p><?=$NoSpaceAdd?></p>
                            <p><?=$NotAddField?></p>
                          </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 6): ?>

                        <!--text-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="6">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="<?=$NumberPeopleNum?>" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);"><?=$Remove?></button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php endif; ?>

                    <?php endforeach; ?>
                  <?php endif; ?>

                </tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'><?=$FinishAction?></td>
          <td class='table-cell-left'><label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="1" <?php if($uform['ufm_mode'] == 1):?>checked<?php endif; ?> ><?=$PromptStr?></label>&nbsp;&nbsp;&nbsp;<label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="2" <?php if($uform['ufm_mode'] == 2):?>checked<?php endif; ?>><?=$DownloadApp?></label></td>
        </tr>
        <tr>
          <td class='table-cell-right'><?=$PromptStr?><br><a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$SetPromptStr?></div></td>
          <td class='table-cell-left'><textarea placeholder='<?=$SignUpFinish?>' class='form-control' name="ufm_msg" id="ufm_msg" style="width: 484px; resize: none;" rows="4"><?=$uform['ufm_msg']?></textarea></td>
        </tr>
        <tr id='prompt_tr'>
          <td class='table-cell-right'></td>
          <td style="color: #ff6600;"><?=$NotFilledField?></td>
        </tr>
        <tr>
          <td class='table-cell-center' colspan="2">
            <input type='submit' class='btn btn-default' name='form_submit' style="font-size: 18px;" value='<?=$SaveEdit?>'>
            <input type='button' class='btn btn-default' name='cancle' style="font-size: 18px;" id='cancel' value='<?=$Cancle?>'>
            <input type='hidden' name='ufm_id' id='ufm_id' value='<?=$uform['ufm_id']?>'>
            <input type='hidden' name='ufm_col_num' id='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
            <input type='hidden' name='success' id='success' value='<?=$success?>'>
          </td>
        </tr>
      </table>
    </form>
    <p style="height: 100px;"></p>
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">
</style>

<!--bottom script-->
<script type="text/javascript" src="/js/uform_edit.js"></script>
