(function ($) {
	  // $.each( arr, function( key, value ) {
   //       // var key=value;
   //        console.log(key);
   //    });

	//action : Insert a product id into cart list
	var add_to_cart = function (prd_id) {

		$.blockUI({ 
          message: ""+arr.process+"",
          css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7,
            color: '#fff' 
          }
        });//'為您確認線上存貨中，請稍後..'
        setTimeout(function(){$.unblockUI();}, 1000);

		var prd_num = parseInt($('#prd_num').val());
		setTimeout(function() {
			$.ajax({
		        type: "post",
		        url: '/cart/add_to_cart',
		        data: {
		            prd_id: prd_id,
		            prd_num: parseInt($('#prd_num').val())
		        },
		        cache: false,
		        async: false,
		        success: function (response) {
		        	if(response=='NoLogin'){
		        		alert(''+arr.Login+'');	//請先登入或註冊會員
		        		window.location.href='/gold/login/shop';
		        	}
		        	if(response=='Noshop'){
		        		alert(''+arr.process2+'');//此商品為限購商品，您已購買過
		        		window.location.href='/cart/product_info/1/'+prd_id;
		        	}
		        	// $('#info').fadeIn();
		         	// $('#info').html(response);
		         	amount_and_price_get(response);
		        }
		    });
		}, 1300);
	},

	amount_and_price_get = function (mystatus) {
		var boxtitle='';
		$.ajax({
	        type: "post",
	        url: '/cart/amount_and_price_get',
         	dataType: "json",
	        cache: false,
	        async: false,
	        success: function (response) {
                if(mystatus == 'deficient')
	         	{
         			boxtitle=''+arr.process3+'';	//商品數量不足或已經下架
	         		$("#dialog-message").text(''+
		        		''+arr.process4+''//'建議您直接聯繫商品提供廠商'
	                );
	                $( "#dialog-message" ).dialog({
 	                	 modal: true,
	                	 title: boxtitle,
						 buttons: [{
		                    text: arr.process15,
		                    click: function () {
		                        window.location.href=$('#iqr_url').text();                    
		                    }
		               		 }, {
		                    text: arr.cencel,
		                    click: function () {
                                $( this ).dialog( "close" );
		                    }
		                }]

				    });//'前往商家名片''取消'
				    return false;
	         	}
	         	else
	         	{
	         		if(mystatus == 'adding')
	         		{
	         			boxtitle=arr.process5;//'商品已加入購物車'
	         			$("#dialog-message").text(''+
		        		''+arr.process6+' '+response.total_num+' '+arr.process7+'\n'+
	                	''+arr.process8+' '+response.total_price+''+arr.pri+' \n'+
	                	''+arr.process9+'?'
		                );
		                /*您的購物車共有 件商品， 共計 元 請問您要「前往結帳」還是「繼續購物」*/
		     			$( "#dialog-message" ).dialog({
		                	modal: true,
		                	title: boxtitle,
							 buttons: [{
			                    text: arr.process13,
			                    click: function () {
			                        window.location.href='/cart/check/'+$('#cset_code').text()+'/1';                    
			                    }
			               		 }, {
			                    text: arr.process14,
			                    click: function () {
			                        window.location.href='/cart/store/'+$('#cset_code').text();
									$( this ).dialog( "close" );
			                    }
			                }]
					    });
					    //'前往結帳' '繼續購物'
	         		}
		         	else if(mystatus == 'limited')
		         	{
	         			boxtitle=arr.process10;//'購買數量已達單次購買上限'

	         			$("#dialog-message").text(''+
		        		''+arr.process11+'('+arr.process12+'：'+ response['lock_amount']+
	                	')'+arr.process9+'?'
		                );
		                //此商品購買數量已達購買上限 上限數量 ，請問您要「前往結帳」還是「繼續購物」
		     			$( "#dialog-message" ).dialog({
		                	modal: true,
		                	title: boxtitle,
							buttons: [{
			                    text: arr.process13,
			                    click: function () {
			                        window.location.href='/cart/check/'+$('#cset_code').text()+'/1';                    
			                    }
			               		 }, {
			                    text: arr.process14,
			                    click: function () {
			                        window.location.href='/cart/store/'+$('#cset_code').text();
									$( this ).dialog( "close" );
			                    }
			                }]
					    });

		         	}
		        	

				    //cart_link								
				    // $('#cart_link').attr('data-content', "已選購商品<br><span style='color:#DA5049'>"+response.total_num+"</span> 件<br>總金額(TWD)<br><span style='color:#DA5049'>"+response.total_price+"</span> 元<br><a class='aa5' href='/cart/check/"+$('#cset_code').text()+"/1'>結帳</a>");
				    $('#cart_link').attr('data-content', ""+arr.ordering+"<br><span style='color:#DA5049'>"+response.total_num+"</span> "+arr.pic+"<br>"+arr.total+"<br><span style='color:#DA5049'>"+response.total_price+"</span> "+arr.pri+"<br><a class='aa5' href='/cart/check/"+$('#cset_code').text()+"/1'>"+arr.checkout+"</a>");
				    //已選購商品 件 總金額(TWD) 元 結帳

	     		}
	        }
	    });
	};

	onload_amount_and_price_get = function () {
		var boxtitle='';
		$.ajax({
	        type: "post",
	        url: '/cart/amount_and_price_get',
         	dataType: "json",
	        cache: false,
	        async: false,
	        success: function (response) {
			    //cart_link
			    $('#cart_link').attr('data-content', ""+arr.ordering+"<br><span style='color:#DA5049'>"+response.total_num+"</span> "+arr.pic+"<br>"+arr.total+"<br><span style='color:#DA5049'>"+response.total_price+"</span> "+arr.pri+"<br><a class='aa5' href='/cart/check/"+$('#cset_code').text()+"/1'>"+arr.checkout+"</a>");
	        }
	    });
	};

	$(function()
	{
		//add to cart
		$('#add_to_cart').click(function () {
			add_to_cart($('#prd_id').text());
		});

		onload_amount_and_price_get();
		
	});

}(jQuery));
