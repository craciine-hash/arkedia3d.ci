<?php
/*
    SCRIPT DE TRAITEMENT DU FORMULAIRE ARKEDIA 3D (VERSION PRO)
    Ce fichier reçoit les données du formulaire et envoie l'email.
*/

// --- CONFIGURATION ---
// C'est ici qu'on définit qui reçoit les mails
$to_email = 'contact@arkedia3d.ci'; // Ton adresse pro principale
$backup_email = 'arkedia3d@gmail.com'; // Ton Gmail en copie de sécurité (CORRIGÉ)
$subject = '🚀 Nouveau Prospect via le Site Web !'; // Le titre du mail que tu vas recevoir

// --- TRAITEMENT ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. On nettoie les données reçues pour éviter les virus/hacks
    $nom = htmlspecialchars($_POST['nom']);
    $entreprise = htmlspecialchars($_POST['entreprise']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $projet_type = isset($_POST['type_projet']) ? htmlspecialchars($_POST['type_projet']) : 'Non spécifié';
    $localisation = htmlspecialchars($_POST['localisation']);
    $message = nl2br(htmlspecialchars($_POST['message'])); // Conserve les sauts de ligne

    // 2. On construit le joli email HTML que tu vas recevoir
    $email_content = "
    <html>
    <head>
        <title>Nouveau Contact Arkedia 3D</title>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .header { background-color: #0A192F; color: #fff; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; }
            .label { font-weight: bold; color: #00F5FF; text-transform: uppercase; font-size: 0.8em;}
            p { margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Nouveau Prospect !</h2>
        </div>
        <div class='content'>
            <p><span class='label'>Nom du client :</span><br> $nom</p>
            <p><span class='label'>Entreprise :</span><br> $entreprise</p>
            <p><span class='label'>Téléphone :</span><br> <a href='tel:$telephone'>$telephone</a></p>
            <p><span class='label'>Type de projet :</span><br> $projet_type</p>
            <p><span class='label'>Localisation :</span><br> $localisation</p>
            <hr>
            <p><span class='label'>Message :</span><br>$message</p>
        </div>
        <p style='font-size:0.8em; color:#777; text-align:center;'>Email envoyé depuis www.arkedia3d.ci</p>
    </body>
    </html>
    ";

    // 3. On prépare l'envoi technique
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Site Arkedia <no-reply@arkedia3d.ci>" . "\r\n"; // L'expéditeur officiel
    $headers .= "Reply-To: $backup_email" . "\r\n"; 
    $headers .= "Bcc: $backup_email" . "\r\n"; // La copie cachée vers ton Gmail

    // 4. On envoie !
    if(mail($to_email, $subject, $email_content, $headers)) {
        // Si ça marche, on affiche un message de succès et on redirige vers l'accueil
        echo "<script>alert('✅ Merci $nom ! Votre demande a bien été envoyée. L\'équipe Arkedia vous recontacte très vite.'); window.location.href='index.html';</script>";
    } else {
        // Si ça rate
        echo "<script>alert('❌ Erreur technique. Merci de nous contacter directement sur WhatsApp.'); window.location.href='index.html';</script>";
    }
} else {
    // Si quelqu'un essaie d'ouvrir ce fichier sans passer par le formulaire
    header("Location: index.html");
    exit();
}
?>