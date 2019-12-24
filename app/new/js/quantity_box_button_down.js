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
      if( !isNaN( qty ) && qty > 0 ){
    qty_el.value--;
      }         
      return false;
  }
  function qtyUp(){
      var qty_el = document.getElementById('qty'); 
      var qty = qty_el.value; 
      if( !isNaN( qty )) {
    qty_el.value++;
      }
      jQuery('.quantity_box_button_down').css({
    'visibility' : 'visible'
      });
      return false;
  }