function formulaire_editer_message_set_dest(input,item){
	var id_auteur;
	var box = jQuery(input).siblings('.selected');
	if (item.value) {
		id_auteur = item.value;
		var nom = item.label;
		if (box.find('input[value='+id_auteur+']').length==0){
			box.find('.on').removeClass('on');
			box.append(" <span class='dest on'>"
			+ nom
			+"<input type='hidden' name='"
			+ jQuery(input).attr('data-name')
			+ "' value='"+id_auteur+"' /> "
			+ $(box).find('span.dest:first').html()
			+"</span>");
		}
		else {
			box.find('input[value='+id_auteur+']').closest('span').addClass('on').siblings('.on').removeClass('on');
		}
	}
	jQuery(input).val('');//.get(0).focus();
}
function formulaire_editer_message_init(){
	jQuery("input.destinataires:not(.autocompleted)").each(function(){
		var me = this;
		jQuery(me)
			.autocomplete({
				source: url_trouver_destinataire, 
				minLength:2,
				/*autoFocus:1,*/
				select: function(event,ui){
					event.preventDefault();
					formulaire_editer_message_set_dest(me, ui.item);
				},
				focus: function(event, ui){
					event.preventDefault();
					jQuery(me).val(ui.item.label);
				},
			})
			.parent().on('click', function(){jQuery(me).get(0).focus();});
	})
	.addClass('autocompleted');
}
if (window.jQuery){
	jQuery(function(){
		formulaire_editer_message_init();
		onAjaxLoad(formulaire_editer_message_init);
	});
}
