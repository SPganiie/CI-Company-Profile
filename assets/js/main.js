	$('#tombolScrollTop').hide();
		$(document).ready(function(){
			$(window).scroll(function(){
				if ($(window).scrollTop() > 200) {
					$(window).scrollTop() > 287 ?	collapse() : normalize() ;
					$('#tombolScrollTop').fadeIn();
				} else {
					$('#tombolScrollTop').fadeOut();
				}
		});
	});

	function collapse()
	{
		$('#menu').css({
			"position": "fixed", "width": "100%","background-color":"#ffff","z-index":"20","top":"-30px","opacity":".9"
		});
	}

	function normalize()
	{
		$('#menu').css({"position": "", "width": "","background-color":"#ffff","z-index":"20","top":""})
	}
	function scrolltotop()
	{
		$('html, body').animate({scrollTop : 0},1000);
	}
	function openNav() {
		$('#sideNavigation').css({'width':'85%','z-index':'100'});
	  $('#main').css("margin-left","250px")
	}

	function closeNav() {
		$("#sideNavigation").css("width","0");
		$("#main").css("margin-left","0");
	}

	function down(x) {
		console.log(x);
		$('#guide i').on('click',function(){
			$(this).toggleClass('drop');
			$(".chl-guide").toggleClass('on');
		});
	}

	function dropbox(x) {
		$(".list ul").addClass('on');
	}

	function dropboxEnd(x) {
		$(".list ul").addClass('off').removeClass('on');
	}

	function tabbox() {
		$('.list .off').toggleClass('on')
	}
