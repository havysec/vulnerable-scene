function editbox_init(){
	jQuery('a.editbox:not(.nobox)')
	.attr("onclick","").addClass('nobox').click(function(){
		var casedoc = jQuery(this).parents('div.item').eq(0);
		jQuery(casedoc).animateLoading();
		jQuery.modalboxload(parametre_url(parametre_url(jQuery(this).attr('href'),'popin','oui'),'var_zajax','contenu'),{
			onClose: function (dialog) {jQuery(casedoc).ajaxReload();}
		});
		return false;
	});
}
var editbox_initialized;
if (!editbox_initialized){
	if (window.jQuery){
		editbox_initialized = true;
		(function($){if(typeof onAjaxLoad == "function") onAjaxLoad(editbox_init);
			$(editbox_init);
		 })(jQuery);
	}
}
var multifile_loader;
if (typeof multifile_loader=="undefined" && typeof multifile!="undefined"){
	multifile_loader = jQuery.getScript(multifile,function(){
		jQuery("input[type=file].multi").MultiFile();
		onAjaxLoad(function(){if (typeof jQuery!="undefined") jQuery("input[type=file].multi").MultiFile();});
	});
}
