<?php

// connection with database
$conn = mysqli_connect("localhost", "root", "", "mining-db");

// check connection
if (!$conn) {
    die("not connected");
}

// Get settings (logo, title)
$settings_query = mysqli_query($conn, "SELECT * FROM `settings` LIMIT 1");
$settings = mysqli_fetch_assoc($settings_query);

// Create contacts table if it doesn't exist
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `contacts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(200) NOT NULL,
    `message` TEXT NOT NULL,
    `created-at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// CONTACT FORM LOGIC
$success_msg = "";
$error_msg = "";

if (isset($_POST['contact_btn'])) {
    $name    = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email   = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if ($name == "" || $email == "" || $subject == "" || $message == "") {
        $error_msg = "Please fill in all fields.";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO `contacts` (`name`, `email`, `subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')");
        if ($insert) {
            $success_msg = "Your message has been sent successfully! We will get back to you soon.";
        } else {
            $error_msg = "Something went wrong. Please try again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Mining Dashboard</title>
    <meta name="description" content="Contact the Mining Dashboard support team. We are available 24/7 to help you with any queries or issues.">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f5;
        }

        /* HEADER */
        .header {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
            color: #fff;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
        }

        .nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 15px;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        /* PAGE HEADER BANNER */
        .page-banner {
            background: linear-gradient(135deg, #0b3d2e, #1e7d57);
            color: #fff;
            text-align: center;
            padding: 60px 20px;
        }

        .page-banner h1 {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .page-banner p {
            font-size: 16px;
            color: #c8e6c9;
        }

        /* MAIN CONTACT SECTION */
        .contact-section {
            display: flex;
            gap: 30px;
            padding: 50px 40px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* CONTACT FORM BOX */
        .contact-form-box {
            flex: 2;
            min-width: 300px;
            background: #fff;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .contact-form-box h2 {
            color: #0b3d2e;
            font-size: 24px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-form-box h2 i {
            color: #1e7d57;
        }

        .form-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #555;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 13px 15px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
            color: #333;
            background: #f9f9f9;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #0b3d2e;
            background: #fff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 140px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, #0b3d2e, #1e7d57);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(11, 61, 46, 0.3);
        }

        /* ALERT MESSAGES */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        /* CONTACT INFO BOX */
        .contact-info-box {
            flex: 1;
            min-width: 260px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0b3d2e, #1e7d57);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-text h4 {
            color: #0b3d2e;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .info-text p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        /* SOCIAL CARD */
        .social-card {
            background: linear-gradient(135deg, #0b3d2e, #1e7d57);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            color: #fff;
        }

        .social-card h4 {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons a {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
        }

        /* FOOTER */
        .footer {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
            color: #fff;
            padding: 30px 40px;
            margin-top: 30px;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-left {
            max-width: 250px;
        }

        .footer-logo {
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .footer-links h4,
        .footer-contact h4 {
            margin-bottom: 8px;
        }

        .footer-links p,
        .footer-contact p {
            font-size: 13px;
            margin: 3px 0;
            color: #ddd;
        }

        .footer-icons {
            margin-top: 8px;
        }

        .footer-icons i {
            margin-right: 10px;
            cursor: pointer;
        }

        @media(max-width: 768px) {
            .contact-section {
                padding: 30px 20px;
            }

            .page-banner h1 {
                font-size: 28px;
            }

            .form-row {
                flex-direction: column;
            }

            .header {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <i class="fa-solid fa-c"></i>
            <?php if ($settings && $settings['logo-path']): ?>
                <img src="<?php echo $settings['logo-path']; ?>" alt="" style="width:40px; height:40px;">
            <?php endif; ?>
            <?php echo ($settings) ? $settings['tittle'] : 'DashBoard'; ?>
        </div>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="contactus.php">Contact Us</a>
        </div>
    </div>

    <!-- PAGE BANNER -->
    <div class="page-banner">
        <h1><i class="fa-solid fa-headset" style="margin-right:12px;"></i>Contact Us</h1>
        <p>We are available 24/7 — Send us your message and we'll reply as soon as possible.</p>
    </div>

    <!-- CONTACT SECTION -->
    <div class="contact-section">

        <!-- CONTACT FORM -->
        <div class="contact-form-box">
            <h2><i class="fa-solid fa-paper-plane"></i> Send Us a Message</h2>

            <?php if ($success_msg != ""): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <?php echo $success_msg; ?>
                </div>
            <?php endif; ?>

            <?php if ($error_msg != ""): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name">Your Name</label>
                        <input type="text" id="contact-name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Your Email</label>
                        <input type="email" id="contact-email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact-subject">Subject</label>
                    <input type="text" id="contact-subject" name="subject" placeholder="What is your message about?" required>
                </div>

                <div class="form-group">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" name="contact_btn" class="btn-submit">
                    <i class="fa-solid fa-paper-plane" style="margin-right:8px;"></i> Send Message
                </button>

            </form>
        </div>

        <!-- CONTACT INFO -->
        <div class="contact-info-box">

            <div class="info-card">
                <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                <div class="info-text">
                    <h4>Email Us</h4>
                    <p>support@dashboard.com</p>
                    <p>admin@dashboard.com</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
                <div class="info-text">
                    <h4>WhatsApp</h4>
                    <p>+92 300 1234567</p>
                    <p>Available 24/7</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon"><i class="fa-brands fa-telegram"></i></div>
                <div class="info-text">
                    <h4>Telegram</h4>
                    <p>@DashBoardSupport</p>
                    <p>Fast response guaranteed</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="info-text">
                    <h4>Working Hours</h4>
                    <p>Monday – Sunday</p>
                    <p>24 Hours / 7 Days</p>
                </div>
            </div>

            <div class="social-card">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-telegram"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-container">

            <div class="footer-left">
                <div class="footer-logo">
                    <i class="fa-solid fa-c"></i> DashBoard
                </div>
                <p>© 2025 DashBoard. All Rights Reserved.</p>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <p>Home</p>
                <p>About Us</p>
                <p>FAQ</p>
                <p>Terms & Conditions</p>
            </div>

            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p>Email: support@dashboard.com</p>
                <p>WhatsApp: +92 300 1234567</p>
                <div class="footer-icons">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-telegram"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                    <i class="fa-brands fa-youtube"></i>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
