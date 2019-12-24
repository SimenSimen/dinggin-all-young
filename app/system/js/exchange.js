$(function(){
  $( "#tabs" ).tabs();
  $( ".db_checkbox" ).click(function(e) {
      var chk = $(this).closest("td").find("input:checkbox").get(0);
      if(e.target != chk)
        chk.checked = !chk.checked;
  });

  $( ".check_tabs_all" ).click(function(e) {
      $('#tabs input:checkbox').prop('checked', this.checked);
  });

  $( ".checkall" ).click(function(e) {
      var table = $(e.target).closest('table');
      $('td input:checkbox', table).prop('checked', this.checked);
  });

  $( ".checkall_td" ).click(function(e) {
      var table = $(e.target).closest('table');
      var checkall = table.find(".checkall").get(0);
      checkall.checked = !checkall.checked;
      $('td input:checkbox', table).prop('checked', checkall.checked);
  });

  $('#why_panel').hover(function(){
    $('#prompt_panel').show();
  }, function() {
    $('#prompt_panel').hide();
  });
});