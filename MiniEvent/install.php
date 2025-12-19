<?php
// install.php
// Script d'installation pour MiniEvent
// Placez ce fichier à la racine du projet (ex: /var/www/html/MiniEvent/install.php)
// IMPORTANT: Supprimez ce fichier après installation pour des raisons de sécurité.

ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- CONFIGURATION ---
// Ajustez si nécessaire
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'minievent');

// Admin par défaut (changez le mot de passe avant d'exécuter si nécessaire)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123'); // changez ce mot de passe !

// Événements exemples (facultatif)
$sampleEvents = [
    [
        'title' => 'Conférence : Développement Web',
        'description' => 'Une conférence sur les bonnes pratiques en développement web.',
        'date' => date('Y-m-d H:i:s', strtotime('+7 days 10:00')),
        'location' => 'Salle A - Université',
        'seats' => 100,
        'image' => ''
    ],
    [
        'title' => 'Atelier PHP & MySQL',
        'description' => 'Atelier pratique pour apprendre PHP et MySQL en mode projet.',
        'date' => date('Y-m-d H:i:s', strtotime('+14 days 09:30')),
        'location' => 'Lab informatique',
        'seats' => 30,
        'image' => ''
    ]
];

// --- FIN CONFIGURATION ---

echo "<h1>Installation MiniEvent</h1>";

try {
    // Connexion sans base (pour créer la base si besoin)
    $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ]);
    echo "<p>Connexion au serveur MySQL : <strong>OK</strong></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur de connexion MySQL : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Créer la base si nécessaire
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "<p>Base de données `" . DB_NAME . "` : <strong>créée ou déjà existante</strong></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur création base : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Reconnecter sur la base créée
try {
    $dsnDb = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $db = new PDO($dsnDb, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p>Connexion à la base `" . DB_NAME . "` : <strong>OK</strong></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur connexion base : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// SQL de création des tables
$sql = "
CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `date` DATETIME,
  `location` VARCHAR(255),
  `seats` INT DEFAULT 0,
  `image` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_res_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    // Exécuter les créations (utiliser exec pour exécuter plusieurs statements)
    $db->exec($sql);
    echo "<p>Tables : <strong>créées ou déjà existantes</strong></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur création tables : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Insérer l'admin par défaut (si non présent)
try {
    $stmt = $db->prepare("SELECT COUNT(*) as c FROM admin WHERE username = :u");
    $stmt->execute(['u' => ADMIN_USERNAME]);
    $row = $stmt->fetch();
    if ($row && $row['c'] == 0) {
        $hash = password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT);
        $ins = $db->prepare("INSERT INTO admin (username, password_hash) VALUES (:u, :p)");
        $ins->execute(['u' => ADMIN_USERNAME, 'p' => $hash]);
        echo "<p>Compte admin créé : <strong>" . htmlspecialchars(ADMIN_USERNAME) . "</strong> (mot de passe défini via ADMIN_PASSWORD dans install.php)</p>";
    } else {
        echo "<p>Compte admin '" . htmlspecialchars(ADMIN_USERNAME) . "' existe déjà — <strong>aucune insertion</strong></p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur insert admin : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Insérer quelques événements exemples (si table events vide)
try {
    $stmt = $db->query("SELECT COUNT(*) as c FROM events");
    $c = $stmt->fetch();
    if ($c && $c['c'] == 0) {
        $ins = $db->prepare("INSERT INTO events (title, description, date, location, seats, image) VALUES (:title, :description, :date, :location, :seats, :image)");
        foreach ($sampleEvents as $ev) {
            $ins->execute([
                'title' => $ev['title'],
                'description' => $ev['description'],
                'date' => $ev['date'],
                'location' => $ev['location'],
                'seats' => $ev['seats'],
                'image' => $ev['image'],
            ]);
        }
        echo "<p>Événements exemples insérés.</p>";
    } else {
        echo "<p>Table events non vide — pas d'insertion d'exemples.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Erreur insertion événements exemples : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

echo "<h3>Terminé</h3>";
echo "<p>Supprimez le fichier <code>install.php</code> du serveur après vérification pour plus de sécurité.</p>";
echo "<p><a href=\"public/index.php\">Aller à l'application (point d'entrée public/index.php)</a></p>";
