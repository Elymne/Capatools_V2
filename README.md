CAPTOOLS V2.
Create capatoolsV2 database
modify login,password and dbname in db.php 
and execute in order to rebase your BDD to the current version.

Ligne de commande pour initialiser un nouveau dépôt
````
composer install
php yii migrate
````


Commande utile :
````
php yii load-user -f=XXXX 
````
Cette commande permet de charger les utilisateur automatiquement
avec XXX un fichier csv identique au fichier ListeUtilisateur

