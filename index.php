<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nirmiti College | HOME</title>
    <link rel="shortcut icon" type="images" href="images/logo.jpg">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Slider Container */
        .slider-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        /* Slider Images */
        .slider-container img {
            width: 100%;
            height: 100%;
        }

        /* Slider Navigation */
        .slider-nav {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }

        /* Slider Navigation Dots */
        .slider-nav button {
            border: none;
            background-color: #bbb;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            cursor: pointer;
        }

        /* Active Dot */
        .slider-nav button.active {
            background-color: #555;
        }
       .marquee-container {
  display: flex;
}

/* Style the marquee */
.marquee {
  flex: 1;
  position: relative;
  overflow: hidden;
  white-space: nowrap;
}

/* Style the colored strip behind the text */
.marquee::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #f2c12e; /* Replace with your desired color */
  z-index: -1;
}

/* Style the content inside the marquee */
.marquee span {
  display: inline-block;
  padding-left: 100%;
  animation: marquee 20s linear infinite; /* Adjust the animation duration as needed */
  color: #ff0000; /* Replace with your desired text color */
  font-size: 18px; /* Replace with your desired font size */
}

/* Keyframes for the animation */
@keyframes marquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-100%); }
}
     h1{
    	text-align: center;
    	color: darkBlue;
     }
     h3{
         text-align:center;
         color:darkblue;
     }
    	
        .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .highlight {
        color: #333; /* Change the text color to a dark shade */
        font-size: 20px; /* Increase the font size */
        font-weight: bold; /* Add bold font weight */
        text-align: center; /* Center align the text */
        background-color: #f5f5f5; /* Add a light background color */
        padding: 10px; /* Add padding to create some space around the text */
        border-radius: 5px; /* Apply rounded corners to the paragraph */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
}
    
    .features {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    
    .feature {
      width: 300px;
      padding: 20px;
      margin: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .feature h3 {
      color: #333;
    }
    
    .feature p {
      color: #666;
    }
    
    
    
    @media (max-width: 600px) {
      .feature {
        width: 100%;
        margin: 10px 0;
      }
    }
    </style>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-609Q4WBY37">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-609Q4WBY37');
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11228150970"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11228150970');
</script>
<script>
  gtag('config', 'AW-11228150970/I9a7CLjl-bIYELr5_-kp', {
    'phone_conversion_number': '9969594076'
  });
</script>

</head>

<body>
    <!-- header section starts  -->
    <?php include "common/header.php";?>
    <!-- header section ends -->
    <BR>
    <div class="slider-container">
        <img src="images/c-Banner.png" alt="Slide 1">
       

        <div class="slider-nav">
            <button class="active"></button>
            <button></button>
            <button></button>
        </div>
    </div>
    <script>
        // Slider functionality (JavaScript)
        let sliderIndex = 0;
        const slides = document.querySelectorAll('.slider-container img');
        const dots = document.querySelectorAll('.slider-nav button');

        function showSlide(index) {
            sliderIndex = index;

            // Hide all slides
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }

            // Deactivate all dots
            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove('active');
            }

            // Show current slide
            slides[sliderIndex].style.display = 'block';

            // Activate current dot
            dots[sliderIndex].classList.add('active');
        }

        function nextSlide() {
            sliderIndex++;
            if (sliderIndex >= slides.length) {
                sliderIndex = 0;
            }
            showSlide(sliderIndex);
        }

        function previousSlide() {
            sliderIndex--;
            if (sliderIndex < 0) {
                sliderIndex = slides.length - 1;
            }
            showSlide(sliderIndex);
        }

        // Attach event listeners to dots
        for (let i = 0; i < dots.length; i++) {
            dots[i].addEventListener('click', function () {
                showSlide(i);
            });
        }

        // Automatic slide transition (optional)
        setInterval(nextSlide, 3000);

        // Initial slide display
        showSlide(sliderIndex);
    </script>
    <div class="marquee-container">
  <div class="marquee">
    <span><strong>Admission Open For B.Sc.IT, B.C.A, B.Sc.DataScience</strong></span>
  </div></div>
  <div class="marquee">
    <span>Direct, Walk-in, Offline Confirmed Admission Available Under Management Quota .</span>
    
  </div>
</div></div>

    <!-- home section starts  -->
    <section class="home">
        <div class="image">
            <img src="images/home-img.png" alt="">
        </div>
        <div class="content">
            <H1>RP Gems Group of Colleges</H1>
            <h3>Nirmiti Degree COLLEGE </h3>
            <p> Nirmiti Degree College of Arts, Science and Commerce, is an esteemed educational institution located in the suburbs of Mumbai. The college is known for its high-quality education and comprehensive range of undergraduate and postgraduate programs. With a dedicated faculty and state-of-the-art facilities, Nirmiti College offers a conducive learning environment for students to acquire knowledge and skills in various fields. The college's focus on academic excellence, practical learning, and industry relevance makes it a preferred choice for students aspiring to pursue their higher education goals.</p>
            <a href="map.php" class="btn">View school in map</a>
        </div>
    </section>
    <!-- home section ends -->
    <!-- categories section starts  -->
    <section class="category">
        <a href="bsc.php" class="box">
            <img src="images/category-1.png" alt="B.S.C.IT">
            <h3>B.SC.information Technology* </h3>
        </a>
        <a href="bca.php" class="box">
            <img src="images/category-2.png" alt="">
            <h3>B.C.A*</h3>
        </a>
        <a href="Datascience.php" class="box">
            <img src="images/category-3.png" alt="">
            <h3>Data SCIENCE*</h3>
        </a>
    
        <a href="" class="box">
            <img src="images/category-4.png" alt="">
            <h3>B.Com(Management Studies)*</h3>
        </a>

        <a href="http://rpgemsacademy.com/index.html" class="box">
            <img src="images/category-5.png" alt="">
            <h3>B.Com</h3>
        </a>

    </section>

    <!-- categories section ends -->
<!-- landing page section starts  -->
<div class="container">
        <div class="features">
      <div class="feature">
        <h1>Affiliated by Mumbai University</h2>
       <p class="highlight">Nirmiti is affiliated by Mumbai University, ensuring top-notch education quality.</p>
      </div>
      
      <div class="feature">
        <h1>Industry-relevant curriculum</h2>
       <p class="highlight">The B.Sc. IT program at Nirmiti covers the latest technologies and trends in the IT industry.</p>
      </div>
      
      <div class="feature">
        <h1>Experienced faculty</h2>
        <p class="highlight">Learn from expert faculty members who have years of experience in the field.</p>
      </div>
      
      <div class="feature">
        <h1>State-of-the-art facilities</h2>
        <p class="highlight">Access modern facilities including a computer lab, library, and  hall.</p>
      </div>
      
      <div class="feature">
        <h1>Strong placement record</h2>
        <p class="highlight">Over 90% of B.Sc. IT graduates from College have been Working in top IT companies.</p>
      </div>
    </div>
  </div>
  
  
    <!-- footer section starts  -->

    <?php include "common/footer.php";?>

    <!-- footer section ends -->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>