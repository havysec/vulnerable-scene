# TODO

Quelques idées d'évolutions.

[ ] dans le paramètre forums_forcer_previsu (oui/non), ajouter une troisième option pour ne forcer la previsu que pour les personnes non-loggées, voire établir une liste de statuts d'auteur·e·s pour lesquel·le·s ne pas forcer la previsu.
[ ] différencier le style des boutons "previsualiser" et "envoyer" (quand la prévisualisation n'est pas forcée) pour que le bouton "previsualiser" apparaisse comme un lien, style Redmine (voir http://stackoverflow.com/a/5734628 pour deux solutions pas vraiment satisfaisantes de le faire)
[ ] sécurité (cerdic) - avec ce code, il doit sans doute déjà être possible de contourner la previsu avec un post bien senti, mais on doit pouvoir améliorer cela en injectant une signature du texte dans confirmer_previsu_forum et en verifiant cette signature lors du POST
