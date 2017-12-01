;(function($){

$.fn.spiptree = function(options) {

	var $mytree = $(this);
	var $mytree_source = $mytree.clone();
	// $mytree.after($mytree_source);

	options.plugins = [ "types", "search", "state" ];
	if (options.drag) {
		options.plugins.push("dnd");
	}

	options.types = {
		"#" : {
			"valid_children" : ["default"]
		},
		"default" : {
			"icon" : options.default.icon,
			"valid_children" : [ "default" ]
		}
	}

	options.confirm = {
		move: null
	};

	$.each(options.objets, function(nom, desc) {
		options.types.default.valid_children.push(desc.type);
		options.types.default.valid_children.push("box_" + desc.type);
		options.types[desc.type] = {
			"icon" : desc.icon,
			"max_children" : 0,
			"max_depth" : 0
		};
		options.types["box_" + desc.type] = {
			"icon" : desc.icon,
			"max_depth" : 1,
			"valid_children" : [ desc.type ]
		};
	});

	$mytree.jstree({
		"plugins" : options.plugins,
		"core" : {
			"animation" : 0,
			"check_callback" : function (op, node, par, pos, more) {
				if (op === "move_node") {
					// à la fin d'un déplacement, demander 1 fois (et 1 seule) 
					// une confirmation, même si on déplace 5 items d'un coup
					if (more && more.core) {
						if (options.confirm.move === null) {
							options.confirm.move = confirm( options.textes.deplacement.confirmation );
							// enlever les messages de réussite ou d'erreur pour en avoir des tout neufs
							if (options.confirm.move) {
								$('#contenu p.success, #contenu div.error').remove();
							}
						}
						return options.confirm.move;
					} else {
						// redemander la confirmation au prochain tour
						options.confirm.move = null;
					}
				}
				return true;
			},
			"data" : function (node, cb) {
				// on est obligé de tout charger en ajax (même la racine)
				// donc on charge 1 fois la racine avec le html d'origine
				if (node.id === '#') {
					cb($mytree_source.html());
				}

				// et pour ce qu'on ne connait pas (classe css 'jstree-closed' sur un LI, et pas de UL à l'intérieur)
				// on fait un appel ajax pour obtenir la liste correspondant à l'objet souhaité, lorsque c'est demandé.
				else {
					var objet = node.data.objet;
					var id_rubrique = (objet == 'rubrique')
						? node.id.split('-')[1]
						: node.parent.split('-')[1];
					var params = {
						"id_rubrique": id_rubrique,
						"objet": objet
					};
					if (options.statut) {
						params.statut = options.statut;
					}

					$.ajax({
						url: options.urls.plan,
						data: params,
						dataType: 'html',
						cache: false,
					}).done(function(data) {
						if (data !== undefined) {
							cb(data);
						} else {
							cb("");
						}
					});
				}
			}
		},
		"search" : {
			"show_only_matches" : true,
		},
		"types" : options.types
	});

	if (options.drag) {
		$mytree.addClass('drag');
	}

	// un clic d'une feuille amène sur son lien
	// mais… éviter que le plugin 'state' clique automatiquement lorsqu'il restaure
	// la sélection précédente !
	$mytree.one("restore_state.jstree", function () {
		$(this).on("changed.jstree", function (e, data) {
			data.instance.save_state();
			var node = data.instance.get_node(data.node, true);
			if (node) {
				var lien = node.children('a').attr('href');
				if (lien && !(options.drag && $(data.event.target).hasClass('jstree-icon'))) {
					location.href = lien;
				}
			}
		});
	});

	var recharge_plan = false;
	// lorsqu'on déplace un nœud
	$mytree.on("move_node.jstree", function(event, data) {
		// si les parents sont identiques : pas de changement,
		// on ne peut/veut pas gérer ici les positionnements

		if (data.old_parent == data.parent) {
			// data.instance.refresh();
			return true;
		}

		// il existe 2 cas de boites :
		// - un item (rubrique, article, site) a été déplacé
		// - un conteneur (box_xx) a été déplacé (ie: tous les articles qu'il contient par exemple)
		//   dans ce cas on retrouve tous les identifiants déplacés
		var box = (data.node.type.substring(0, 4) == 'box_');
		var infos = data.node.id.split('-'); // articles-rubrique-30 (box) ou article-30 (item)

		if (box) {
			var ids = [];
			$.each(data.node.children, function(key, val) {
				ids.push( val.split('-')[1] );
			});
			var params = {
				objet: infos[0],
				id_objet: ids, 
				id_rubrique_source: infos[2],
				id_rubrique_destination: data.parent.split('-')[1]
			}
		} else if (infos[0] == 'rubrique') {
			// les rubriques n'ont pas de 'box_' et sont directement dans les sous rubriques
			var params = {
				objet: infos[0],
				id_objet: [ infos[1] ],
				id_rubrique_source: (data.old_parent == '#' ? 0 : data.old_parent.split('-')[1]),
				id_rubrique_destination: (data.parent == '#' ? 0 : data.parent.split('-')[1])
			}
		} else {
			// un item, sa destination est soit une box (de même type) soit une rubrique
			var dest = data.parent.split('-'); // articles-rubrique-30 (box) ou rubrique-30
			var params = {
				objet: infos[0],
				id_objet: [ infos[1] ],
				id_rubrique_source: data.old_parent.split('-')[2],
				id_rubrique_destination: (dest.length == 3 ? dest[2] : dest[1]),
			}
		}

		$.ajax({
			url: options.urls.deplacer,
			data: params,
			dataType: 'json',
			cache: false,
		}).done(function(response) {

			if (response) {
				var nb_success = Object.keys(response.success).length;
				var nb_errors  = Object.keys(response.errors).length;
				if (nb_success) {
					var $box = $("#contenu p.success");
					if (!$box.length) {
						$("#contenu #mytree_actions").after("<p class='success removable' onClick='$(this).remove();'></p>");
						$box = $("#contenu p.success").data('nb', 0);
					}
					nb = nb_success + $box.data('nb');
					$box.data('nb', nb).text(nb == 1
						? options.textes.deplacement.reussi
						: options.textes.deplacement.reussis.replace('@nb@', nb));
				}
				if (nb_errors) {
					var $box = $("#contenu div.error");
					if (!$box.length) {
						$("#contenu #mytree_actions").after("<div class='error removable' onClick='$(this).remove();'><p /><ul class='spip' /></div>");
						$box = $("#contenu div.error").data('nb', 0);
					}
					nb = nb_errors + $box.data('nb');
					$box.data('nb', nb).find('p').text(nb == 1
						? options.textes.deplacement.echec
						: options.textes.deplacement.echecs.replace('@nb@', nb));
					$.each(response.errors, function(i, error) {
						$box.find('ul').append("<li>[ " + i + "] " + error+ "</li>");
					});
				}
			}

			if (recharge_plan) {
				clearTimeout(recharge_plan);
			}
			recharge_plan = setTimeout(function () {
				ajaxReload('plan');
			}, 500);
		});

		return true;
	});


	// recherche automatique
	$mytree_search = $("#mytree_search");

	var to = false;
	$mytree_search.keyup(function () {
		if (to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $mytree_search.val();
			$mytree.jstree(true).search(v);
		}, 250);
	});

};

})(jQuery);
