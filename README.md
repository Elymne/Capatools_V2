# CAPTOOLS V2.

## Première étape :

Créer une base de données pour le projet capatools_v2 (le nom de la base importe peu).

## Deuxième étape :

Lancer la commande `composer update` pour installer les dépendances du projet. Si composer n'est pas installé, vous pouvez utiliser le fichier composer.phar pour installer les dépendances en lançant la commande `php composer.phar update`.

## Troisième étape :

Créer le fichier db.php dans le dossier config de l'application et configurer la connexion à la bdd.
Exemple du contenu d'un fichier db.php :

```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=dbname;port=3306',
    'username' => 'username',
    'password' => 'password',
    'charset' => 'utf8',
];
```

## Quatrième étape :

Lancer la commande `php yii migrate` pour générer les bases de données par rapport aux modèles créés dans le dossier <br> migrations </br>

# Déploiement en pré-production.

## Pour déployer en pré-prod, il faut faire attention à plusieurs choses :

### Il n'y a pas de déploiement automatique géré avec gitlab,

Il faut tout faire à la main avec un logiciel (fillezilla ou autre logiciel de transport ftp).

### Pas de terminal

Il faut donc mettre à jour la structure de la base de données distante avec un fichier sql exporté de la bdd locale (si des changements ont eu lieu structurellement).

### Ce qu'il ne faut pas ajouter en serveur de pré-prod :

Le fichier db.php dans le dossier config.
Les dossiers en rapport avec l'ide que vous utilisez (.vscode, .intt ect).
Le dossier migrations (il ne sert à rien en pré-prod).
Le fichier assignements.php du dossier rbac (qui correspond à l'assignement des rôles à chaque users).
Si aucune nouvelle dépendance n'a été installé ou mise à jour, ne pas ajouter le dossier vendor.
Le dossier web/assets (le contenu du dossier est généré automatiquement par Yii).
Le contenu du dossier uploads (qui contiendra les fichiers pdf et xsl).

# Git

On utilise la método d'Atlasian pour gérer l'historique Git.
Pour faire simple, on a trois branches principales : master (prod), recette (préprod), develop (développement).

A chaque nouvelle feature à ajouter, on créer une nouvelle branche (exemple : feat/gestion-vacances) pour développer la fonctionnalité.
Une fois que la fonctionnalité est complète, on regarde si la branche develop à évolué, si oui, on rebase la branche develop sur la branche de feature.
Ensuite, on merge la branche de feature sur la branche develop.
(Ca à l'air inutile comme ça, mais c'est juste pour une question d'affichage de l'historique git).

On fait la même pour la branche recette, merge de develop sur la branche recette.

Pour les fix, on peut totalement commit sur la branche develop directement. Même pour les petites features d'ailleurs. (C'est pas du tout strict :p)

Voir : Gitflow Atlassian sur google. (Bonnes images pour représenter visuellement l'utilité de cette méthodologie quant à l'historique GIT).

# Autres

### Commandes utiles :

```
php yii load-user -f=XXXX
```

Cette commande permet de charger les utilisateur automatiquement
avec XXX un fichier csv identique au fichier ListeUtilisateur
