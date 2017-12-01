;(function($) {
	$.fn.previsu_spip = function(settings) {
		var options;

		options = {
			previewParserPath:	'' ,
			previewParserVar:	'data',
			textEditer:	'Editer',
			textVoir:	'Voir',
			textFullScreen: 'Plein écran'
		};
		$.extend(options, settings);

		return this.each(function() {

			var $$, textarea, tabs, preview;
			$$ = $(this);
			textarea = this;

			// init and build previsu buttons
			function init() {
				$$.addClass("pp_previsualisation");
				tabs = $('<div class="markItUpTabs"></div>').prependTo($$.parent());
				$(tabs).append(
					'<a href="#fullscreen" class="fullscreen">' + options.textFullScreen + '</a>' +
					'<a href="#previsuVoir" class="previsuVoir">' + options.textVoir + '</a>' +
					'<a href="#previsuEditer" class="previsuEditer on">' + options.textEditer + '</a>'
				);
				
				preview = $('<div class="markItUpPreview"></div>').insertAfter(tabs);
				preview.hide();

				var is_full_screen = false;
				var mark = $$.parent();
				var objet = mark.parents('.formulaire_spip')[0].className.match(/formulaire_editer_(\w+)/);
				objet = (objet ? objet[1] : '');
				var champ = mark.parents('.editer')[0].className.match(/editer_(\w+)/);
				champ = (champ ? champ[1].toUpperCase() : '');
				var textarea = mark.find('textarea.pp_previsualisation');
				var preview = mark.find('.markItUpPreview'); 
				var dir = textarea.attr('dir');
				if(dir){
					preview.attr('dir',dir);
				}

				tabs.find('.fullscreen').click(function(){
					// On commence par garder en mémoire la valeur d'origine de la taille du champ
					if (!mark.is('.fullscreen')) {
						textarea.data('height-origin', textarea.css('height'));
					}
					
					mark.toggleClass('fullscreen');
					
					// Si on vient de passer en fullscreen
					if (mark.is('.fullscreen')){
						is_full_screen = true;
						if (!mark.is('.livepreview')){
							var original_texte="";
							
							function refresh_preview(){
								var texte = textarea.val();
								if (original_texte == texte){
									return;
								}
								renderPreview(preview.addClass('ajaxLoad'),texte,champ,objet);
								original_texte = texte;
							}
							
							var timerPreview=null;
							mark.addClass('livepreview').find('.markItUpEditor').bind('keyup click change focus refreshpreview',function(e){
								if (is_full_screen){
									if (timerPreview) clearTimeout(timerPreview);
									timerPreview = setTimeout(refresh_preview,500);
								}
							});
							
							$(window).bind('keyup',function(e){
								if (is_full_screen) {
									// Touche Echap pour sortir du mode fullscreen
									if (e.type=='keyup' && e.keyCode==27 && !markitup_prompt){
										mark.removeClass('fullscreen');
										// On remet la taille d'origine
										textarea.css('height', textarea.data('height-origin'));
										is_full_screen = false;
									}
								}
							});
						}
						mark.find('.markItUpEditor').trigger('refreshpreview');
					}
					// Si on sort du fullscreen
					else {
						// On remet la taille d'origine
						textarea.css('height', textarea.data('height-origin'));
						is_full_screen = false;
					}
					
					return false;
				});

				tabs.find('.previsuVoir').click(function(){
					preview.height(
						  mark.find('.markItUpHeader').height()
						+ mark.find('.markItUpEditor').height()
						+ mark.find('.markItUpFooter').height()
					);

					mark.find('.markItUpHeader,.markItUpEditor,.markItUpFooter').hide();
					$(this).addClass('on').next().removeClass('on');
					renderPreview(
						preview.show().addClass('ajaxLoad'),
						mark.find('textarea.pp_previsualisation').val(),
						champ,
						objet,
						false
					);

					return false;
				});
				tabs.find('.previsuEditer').click(function(){
					mark.find('.markItUpPreview').hide();
					mark.find('.markItUpHeader,.markItUpEditor,.markItUpFooter').show();
					$(this).addClass('on').prev().removeClass('on');
					
					return false;
				});
			}

			function renderPreview(node, val, champ, objet, async) {
				if (options.previewParserPath !== '') {
					$.ajax( {
						type: 'POST',
						async: typeof (async)=="undefined"?true:async,
						url: options.previewParserPath,
						data: 'champ='+champ
							+'&objet='+objet
							+'&' + options.previewParserVar+'='+encodeURIComponent(val),
						success: function(data) {
							node.html(data).removeClass('ajaxLoad');
							//ouvre un nouvel onglet lorsqu'on clique sur un lien dans la prévisualisation
							$("a",node).attr("target","blank");
						}
					} );
				}
			}
	
			init();
		});
	};
})(jQuery);
