 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }
    .btn
    {
      font-size: 18px;
    }
    #button_table
    {
      width:80%;
      margin-top: 10px;
    }
    #button_table tr td
    {
      padding-top:5px;
      padding-bottom: 5px;
      padding-left: 5px;
    }
    #member_list tr td
    {
      padding: 5px;
    }
    #member_list_title_tr td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
    }
    .white_td
    {
      color: <?=$web_config['admin_font_color']?>;
    }
    .center_td
    {
      text-align: center;
    }
    #password_title_td
    {
      cursor: pointer;
      color: #F99;
    }
    .checkbox_td
    {
      zoom: 150%;
      text-align: center;
      vertical-align: middle;
    }
    .mycheckbox
    {
      cursor: pointer;
    }
    .info_prompt
    {
      text-align: right;
      color: #F60;
      font-size: 14px;
    }
  </style>

</head>
<script src='/js/myjava/allcheck.js'></script>
<center>
    <?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:1%;">
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info'">
          <?=$lang['AddClass']?>
        </button>
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/products_theme_sort'">
          <?=$lang['SortClass']?>
        </button>
      </td>
    </tr>

  </table>

  <!-- 搜尋 -->
  <table >
    <tr>
      <td>
        <input type="text" name="prd_cname" placeholder="<?=$lang['InputClassNamePlease']?>">
        <select name="d_enable" >
          <option value="" <?=($d_enable=='')?'selected':'';?>><?=$lang['ChooseStatusPlease']?>...</option>
          <option value="Y" <?=($d_enable=='Y')?'selected':'';?>><?=$lang['Show']?></option>
          <option value="N" <?=($d_enable=='N')?'selected':'';?>><?=$lang['Hide']?></option>
        </select>
        <input type="submit" value="<?=$lang['Search']?>" id="search_action" style=" font-size:14px;">
      </td>
    </tr>
  </table>

  <!--商品類別列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
      
    <tr id='member_list_title_tr'>
      <td><?=$lang['ClassName']?></td>
      <td><?=$lang['SnapUp']?></td>
      <td><?=$lang['SetSnapUp']?></td>
      <td><?=$lang['Modify']?></td>
      <td><?=$lang['Copy']?></td>
      <td><?=$lang['Delete']?></td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?=$lang['SnapUpEdit']?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?=$lang['StartTime']?><input type="datetime-local" id="start_at"><br>
              <?=$lang['EndTime']?><input type="datetime-local" id="end_at">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['Cancel']?></button>
              <button type="button" class="btn btn-primary" onclick="enable()"><?=$lang['Confirm']?></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal2" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?=$lang['SnapUpEdit']?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?=$lang['StartTime']?><input type="datetime-local" id="start_at_2"><br>
              <?=$lang['EndTime']?><input type="datetime-local" id="end_at_2">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lang['Cancel']?></button>
              <button type="button" class="btn btn-primary" onclick="edit()"><?=$lang['Confirm']?></button>
            </div>
          </div>
        </div>
      </div>


        <?php foreach ($dbdata as $key => $value): ?>
          <? $prd_cid=$value['prd_cid'];?>
          <tr style="font-weight:bold;">
            <td class='center_td white_td'>
              <i class="fa fa-folder"></i>
              <?=stripslashes($value['prd_cname'])?></td> 
              <td class="center_td white_id">
                <?=$value['is_hot'] ? $value['start_at'].' ~ '.$value['end_at'] : ''?>
              </td> 
              <td class='center_td white_td'> 
              <?if ($value['is_hot'] == 1) {?>
                <a href="javascript:void(0);" class="btn btn-default" onclick="cancel(<?=$prd_cid?>)"><?=$lang['Close']?></a>

                <a href="javascript:void(0);" class="btn btn-warning" data-toggle="modal"
                  data-target="#exampleModal2" 
                  onclick="setID(<?=$prd_cid?>);"
                >
                <?=$lang['Edit']?>
                </a>
              <?} else {?>
                <!-- Button trigger modal -->
                <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="setID(<?=$prd_cid?>)">
                  <?=$lang['Open']?>
                </a>
              <? } ?>
            </td>       
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value['prd_cid']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value['prd_cid']?>/Y'">
                <i class="fa fa-copy"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="del_file('<?=$value['prd_cname']?>','<?=$value['prd_cid']?>')">
                <i class="fa fa-trash-o"></i>
              </a>
            </td>
            
          </tr>
              <? foreach($data_sub[$prd_cid] as $key_second => $value_sub){  //第二層 ?>
              <tr style="color:#bd9595;">
                <td class='center_td white_td'>
                  <i class="fa fa-folder-open"></i>
                  <?=stripslashes($value_sub['prd_cname'])?></td>
                  <td class="center_td white_td">
                    <?=$value_sub['is_hot'] ? $value_sub['start_at'].' ~ '.$value_sub['end_at'] : ''?>
                  </td>
                  <td class='center_td white_td'> 
                <?if ($value_sub['is_hot'] == 1) {?>
                  <a href="javascript:void(0);" class="btn btn-default" onclick="cancel(<?=$value_sub['prd_cid']?>)">關閉</a>
                  

                  <a href="javascript:void(0);" class="btn btn-warning" data-toggle="modal" 
                    data-target="#exampleModal2" 
                    onclick="setID(<?=$value_sub['prd_cid']?>);"
                  >
                    <?=$lang['Edit']?>
                  </a>
                <?} else {?>
                  <!-- Button trigger modal -->
                  <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="setID(<?=$value_sub['prd_cid']?>)">
                    <?=$lang['Open']?>
                  </a>
                <? } ?>
            </td>
                <td class='center_td white_td'> 
                  <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value_sub['prd_cid']?>'">
                    <i class="fa fa-cogs"></i>
                  </a>
                </td>
                <td class='center_td white_td'> 
                  <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value_sub['prd_cid']?>/Y'">
                    <i class="fa fa-copy"></i>
                  </a>
                </td>
                <td class='center_td white_td'>
              <a href="javascript:void(0);" onclick="del_file('<?=$value_sub['prd_cname']?>','<?=$value_sub['prd_cid']?>')">
                <i class="fa fa-trash-o"></i>
              </a>
              </tr>
             <?}?> 
        <?php endforeach; ?>

    <?php endif; ?>
  <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
  </table>
  <?=str_replace('筆',' ' . $lang['BigClass'] . ', '.$lang['Total'].$total.$lang['Records'],$page)?>
  </form>
