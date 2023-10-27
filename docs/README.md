# TIC & TAC : BIZNUTZ

Tic & Tac ont bien réfléchi dernièrement et ont décidé de se lancer ensemble dans une nouvelle aventure : **BizNutz**.

Après une cueillette fructueuse cette année, ils ont décidé d'ouvrir un commerce en ligne pour revendre leur stock en trop de noisettes aux locataires des forêts voisines.

Pour mener à bien leur projet, ils lancent une plateforme de e-commerce et se répartissent les tâches.
**Tac** s'occupe de l'application de gestion du stock et **Tic** s'occupe, quant à lui, du site marchand.

![tic et tac](1943-tic-tac-17.jpg)
{: .text-center }

En équipe de 2 développeurs, suivez les consignes en choisissant chacun votre rôle !  
Colonne de gauche, Tic et colonne de droite Tac.


Clonez ce dépôt grâce au lien donné ci-dessus ⬆ <a href="#input-clone"><i class="bi bi-code-slash"></i>&nbsp;Code</a>.
 {: .alert-info }

Effectuez ensuite les tâches suivantes :
- `cd workshop-php-api-simple-mvc`
- `composer install`
- Créer le fichier **db.php** à partir du fichier **db.php.dist** avec les identifiants de connexion pour PDO et la base de données **workshop_api_biznutz**

Important : TAC devra bien entrer les informations de sa base de données dans ce fichier mais TIC pourra laisser les informations telles quelles.
{: .alert-warning }

- Lancer la commande `php migration.php`
- Enfin, démarrer le serveur PHP
```bash
php -S localhost:8000 -t public
```

## 👀 Tic
Sois attentif à ce que fait **Tac** et aide-le si besoin.

## Tac
### Création de la table *nut* en base de données
Tac enregistre l'état des stocks dans sa base de données **workshop_api_biznutz**.  

Pour effectuer les deux points suivants, tu peux utiliser ton terminal ou écrire les requêtes dans le fichier **database.sql**. Il suffira alors de lancer la commande `php migration.php` pour les exécuter.
{: .alert-info }

1.  Crée une table **nut** avec les champs suivants :
    *   **id** : INT AUTO\_INCREMENT PRIMARY KEY
    *   **name** : VARCHAR(64) NOT NULL
    *   **stock** : INT NOT NULL DEFAULT 0
2.  Remplis cette table **_nut_** avec quelques données, par exemple :

| name     | stock |
|----------|:-----:|
| noix     |  150  |
| noisette |  180  |
| pistache |  100  |



### Création du Manager

Tac a besoin de récupérer la liste des stocks depuis la base afin de, plus tard, pouvoir l'envoyer à Tic.

1.  Crée un nouveau manager _NutManager_ qui sera lié à ta table _nut_.
2.  Pense à étendre la classe _AbstractManager_ et à ajouter la constante **TABLE**.

## Tic
### Aide Tac à créer son controller

Pour que tu puisses récupérer la liste des stocks, il va falloir que l'API de **Tac** te retourne ces données. 

