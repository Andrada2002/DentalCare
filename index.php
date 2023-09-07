<?php
// Inițializează afișarea erorilor
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectare la baza de date MySQL folosind PDO
try {
    $conn = new PDO('mysql:host=localhost;dbname=contact_db', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $date = $_POST['date'];

    // Verificați dacă toate câmpurile sunt completate
    if (!empty($name) && !empty($email) && !empty($number) && !empty($date)) {
        // Inserează datele în tabela 'contact_form' folosind declarații pregătite
        $stmt = $conn->prepare("INSERT INTO `contact_form` (name, email, number, date) VALUES (?, ?, ?, ?)");

        // Legați parametrii la declarația pregătită
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $number);
        $stmt->bindParam(4, $date);

        // Executați declarația pregătită
        if ($stmt->execute()) {
            $message[] = 'Appointment made successfully';
        } else {
            $message[] = 'Appointment failed';
        }
    } else {
        $message[] = 'All fields are required.';
    }
}

// Nu mai este nevoie să generați un ID unic manual pentru coloana 'id' aici

// Verificați dacă înregistrarea există deja în tabela 'messages'
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    $stmt = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ?");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $number);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $warning_msg[] = 'Appointment already sent!';
    } else {
        // Inserăm datele în tabela 'messages' folosind declarații pregătite
        $stmt = $conn->prepare("INSERT INTO `messages` (name, email, number, date) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $number);
        $stmt->bindParam(4, $date);
        
        if ($stmt->execute()) {
            $success_msg[] = 'Appointment Sent Successfully!';
        } else {
            $message[] = 'Appointment failed';
        }
    }
}
?>




}

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>DentalCare</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->

<header class="header fixed-top">

   <div class="container">

      <div class="row align-items-center justify-content-between">

         <a href="#home" class="logo">dental<span>Care.</span></a>

         <nav class="nav">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#reviews">reviews</a>
            <a href="#contact">contact</a>
         </nav>

         <a href="#contact" class="link-btn">make appointment</a>

         <div id="menu-btn" class="fas fa-bars-staggered"></div>

      </div>

   </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

   <div class="container">

      <div class="row min-vh-100 align-items-center">
         <div class="content text-center text-md-left">
            <h3>let us brighten your smile</h3>
            <p>dentalCare dental clinic is designed and built for you!<br>
             A dental clinic in a relaxing environment, equipped with the latest technologies.<br></p>
            <a href="#contact" class="link-btn">make appointment</a>
         </div>
      </div>

   </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

   <div class="container">

      <div class="row align-items-center">

         <div class="col-md-6 image">
            <img src="images/about-img.jpg" class="w-100 mb-5 mb-md-0" alt="">
         </div>

         <div class="col-md-6 content">
            <span>about us</span>
            <h3>True Healthcare For Your Family</h3>
            <p>A friendly team attentive to your needs, a team ready to give you a memorable dental experience.<br>
               We know your teeth are important and we try to treat them using balanced treatments based on your particular needs.<br>
               We are always looking for the optimal option between minimally invasive and a sustainable, successful result!<br></p>
            <a href="#contact" class="link-btn">make appointment</a>
         </div>

      </div>

   </div>

</section>

<!-- about section ends -->

<!-- services section starts  -->

<section class="services" id="services">

   <h1 class="heading">our services</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/icon-1.svg" alt="">
         <h3>Dental Appliances</h3>
         <p>Orthodontic braces correct masticatory or phonetic problems while contributing to the long-lasting beauty of the teeth.<br>
             After a consultation, the dentalCare clinic's orthodontist can suggest other treatments before using the dental appliance.</p>
      </div>

      <div class="box">
         <img src="images/icon-2.svg" alt="">
         <h3>Endodontic Treatments</h3>
         <p>The legendary Carl Zeiss dental microscope allows the visualization of details and fine structures that would otherwise be impossible to detect.<br> 
            Its use has increased the success rate of treatments to about 90%.</p>
      </div>

      <div class="box">
         <img src="images/icon-3.svg" alt="">
         <h3>Laser Treatments</h3>
         <p>We are among the few clinics in the west of the country equipped with the Waterlase iPlus laser from Biolase,<br>
             a revolutionary solution for dental treatments without discomfort.<br>
             The Waterlase laser eliminates the need to use local anesthesia for an approximately 20-minute intervention on sensitive teeth, <br>
             ensuring the necessary comfort for all patients.<br></p>
      </div>

      <div class="box">
         <img src="images/icon-4.svg" alt="">
         <h3>Parodontal Treatments</h3>
         <p>Periodontal disease (periodontosis) is successfully treated in our clinic using the Waterlase dental laser.<br>
             Find out what each one means, what are the symptoms of periodontitis and what you should do if you suffer from this dental condition.<br></p>
      </div>

      <div class="box">
         <img src="images/icon-5.svg" alt="">
         <h3>Dental Veneers</h3>
         <p>Ceramic dental veneers give the teeth a special appearance, thanks to the similarity with tooth enamel: their color,<br> 
            translucency and shine faithfully copy the structure and aesthetics of natural teeth. The use of classic ceramic veneers requires a fine,<br>
             minimally invasive grinding of the tooth enamel for definitive cementation.</p>
      </div>

      <div class="box">
         <img src="images/icon-6.svg" alt="">
         <h3>Teeth Whitening</h3>
         <p>Do you want to regain the natural whiteness of your teeth and even enhance them in just 60 minutes? Thanks to new technologies, <br>
            it is now easier than ever. Teeth whitening is the most recommended dental aesthetic procedure, which,<br>
             thanks to new procedures such as laser treatments and photo-activation, has turned into a non-invasive procedure</p>
      </div>

   </div>

