#################Configuration EasyPHP##############################
1. Ouvrir le fichier  php.ini et appliquer les modifications suivantes :
post_max_size = 110M 
upload_max_filesize = 110M
max_execution_time = 1000
memory_limit = 128M 
2. Enregistrer  php.ini et quitter 
3. Ouvrir le fichier  my.ini et appliquer les modifications suivantes :
max_allowed_packet = 110M
4. Enregistrer my.ini et quitter 
5. Restart Your server

################# I - Implémentation du script######################
Un script est développer avec le langauege PHP (Json_to_Mysql.php) 
dont j'ai utulisé : 
Apache 2.4.25
PHP 5.6.30 
MySQL 5.7.17

################# II - Implémentation des endpoints##################
Pour ces deux endpoints , merci de voir le fichier :
class/products.php


################# III - La couche applicative de cache,################
Voir la page le fichier view/fiche_details.php a partir de la ligne 
 [87 .. 100] 
En fête, j'ai appliquer la couche sur la requete de récuperation 
des catégories 
et le fichier cache/file.cache.php
################# IV - Implémentation des vues #########################
Voir les deux fichier :
 view/index              ==> Vue globale
 view/fiche_details.php  ==> Vue détaillée
################# Installation  ####################################### 
Pour installer l'application , il suffit juste de déplacer le dosssier 
"php-rest-api-product.rar" dans le racine de votre serveur web. "# LemjiD-Web" 
