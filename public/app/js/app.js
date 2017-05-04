$(function () {
	$(window).bind("load resize", function () {
		topOffset = 50;
		width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		if (width < 768) {
			$('div.navbar-collapse').addClass('collapse');
			topOffset = 100;
		} else {
			$('div.navbar-collapse').removeClass('collapse');
		}
	});
});