<p style="height:200px;"></p>

</body>
</html>
<script>
  var temp_id;

  function del_file(name,id){
    if(confirm('確定刪除['+name+']資料?'))
      window.location.href='/<?=$DataName?>/data_AED/<?=$dbname?>/'+id;
  }

  const setID = (id) => {
    temp_id = id;
  }

  const enable = () => {
    $.ajax({
      url: `/products/enable_buying/${temp_id}`,
      dataType: 'JSON',
      type: 'POST',
      data: {
        start_at: $('#start_at').val(),
        end_at: $('#end_at').val()
      },
      success: response => {
        alert('啟用成功');
        location.reload();
      },
      error: (xhr, text) => {
        if (xhr.status === 422) {
          alert('請輸入日期');
        }
      }
    })
  }

  const cancel = (id) => {
    if (confirm('<?=$lang['ConfirmToStopSnapUp']?>')) {
      $.ajax({
        url: `/products/cancel_buying/${id}`,
        dataType: 'JSON',
        success: response => {
          alert('<?=$lang['DeleteSuccess']?>');
          location.reload();
        }
      })
    }
  }

  const edit = () => {
    $.ajax({
      url: `/products/judge_buying/${temp_id}`,
      dataType: 'JSON',
      type: 'POST',
      data: {
        start_at: $('#start_at_2').val(),
        end_at: $('#end_at_2').val()
      },
      success: response => {
        alert('編輯成功');
        location.reload();
      },
      error: (xhr, text) => {
        if (xhr.status === 422) {
          alert('請輸入日期');
        }
      }
    })
  }
  
</script>