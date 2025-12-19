# MiniProjet2A-EventReservation-NomEquipe

Description:
Application web de gestion et réservation d'événements (MVC PHP + MySQL).

Technos:
- PHP 7.4+
- MySQL
- HTML/CSS/JS
- Git / GitHub

Installation rapide:
1. Cloner le repo.
2. Importer `db/schema.sql` dans MySQL.
3. Configurer `config/database.php` (DB_HOST, DB_NAME, DB_USER, DB_PASS).
4. Placer le dossier web root sur `public/` (ex: /var/www/html/MiniEvent/public).
5. Créer un admin ou utiliser un script pour hasher un mot de passe:
   ```php
   <?php echo password_hash('admin123', PASSWORD_DEFAULT); ?>

Ouvrir /?route=home.
Branches recommandées:
main, dev, feature/frontend, feature/backend
Membres:
Ranim Rtimi
Nour Louhichi