À la différence d'une réponse HTTP standard, celle-ci ne retournera pas du code HTML, mais un objet JSON converti en *string* qui contiendra les stocks.  
Jette un oeil à la fonction [json\_encode](https://www.php.net/manual/en/function.json-encode.php) et aide **Tac** à réaliser cette tâche.


## Tac
### Prépare le simple-MVC en tant qu'API

Pour indiquer lors de la communication client / serveur le type de contenu qui sera envoyé, il faut ajouter des informations dans les headers.  
Comme l'application de TAC sera une API, il faut indiquer que ce sera du JSON qui transitera et autoriser les requêtes HTTP vers l'API.  
Afin de ne pas modifier le Framework SimpleMVC directement, tu vas créer un nouveau Contrôleur abstrait dans un fichier _src/Controller/AbstractAPIController.php_.  
Ajoute le code suivant dans ton fichier :  

```php
<?php

namespace App\Controller;

abstract class AbstractAPIController
{
    public function __construct()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: \*");
        header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
    }
}
```

### Création du Controller

1.  Crée un nouveau controller _NutController_.
2.  Plutôt qu'étendre _AbstractController_, ce contrôleur devra étendre _AbstractAPIController_.
3.  Crée une méthode _index()_ dans ce _NutController_.
4.  Dans cette méthode, récupère la liste des stocks à l'aide de ton _NutManager_ et fait en sorte qu'elle retourne cette liste sous forme de string contenant du JSON. (**Tic** va t'aider à réaliser cette partie).
5.  Ajoute au fichier **src/routes.php** la route `nuts` qui fera référence à ce _NutController_ et sa méthode _index()_.
6.  Teste ton code en te rendant à l'URL [http://localhost:8000/nuts](http://localhost:8000/nuts).  
    Tu devrais alors voir du texte correspondant à du JSON avec tes données de stocks à l'intérieur.  
    Par exemple : 
    ```json
    [{"id":"1","name":"noix","stock":"150"},{"id":"2","name":"noisette","stock":"180"},{"id":"3","name":"pistache","stock":"100"}]
    ```  
    Selon ton navigateur, le json peut même être joliement mis en forme pour plus de lisibilité.

# Tic & Tac
Pour continuer, il faut maintenant que le serveur de Tac soit accessible depuis un autre ordinateur.  
Il est possible de le faire en étant sur le même réseau wifi et en indiquant l'adresse ip locale en lançant le serveur.
Deux possibilités s'offrent à vous.

### Vous êtes sur le même réseau WIFI
Au démarrage du serveur PHP, Tac peut indiquer `0.0.0.0` à la place de `localhost`. La commande complète devient ainsi :
```bash
php -S 0.0.0.0:8000 -t public
```
Cela a pour effet d'ouvrir la connexion au serveur aux autres utilisateurs qui se trouvent sur le même réseau et grâce à l'IP locale de Tac sur ce même réseau.  
Pour connaître cette adresse IP, Tac doit se rendre dans les paramètres réseaux de son OS. Elle ressemble très souvent à une suite de nombre et de chiffres séparés par des points comme ceci : **192.168.0.11**. Cette adresse IP est d'ordinaire attribuée automatiquement par le router.  
Il suffit ensuite de se rendre avec le navigateur à l'adresse [http://192.168.0.11:8000](http://192.168.0.11:8000) pour se connecter au _localhost_ de l'utilisateur distant.

### Vous n'êtes pas sur le même réseau
Il existe des solutions en ligne permettant de créer des tunnels de connexion vers le port d'une machine et au travers de DNS. C'est le cas de [Ngrok](https://ngrok.com/), [Tunnelto](https://tunnelto.dev/) ou encore [Localhost.run](http://localhost.run/). Nous utiliserons ce dernier qui est très facile à prendre en main et ne nécessite aucune configuration particulière dans une utilisation limitée.
Pour ouvrir les connexions entrantes sur le port 8000 de ta machine, lance la commande suivante :
```bash
ssh -R 80:localhost:8000 nokey@localhost.run
```
Ton terminal te donne en retour une adresse du type [https://f0790c8ef263b1.lhr.life](https://f0790c8ef263b1.lhr.life).  Tu n'as plus qu'à communiquer cette adresse à Tic. Et voilà !


## Accède à l'API de Tac
**Tic** peut maintenant, avec un navigateur, tenter d'afficher la route **/nuts** de **Tac** pour vérifier que tout fonctionne via l'URL `https://xxxxxxx.lhr.life/nuts` ou  `http://xxx.xx.xx.xx./nuts` selon la méthode employée (remplacer les `xxx` par les valeurs précédemment obtenues).

## Surveille ton serveur
**Tac** jette un œil à son terminal pour voir ce qui se passe sur son serveur. Il constate qu'il a bien un `[200]: GET /nuts`.

## Récupération des stocks
**Tic** veut maintenant récupérer la liste des stocks, seulement voilà, la base de données est chez **Tac**. Il va donc falloir récupérer la liste en faisant appel à la route **/nuts** de **Tac**.

1.  Crée un nouveau manager _StockManager_.  
    Ce manager **ne devra pas** hériter de _AbstractManager_ car tu ne te connecteras pas à ta base de données. Tu n'auras donc pas besoin de déclarer la constante TABLE.
2.  Crée une méthode _getAll()_ dans ce manager.
3.  **Grâce aux instructions de Tac**, utilise la bibliothèque _HttpClient_ et sa méthode static `create()` et fais appel à l'URL de Tac (`https://xxxxxxx.lhr.life/nuts` ou  `http://xxx.xx.xx.xx./nuts`) pour récupérer les stocks.
4.  Ta méthode doit ensuite retourner la liste des stocks sous forme de tableau PHP (regarde du côté de la méthode _toArray()_ de l'objet _Response_ de HttpClient dans la documentation).

## 👀 Aide Tic à récupérer les stocks

Sois attentif à ce que fait 🐿 **Tic** et aide-le si besoin en t'appuyant sur les informations suivantes.

**http-client** est une bibliothèque permettant de faire des requêtes http vers une API externe.  
Cette bibliothèque est développée par **Symfony** mais comme souvent, elle peut être utilisée en standalone, c'est à dire en dehors du framework.  
Pour l'installer dans un projet, il suffit d'utiliser composer et la commande :  
```php
composer require symfony/http-client
```  
Ensuite, la [documentation](https://symfony.com/doc/current/http_client.html#basic-usage) explique comment l'utiliser.

Dans l'exemple de code, clique bien sur l'onglet `Standalone Use` pour voir un exemple d'utilisation en dehors de Symfony.
{: .alert-info }

## Affichage des stocks

Maintenant que tu as récupéré les stocks depuis l'application de **Tac**, il faut les afficher

1.  Modifie la méthode _index()_ du _HomeController_ afin qu'elle récupère les stocks à l'aide de ton _StockManager_ et sa méthode _getAll()_.
2.  Passe la liste des stocks en contexte à ta vue _Home/index.html.twig_, puis affiche les sous forme de tableau HTML.
3.  Lance un webserver local, si ce n'est pas déjà fait, et vérifie que la liste des stocks s'affiche correctement sur [http://localhost:8000/](http://localhost:8000/)

## 👀 Tac
Sois attentif à ce que fait **Tic** et aide-le si besoin.

# 👏 Bravo !  
Vous venez de réaliser votre première API et savez désormais comment la "consommer".
{: .text-center}


![](giphy-tic-tac.gif)
{: .text-center}

# 🌰 BONUS : aller plus loin...
Tic souhaite maintenant proposer une fonctionnalité d'achat sur son site.
Lorsqu'une personne achète une noix il faudra donc envoyer cette information à l'API de Tac pour qu'elle puisse mettre à jour le stock en base de données.

## 👀  Aide Tac à mettre à jour ses stocks
Sois attentif à ce que fait 🐿  Tac et aide-le si besoin.

## Mise à jour des stocks
Crée une méthode `decrementStock(int $id)` dans ton _NutManager_. Cette méthode exécutera une requête SQL qui devra décrémenter la quantité en stock de l'item dont l'ID est passé en paramètre.
1. Crée une méthode `buy()` dans ton _NutController_.
2. Cette méthode sera associée à la route **/nuts/buy**. Ajoute cette entrée à la liste des routes du fichier **src/routes.php**.
C'est cette méthode qui sera appelée en POST par Tic lorsqu'un utilisateur décidera d'acheter une noisette.
Vérifie que la méthode HTTP est bien POST :
```php
if ($_SERVER['REQUEST_METHOD'] === "POST") { 
    //...
} 
```
Puis, fais appel à la méthode `decrementStock($id)` de ton _NutManager_ pour mettre à jour le stock de l'item dont l'ID est passé en paramètre.

## Ajout de la fonctionnalité d'achat
1.  Ajoute un bouton-lien "acheter" sur chaque ligne de ton tableau HTML qui aura pour _href_ `/buy?id={id}` ("id" correspondant à l'ID de l'item).
2.  Si le stock est à zéro, afficher "Stock épuisé" au lieu du bouton "acheter".
3.  Crée une méthode `buy(int $id)` dans ton _HomeController_ (c'est cette méthode qui sera appelée au clic sur le bouton "Acheter".
4.  Pense à ajouter au tableau de **src/routes.php** la route _buy_ faisant référence à cette méthode.  
    ⚠️ Attention, elle reçoit un paramètre `$id` issu d'une requête `$_GET`.
5.  Crée une méthode `buy(int $id)` dans ton _StockManager_.  
    Grâce à _HttpClient_, cette méthode devra faire un `POST` sur la route de l'API de Tac : `http://xxx.xxx.xx.xxx/nuts/buy` avec l'`$id` en paramètre.  
    La [section "envoi de données"](https://symfony.com/doc/current/http_client.html#uploading-data) de la documentation t'aidera à comprendre comment structurer le corps de la requête `POST`.
6.  Dans la méthode `buy` de ton _HomeController_ :
    - Fais appel à la méthode `buy` de ton _StockManager_.
    - Redirige ensuite l'utilisateur sur `/`.  
        Si Tac a bien bossé, le stock de l'item en question sera alors décrémenté.

## 👀 Aide Tic à ajouter la fonctionalité d'achat sur son site
Sois attentif à ce que fait **Tic** et aide-le si besoin.


# À suivre 🌰🌰🌰