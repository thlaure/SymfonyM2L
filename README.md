# SymfonyM2L

### Projet de deuxième année de BTS SIO option SLAM
Réalisé dans le cadre des PPE qui sera à présenter lors de l'épreuve E6.

Membres de l'équipe :
* Léo ESPEU
* Mehdi BENBAHRI
* Thomas LAURE

### Getting started
Pour lancer l'application :
1. Ouvrir Powershell
2. Se déplacer à la racine du projet à l'aide de la commnde *__cd__*
3. Une fois à la racine, lancer la commande suivante : *__php ./bin/console server:run__*
4. Attendre que le message *__[OK] Server listening on http://127.0.0.1:8000__* s'affiche
5. Aller dans votre navigateur et saisir l'URL suivante : *__localhost:8000/avis__*
6. Le formulaire devrait s'afficher !

### Présentation de l'application web
__Existant :__  
Pour la saisie des avis sur les ateliers, il y a une fiche imprimées sur laquelle il y a 4 
catégories de cases à cocher :
* Très satisfait
* Satisfait
* Moyennement satisfait
* Pas du tout satisfait

Inconvénients :
* Plus long pour faire des statistiques
* Probabilité d'erreur plus haute
* Les participants doivent attendre leur tour pour saisir leur avis
* Support non pérenne (le papier s'abime facilement)
* Evolutivité très restreinte
* Stockage

__Partie à développer :__  
Le but est de développer une application web PHP (Symfony 4) permettant à plusieurs personnes
de saisir simultanément leur avis sur les ateliers auxquels ils ont participé.  
Les avis sont stockés dans une base de données Oracle et sont exploités par une application 
de type client riche en C# qui affichera les graphiques de ces statistiques.

__Possibilités d'évolution :__  
Dans le mail d'inscription, envoi d'un code unique à chaque participant leur permettant de se
connecter à l'application web.  
Ajout d'un contrôle liant l'atelier au code utilisateur afin que le participant ne puisse
saisir qu'une seule fois son avis pour éviter de fausser les résultats.