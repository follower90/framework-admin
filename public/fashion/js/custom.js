//MAGNIFIC POPUP
$(document).ready(function () {
	$('.images-block').magnificPopup({
		delegate: 'a',
		type: 'image',
		gallery: {
			enabled: true
		}
	});
});

(function ($) {
	// TOOLTIP
	$(".header-links .fa, .tool-tip").tooltip({placement: "bottom"});
	$(".btn-wishlist, .btn-compare, .display .fa").tooltip('hide');

	// TABS
	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

})(jQuery);

function repaceHtmlWithFade(elem, data) {
	$(elem).css({opacity: 0.2}).fadeOut('fast').html(data).fadeIn('fast').animate({opacity: 1}, 200);
}
