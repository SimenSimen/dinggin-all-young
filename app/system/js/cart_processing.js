(function ($) {

	//action : Insert a product id into cart list
	var add_to_cart = function (prd_id) {
		$.blockUI({ 
          message: '為您確認線上存貨中，請稍後..',
          css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7,
            color: '#fff' 
          } 
        });
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
         			boxtitle='商品數量不足或已經下架';
	         		$("#dialog-message").text(''+
		        		'建議您直接聯繫商品提供廠商'
	                );
	                $( "#dialog-message" ).dialog({
	                	modal: true,
	                	title: boxtitle,
						buttons: {
							'前往商家名片': function() {
								window.location.href=$('#iqr_url').text();
							},
							'取消': function() {
								$( this ).dialog( "close" );
							}
						}
				    });
				    return false;
	         	}
	         	else
	         	{
	         		if(mystatus == 'adding')
	         			boxtitle='商品已加入購物車';
		         	else if(mystatus == 'limited')
	         			boxtitle='您的訂購數量已達庫存上限';
		        	$("#dialog-message").text(''+
		        		'您的購物車共有 '+response.total_num+' 件商品，\n'+
	                	'共計 '+response.total_price+' 元\n'+
	                	'請問您要「前往結帳」還是「繼續購物」?'
	                );
	     			$( "#dialog-message" ).dialog({
	                	modal: true,
	                	title: boxtitle,
						buttons: {
							'前往結帳': function() {
								// window.location.href='/cart/cswitch/'+$('#cset_code').text();
								window.location.href='/cart/check/'+$('#cset_code').text()+'/1';
							},
							'繼續購物': function() {
								window.location.href='/cart/store/'+$('#cset_code').text();
								$( this ).dialog( "close" );
							}
						}
				    });

				    //cart_link
				    $('#cart_link').attr('data-content', "<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>"+response.total_num+"</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>"+response.total_price+"</span>元(TWD)</span>");
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
			    $('#cart_link').attr('data-content', "<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>"+response.total_num+"</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>"+response.total_price+"</span>元(TWD)</span>");
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