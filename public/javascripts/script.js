
$(document).ready(function(){

		//Changing NAV LINK ACTIVE STATE when reaching each section

		$('.page, #intro').mouseenter(function(){
			var secIndex = $(this).attr('id');
			$('.desktop-nav li a').removeClass('active');
		   	$('#'+secIndex+'-linker').addClass('active');
		})

		$('.desktop-nav li a').click(function(){
			$('.desktop-nav li a').removeClass('active');
		   	$(this).addClass('active');
		})
	});




