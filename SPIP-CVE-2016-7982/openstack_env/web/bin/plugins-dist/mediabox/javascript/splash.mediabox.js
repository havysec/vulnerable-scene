(function($){
	$(function(){
		// poser le cookie au callback de la box chargee
		var set_cookie = function() {
			$.cookie("modalsplash", box_settings.splash_url, { expires: 7 });
		}

		$.modalboxsplash = function(href, options) {
			if (box_settings_iframe) {
				$.fn.mediabox($.extend({
					href:href,
					onComplete:set_cookie,
					overlayClose:true,
					iframe: true,
					width: box_settings_splash_width,
					height: box_settings_splash_height
				},options));
			} else {
				$.fn.mediabox($.extend({
					href:href,
					onComplete:set_cookie,
					overlayClose:true
				},options));
			}
		};
		// ouvrir la splash page si pas deja vue
		if ($.cookie("modalsplash") != box_settings.splash_url)
			$.modalboxsplash(box_settings.splash_url);

	});
})(jQuery);