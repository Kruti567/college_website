<?php
// PHP form processing at the top
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name    = htmlspecialchars(trim($_POST['name']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $to      = "nirmiti@nirmitidegreecollege.in"; // <-- Replace with your email
    $subject = "New Enquiry from Website";
    $body    = "You have received a new enquiry:\n\n".
               "Name: $name\n".
               "Phone: $phone\n".
               "Email: $email\n".
               "Message:\n$message\n";

    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        $success = "Thank you! Your message has been sent successfully.";
    } else {
        $error = "Sorry, something went wrong. Unable to send email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nirmiti College | Contact Us</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/contact.css" />
    <link rel="shortcut icon" type="images" href="images/logonimriti.PNG" />

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11228150970"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'AW-11228150970');
        gtag('config', 'AW-11228150970/I9a7CLjl-bIYELr5_-kp', {
            'phone_conversion_number': '9969594076'
        });
    </script>
</head>

<body>

    <!-- header section starts  -->
    <?php include "common/header.php"; ?>
    <!-- header section ends -->

    <section class="heading">
        <h3>Enquiry Here</h3>
        <p> <a href="index.php">home >></a> Enquiry </p>
    </section>

    <div class="container">
        <span class="big-circle"></span>
        <img src="img/shape.png" class="square" alt="" />
        <div class="form">
            <div class="contact-info">
                <h3 class="title">Let's get in touch</h3>
                <p class="text">Nirmiti College.</p>

                <div class="info">
                    <div class="information">
                        <img src="img/location.png" class="icon" alt="" />
                        <p>GEMS Educational Campus, Mahajan Banquet Hall, Kanakiya Road, Miraroad East</p>
                    </div>
                    <div class="information">
                        <img src="img/email.png" class="icon" alt="" />
                        <p>nirmiti@nirmitidegreecollege.in</p>
                    </div>
                    <div class="information">
                        <img src="img/phone.png" class="icon" alt="" />
                        <p>9969594076</p>
                    </div>
                </div>

                <div class="social-media">
                    <p>Connect with us :</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <span class="circle one"></span>
                <span class="circle two"></span>

                <?php
                if (isset($success)) {
                    echo '<p class="message success" style="color: green; text-align:center; font-weight:bold;">' . $success . '</p>';
                } elseif (isset($error)) {
                    echo '<p class="message error" style="color: red; text-align:center; font-weight:bold;">' . $error . '</p>';
                }
                ?>

                <form action="" method="post" autocomplete="off">
                    <h3 class="title">Contact us</h3>

                    <div class="input-container">
                        <input type="text" name="name" class="input" required />
                        <label for="">Name</label>
                        <span>Name</span>
                    </div>
                    <div class="input-container">
                        <input type="email" name="email" class="input" required />
                        <label for="">Email</label>
                        <span>Email</span>
                    </div>
                    <div class="input-container">
                        <input type="tel" name="phone" class="input" required />
                        <label for="">Phone</label>
                        <span>Phone</span>
                    </div>
                    <div class="input-container textarea">
                        <textarea name="message" class="input" required></textarea>
                        <label for="">Message</label>
                        <span>Message</span>
                    </div>
                    <input type="submit" name="submit" value="Send" class="btn" />
                </form>
            </div>
        </div>
    </div>

    <?php include "common/footer.php"; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
