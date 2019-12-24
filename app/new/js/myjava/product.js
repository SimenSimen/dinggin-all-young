prd_content_ck = CKEDITOR.replace( 'prd_content', {
    filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
    width : 450,
    height: 300,
    resize_enabled:false,
    enterMode: 2,
    forcePasteAsPlainText :true,
    toolbar :
    [
      ['Source', '-', 'Undo','Redo'],
      ['Cut','Copy' , 'Table', 'NumberedList','BulletedList'],
      ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
      ['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize'],
      ['Image']
    ]
 });
//onchange column number
$('#add_prd_describe_col').click(function(){
  $("#prd_describe_table").append(
    "<tr>"+
          "<td style='width: 441px;'>"+
          "  <input type='text' class='form-control' style='display:inline; width: 71%;' name='prd_describe[]' id='prd_describe[]' maxlength='128'>"+
          "  <button type='button' class='btn btn-danger del_prd_describe_col' onclick='javascript:void(0);'>移除</button>"+
          "</td>"+
          "</tr>"
      );
});
//delete
  $("#prd_describe_table_tbody").on('click', '.del_prd_describe_col', function()
  {
    $(this).parent().parent().remove();
  });

//onchange column number
  $('#add_prd_video_col').click(function(){
    $("#prd_video_table").append(
      "<tr>"+
            "<td>"+
            "  <input type='text' placeholder='影片標題' class='form-control' style='display:inline; width: 26%;' name='prd_video_name[]' id='prd_video_name[]' maxlength='32'>"+
            "  <input placeholder='影片網址' type='text' class='form-control' style='display:inline; width: 40%;' name='prd_video_link[]' id='prd_video_link[]' maxlength='255'>"+
            "  <button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>"+
            "</td>"+
            "</tr>"
        );
  });
  //delete
  $("#prd_video_table_tbody").on('click', '.del_prd_video_col', function()
  {
    $(this).parent().parent().remove();
  });
  //onchange column number
  $('#add_prd_specification_col').click(function(){
    $("#prd_specification_table").append(
      "<tr>"+
            "<td>"+
            "  <input type='text' placeholder='規格名稱' class='form-control' style='display:inline; width: 26%;' name='prd_specification_name[]' id='prd_specification_name[]' maxlength='16'>"+
            "  <input placeholder='規格內容' type='text' class='form-control' style='display:inline; width: 40%;' name='prd_specification_content[]' id='prd_specification_content[]' maxlength='128'>"+
            "  <button type='button' class='btn btn-danger del_prd_specification_col' onclick='javascript:void(0);'>移除</button>"+
            "</td>"+
            "</tr>"
        );
  });
  //delete
  $("#prd_specification_table_tbody").on('click', '.del_prd_specification_col', function()
  {
    $(this).parent().parent().remove();
  });