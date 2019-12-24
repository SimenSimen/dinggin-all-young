

// dropdownKWh ..

jQuery(document).ready(function($) {

 	WindowWidth = $(this).width(); 

 	if ( WindowWidth < 767) { 

 		$('.dropdownTop , .dropdownEnd , .dropdownContent ').click(function() {
				
			$('.dropdownContent').stop(true,true).slideToggle(500);

			$('.dropdownEnd').stop(true,true).slideToggle(500);

			$('.dropdownView').stop(true,true).slideToggle(500); 

		});


		$('.dropdownContent').click(function() {

			var dataDrop =	$(this).attr('date-drop');

			if( dataDrop == 0){

				

				$('.dropdownView').text(

					"全部商品"

				);

			}

			

			
			$('.dropdownContent').slideUp(500);

			$('.dropdownEnd').slideUp(500);

			$('.dropdownView').slideDown(500); 

		});

 	} 


	$('.dropdownContent .row .col-xs-12 ,.dropdownContent-B2B .row .col-xs-12').click(function() {

		var $this = $(this)

		$this.addClass('dropdownControl').siblings('.dropdownControl').removeClass('dropdownControl');

		return false;

		}).find('a').focus(function(){

		this.blur();

	});

});

jQuery(document).ready(function($) {

	$('.dropdownTop-B2B').click(function() {

		$('.dropdownContent-B2B-Mobile .MobileMenu').slideToggle(400);

	});



	$('.dropdownContent-B2B-Mobile .MobileMenu li').click(function(){

		var dataName = $(this).find('a').attr('date-name');

		$('.dropdownTop-B2B').text((dataName));

		$('.dropdownContent-B2B-Mobile .MobileMenu').slideUp(400);

	});

	
});


