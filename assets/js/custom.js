function HideContent(d,a) { if(d.length < 1) { return; } document.getElementById(d).style.display = "none"; document.getElementById(a).style.display = "block"; }

/*atas*/
function ShowContent(d) { if(d.length < 1) { return; } document.getElementById(d).style.display = "block";}

function createCookie(name,value,days) { var expires = ""; if (days) { var date = new Date(); date.setTime(date.getTime() + (days*24*60*60*1000)); expires = "; expires=" + date.toUTCString(); } document.cookie = name + "=" + value + expires + "; path=/"; }

function readCookie(name) { var nameEQ = name + "="; var ca = document.cookie.split(';'); for(var i=0;i < ca.length;i++) { var c = ca[i]; while (c.charAt(0)==' ') c = c.substring(1,c.length); if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length); } return null; }

function eraseCookie(name) { createCookie(name,"",-1); }

function styleSet(warna) { $('#b_navbar').css('background', '#'+warna); createCookie('wcookie',warna,365); }

/*samping*/
function ShowContent_b(d) { if(d.length < 1) { return; } document.getElementById(d).style.display = "block"; }

function createCookie_b(name,value,days) { var expires = ""; if (days) { var date = new Date(); date.setTime(date.getTime() + (days*24*60*60*1000)); expires = "; expires=" + date.toUTCString(); } document.cookie = name + "=" + value + expires + "; path=/"; }

function readCookie_b(name) { var nameEQ = name + "="; var ca = document.cookie.split(';'); for(var i=0;i < ca.length;i++) { var c = ca[i]; while (c.charAt(0)==' ') c = c.substring(1,c.length); if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length); } return null; }

function eraseCookie_b(name) { createCookie_b(name,"",-1); }

function styleSetMenu(warna) { $('#b_menulist').css('background', '#'+warna); createCookie_b('wcookie_b',warna,365); }

/*konten*/
function ShowContent_c(d) { if(d.length < 1) { return; } document.getElementById(d).style.display = "block"; }

function createCookie_c(name,value,days) { var expires = ""; if (days) { var date = new Date(); date.setTime(date.getTime() + (days*24*60*60*1000)); expires = "; expires=" + date.toUTCString(); } document.cookie = name + "=" + value + expires + "; path=/"; }

function readCookie_c(name) { var nameEQ = name + "="; var ca = document.cookie.split(';'); for(var i=0;i < ca.length;i++) { var c = ca[i]; while (c.charAt(0)==' ') c = c.substring(1,c.length); if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length); } return null; }

function eraseCookie_c(name) { createCookie_c(name,"",-1); }

function styleSetContent(warna) { $('#b_content').css('background', '#'+warna); createCookie_c('wcookie_c',warna,365); }

(function ($) {

	jQuery(window).load(function() { 
		jQuery("#preloader").delay(100).fadeOut("slow");
		jQuery("#load").delay(100).fadeOut("slow");
	});

	//jQuery to collapse the navbar on scroll
	$(window).scroll(function() {
		if ($(".navbar").offset().top > 50) {
			$(".navbar-fixed-top").addClass("top-nav-collapse");
		} else {
			$(".navbar-fixed-top").removeClass("top-nav-collapse");
		}
	});

	//jQuery for page scrolling feature - requires jQuery Easing plugin
	$(function() {
		$('.navbar-nav li a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
		$('.page-scroll a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
	});

})(jQuery);
