var mejsloader;
(function(){
	var L=mejsloader;
	if (typeof L == "undefined")
		mejsloader = L = {gs:null,plug:{},css:{},init:null,c:0,cssload:null};
	if (!L.init){
		L.cssload = function (f){
			if (typeof L.css[f]=="undefined"){
				L.css[f] = true;
				var stylesheet = document.createElement('link');
				stylesheet.href = f;
				stylesheet.rel = 'stylesheet';
				stylesheet.type = 'text/css';
				document.getElementsByTagName('head')[0].appendChild(stylesheet);
			}
		}
		L.init = function (){
			if (!(L.gs===true)) return;
			(function ($){
				jQuery("audio.mejs,video.mejs").not('.done').each(function (){
					var me = jQuery(this).addClass('done');
					//console.log(this);
					var id;
					if (!(id = me.attr('id'))){
						id = "mejs-"+(me.attr('data-id'))+"-"+(L.c++);
						me.attr('id', id);
					}
					var opt = {options: {}, plugins: {}, css: []}, i, v;
					for (i in opt){
						if (v = me.attr('data-mejs'+i)) opt[i] = jQuery.parseJSON(v);
					}
					function runthisplayer(){
						var run = true;
						//console.log(css);
						for (var c in opt.css){
							L.cssload(opt.css[c]);
						}
						for (var p in opt.plugins){
							//console.log(p);
							//console.log(L.plug[p]);
							// load this plugin
							if (typeof L.plug[p]=="undefined"){
								//console.log("Load Plugin "+p);
								run = false;
								L.plug[p] = false;
								jQuery.getScript(opt.plugins[p], function (){
									L.plug[p] = true;
									runthisplayer();
								});
							}
							// this plugin is loading
							else if (L.plug[p]==false){
								//console.log("Plugin "+p+" loading...");
								run = false;
							}
							else {
								//console.log("Plugin "+p+" loaded");
							}
						}
						if (run){
							new MediaElementPlayer('#'+id, jQuery.extend(opt.options, {
								"success": function (media){
									function togglePlayingState(){
										jQuery(media).closest('.mejs-inner').removeClass(media.paused ? 'playing' : 'paused').addClass(media.paused ? 'paused' : 'playing');
									}

									togglePlayingState();
									media.addEventListener('play', togglePlayingState, false);
									media.addEventListener('playing', togglePlayingState, false);
									media.addEventListener('pause', togglePlayingState, false);
									media.addEventListener('paused', togglePlayingState, false);
									if (me.attr('autoplay')) media.play();
								}
							}));
						}
					}

					runthisplayer();
				})
			})(jQuery);
		}
	}
	if (!L.gs){
		if (typeof mejscss !== "undefined"){
			L.cssload(mejscss);
		}
		L.gs = jQuery.getScript(mejspath,function(){
			L.gs = true;
			L.init(); // init immediate des premiers players dans la page
			jQuery(L.init); // init exhaustive de tous les players
			onAjaxLoad(L.init); // init lors d'un load ajax
		});
	}
})();
