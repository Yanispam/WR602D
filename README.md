# WR602D

Installation

Cloner le dépôt.

git clone https://github.com/Yanispam/WR602D.git

Installer les dépendances.

composer install

Configurer la connexion à la base de données dans le fichier .env.

Exécuter les migrations de base de données.

php bin/console doctrine:migrations:migrate
