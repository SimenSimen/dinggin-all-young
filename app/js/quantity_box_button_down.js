var qty_el = document.getElementById('qty'); 
  /* var qty = qty_el.value; 
  if(qty < 2){
      jQuery('.quantity_box_button_down').css({
    'visibility' : 'hidden'
      });
  }
  */
  function qtyDown(){
      var qty_el = document.getElementById('qty'); 
      var qty = qty_el.value; 
      if( qty == 2) {
    jQuery('.quantity_box_button_down').css({
        'visibility' : 'hidden'
    });
      }
      if( !isNaN( qty ) && qty >= 1 ){
        qty_el.value--;
      }         
      return false;
  }
  function qtyUp($num=1){
      var qty_el = document.getElementById('qty'); 
      var qty = Number(qty_el.value);
      if( (!isNaN( qty )) && (qty<$num) ) {
        qty_el.value++;
        //qty_el.value=qty+$num;
      }
      jQuery('.quantity_box_button_down').css({
    'visibility' : 'visible'
      });
      return false;
  }