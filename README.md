# Développement d’un Système d’Authentification Sécurisé
L'authentification des utilisateurs en développement web est utilisée pour autoriser et restreindre l'accès des utilisateurs à certaines pages d'une application web.
**Système d'enregistrement**

# db.php– Connexion entre les Fichiers PHP et la Base de Données
Le fichier db.php est utilisé pour établir la connexion entre l'application PHP et la base de données MySQL. Il est inclus dans les autres fichiers pour centraliser la configuration de la connexion.

``<?php
    $dsn = 'mysql:host=localhost:3308;dbname=project;charset=utf8mb4';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>``

# hackathon.sql – Structure de la Base de Données

Le fichier hackathon.sql contient la structure de la base de données utilisée pour stocker les utilisateurs dans un tableau "users".

``CREATE DATABASE IF NOT EXISTS project;

USE project;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);``

# register.php – Interface d'Enregistrement : Conception Intuitive et Sécurisée

![Logo](assets/images/POLOS.svg)


Ce fichier permet à un nouvel utilisateur de s'inscrire via un formulaire comprenant : nom d'utilisateur, email, mot de passe et confirmation. Les données sont validées côté serveur et client.

register.php – Validation et Sécurité : Prévention des Risques dès l'Inscription
Image description

En cas d'erreurs (format d’email invalide, mot de passe faible, confirmation erronée…), des messages clairs s’affichent pour guider l’utilisateur.

login.php – Page de Connexion : Accès Sécurisé et Contrôle des Sessions
Image description

Ce fichier vérifie les informations entrées par l’utilisateur en les comparant à celles de la base de données. En cas de correspondance, une session est créée. Sinon, un message d’erreur discret est affiché.

dashboard.php – Accès Sécurisé au Tableau de Bord : Protection des Données Utilisateur
Image description

Une fois connecté, l'utilisateur est redirigé vers son tableau de bord personnel. Le fichier dashboard.php vérifie si une session valide existe, empêchant tout accès non autorisé.

logout.php – Déconnexion Sécurisée de l’Utilisateur
Ce fichier permet à l’utilisateur de se déconnecter proprement. Il détruit la session active et redirige vers la page de connexion.

<?php
    session_start();

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
?>
Conclusion
Le projet repose sur des fichiers clairs et bien organisés (register.php, login.php, dashboard.php, logout.php), reliés à une base MySQL via db.php. Il offre une solution complète d’authentification avec des pratiques de sécurité robustes. Ce système constitue une base fiable pour tout site web nécessitant une gestion d’accès utilisateur.