</section>

<!-- services section ends -->

<!-- process section starts  -->

<section class="process">

   <h1 class="heading">work process</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/process-1.png" alt="">
         <h3>Laser Treatments</h3>
         <p>Elimină durerea cu până la 85%<br>
            Elimină sângerarea și traumatismele dinților asociate cu freza dentară<br>
            Minimalizează riscul de infecție<br>
            Facilitează o cicatrizare rapidă<br>
            Elimină durerile post-operatorii<br>
            Oferă tratamente dentare silențioase și mult mai rapide<br>
            Elimină anxietatea care te ține departe de stomatolog!</p>
      </div>

      <div class="box">
         <img src="images/process-2.png" alt="">
         <h3>Teeth Whitening</h3>
         <p>Albirea dentară cu lampa Beyond funcționează prin activarea gelului de albire cu ajutorul unei surse de lumină albastră puternică,<br> 
            dotata cu un sistem de filtrare avansată. Acesta evită sensibilizarea dinților, asigură protecția danturii și confortul în timpul <br>
            și după finalizarea ședintei de albire a dinților.</p>
      </div>

      <div class="box">
         <img src="images/process-3.png" alt="">
         <h3>Parodontal tratamente</h3>
         <p>Since periodontal diseases have a microbial etiology, in the prevention and treatment of these diseases, <br>
            we are fighting a continuous battle with the bacterial biofilm that forms on the dental surfaces.<br>
            At the same time, periodic checks are recommended and, whenever necessary, <br>
            professional hygiene in the cabinet, including descaling and air-flow.<br>
            This protocol ensures the health of the gum, maintaining its light pink color, firm appearance and absence of bleeding.</p>
      </div>

   </div>

</section>

<!-- process section ends -->

<!-- reviews section starts  -->

<section class="reviews" id="reviews">

   <h1 class="heading"> satisfied clients </h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>The experience with Premium Dental was one of the most pleasant and gave me great satisfaction.<br>
             Basically, the team of doctors and nurses worked wonders.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
         <span>satisfied client</span>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>Professionalism, transparency, passion and a lot of dedication, that's what I found at dentalCare.<br> 
            Thank you from the bottom of my heart to the entire team for your care</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Simona Hope</h3>
         <span>satisfied client</span>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>An extremely professional team with advanced equipment. 
            I especially recommend the teeth whitening treatment</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>James Oster</h3>
         <span>satisfied client</span>
      </div>

   </div>

</section>

<!-- reviews section ends -->

<!-- contact section starts  -->

<section class="contact" id="contact">

   <h1 class="heading">make appointment</h1>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <?php 
         if(isset($message)){
            foreach($message as $message){
               echo '<p class="message">'.$message.'</p>';
            }
         }
      ?>
      <span>your name :</span>
      <input type="text" name="name" placeholder="enter your name" class="box" required>
      <span>your email :</span>
      <input type="email" name="email" placeholder="enter your email" class="box" required>
      <span>your number :</span>
      <input type="number" name="number" placeholder="enter your number" class="box" required max="9999999999" min="0" maxlength="10">
      <span>appointment date :</span>
      <input type="datetime-local" name="date" class="box" required>
      <input type="submit" value="make appointment" name="submit" class="link-btn">
   </form>  

</section>

<!-- contact section ends -->

<!-- footer section starts  -->

<section class="footer">

   <div class="box-container container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>phone number</h3>
         <p>+123-456-7890</p>
         <p>+111-222-3333</p>
      </div>
      
      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>our address</h3>
         <p>Timisoara, Romania - 100100</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>08:00am to 20:00pm</p>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email address</h3>
         <p>DentalCare@yahoo.com</p>
         <p>DentalCareClinic@gmail.com</p>
      </div>

   </div>

   <div class="credit"> &copy; copyright @ <?php echo date('Y'); ?> by <span>myself</span>  </div>

</section>

<!-- footer section ends -->








<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alert.php'; ?>


</body>
</html>