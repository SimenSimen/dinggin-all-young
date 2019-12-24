function sel_area(avalue,areaid,id){
	$.ajax({
	    url:'/member/select_area',
	    type:'POST',
	    data: 'pid=' + avalue,
	    dataType: 'json',
	    success: function( json ) 
	    {
	       var options = '';
	            // options += '<option value="0">請選擇鄉鎮地區</option>';

	        for (var i = 0; i < json.length; i++) 
	        {
	        	if(areaid==json[i].s_id){
	        		select='selected';
	        	}else
	        		select='';
	            options += '<option value="' + json[i].s_id + '"'+select+'>' + json[i].s_name + '</option>';
	            $("#"+id+"").html(options); 
	            var s='';
	        }
	        // $('#oAdress').prop('readonly', false) ;
	    }   
	});     
}
