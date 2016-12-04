LiveReloadPHP

Je cherchais un moyen d'avoir le comportement du logiciel LiveReload sans l'installer.
Sous Windows et avec SublimeText, je n'arrivais pas à faire marcher ce logiciel.

Il me fallait donc une alternative.

Le script est constitué de deux fichiers.
Le fichier "livereload.js" envoie une requète ajax au fichier "verif.php" toutes les demi secondes et selon son retour il recharge la page ou pas.

Le fichier "verif.php" regarde la date de modification de chaque fichier surveillé et indique si l'un d'entre eux a été modifié.
