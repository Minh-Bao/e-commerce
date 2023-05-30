## Fizzup test

Ce projet a été fait avec Laravel Inertia et VueJs3 pour le front . 
La version PHP est la 8.2.5 


### Installation du projet

- Cloner le projet   

```bash
https://github.com/Minh-Bao/fizzup_test.git
```

- Installer les dependances composer  

```bash
composer install
```

- Installer les dependances npm

```bash
npm install
```

- Puis lancer les migrations et seeder pour les fausses données (relancer la même commandes pour réinitialiser les données)  

```bash
php artisan migrate:fresh --seed
```

- Puis build les asset npm ou bien dev pour modifier en direct les fichier vuejs  

```bash
npm run build
npm run dev
```

- Puis lancer le serveur php laravel   

```bash
php artisan serve
```

### Informations diverses
- Se rendre à l'adresse http://localhost:8000 pour visiter le site  
- Le projet et le fichier composer.json sont set à php8.2.5  
- Vous pouvez vous connecter en récupérant un mail dans la table user et le mot de passe pour tous les utilisateurs est "password"  
- Lorsque l'on crée un avis on peut mettre un alias et nouveau mail. Mais par défaut lorsque l'on se connecte et que l'on ne rempli pas les champs alias et email. Le username et le mail de l'inscription seront affiché d'ofice.
- Aussi lorsque l'on n'est pas connecté les champs alias et email sont obligatoires. 
 








