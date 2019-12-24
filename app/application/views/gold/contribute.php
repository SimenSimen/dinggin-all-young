<body class="bg-style">
    <div class="contribute">
        <a href="/gold/draft">
            <img src="/images/gold/icon-folder.png" width="96" height="81">
        </a>
    </div>
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['contribute'];//心得投稿?></header>
    <div class="wrapper">
        <section class="content">
           <form  class="j-forms">
                <div class="unit">
                    <label class="label"><?=$this->lang['title'];//主旨?></label>
                    <div class="input">
                        <label class="icon-left" for="search"><i class="fa fa-file-o"></i></label>
                        <input type="text" placeholder="<?=$this->lang['ititle'];//請輸入標題?>" name="d_title" value="<?=$dbdata['d_title']?>" required>
                    </div>
                </div>
                <div class="unit">
                    <label class="label"><?=$this->lang['content'];//內容?></label>
                    <div class="input">
                        <label class="icon-left" for="textarea"><i class="fa fa-file-text-o"></i></label>
                        <textarea placeholder="<?=$this->lang['icontent'];//請輸入您的投稿內容?>" name="d_content" required><?=$dbdata['d_content']?></textarea>
                    </div>
                </div>
                <div class="footer">
                  <?if($d_id!=''):?>
                    <input type="button" class="primary-btn" value="<?=$this->lang['chk'];//確認投稿?>" onClick="submit1('1',<?=$d_id?>)">
                    <input type="button" class="primary-btn" value="<?=$this->lang['edit'];//修改草稿?>" onClick="submit1('2',<?=$d_id?>)">
                  <?else:?>
                    <input type="button" class="primary-btn" value="<?=$this->lang['chk'];//確認投稿?>" onClick="submit1('1',0)">
                    <input type="button" class="primary-btn" value="<?=$this->lang['save'];//存為草稿?>" onClick="submit1('2',0)">
                  <?endif;?>
                    
                </div>
                </form>
        </section>
    </div>
</body>
</html>
<script>
  function submit1(type,edit_id){
    var title=$('input[name="d_title"]').val();
    var content=$('textarea[name="d_content"]').val();

    $.ajax({
      url:'/gold/save_contr',
      type:'POST',
      data: 'type='+type+'&title='+title+'&content='+content+'&edit_id='+edit_id,
      dataType: 'text',
      success: function( json ) 
      {
        if(json=='error'){
          alert("<?=$this->lang['ititlecont']?>"); //請輸入標題或內容!
          return '';
        }
        else if(json==1){
          alert("<?=$this->lang['sussecc']?>");//'投稿成功，請等待服務人員審核。'
          window.location.href="/gold/member_list";
        }else{
          alert("<?=$this->lang['savasu']?>");  //'存入草稿成功。'
          window.location.href="/gold/draft";
        }
        
      }
    });
  }   
  
</script>
