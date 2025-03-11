<?php
session_start();
require_once 'includes/db_connect.php';

// Generate form tokens if they don't exist
if (!isset($_SESSION['review_form_token'])) {
    $_SESSION['review_form_token'] = md5(uniqid(mt_rand(), true));
}
if (!isset($_SESSION['booking_form_token'])) {
    $_SESSION['booking_form_token'] = md5(uniqid(mt_rand(), true));
}
if (!isset($_SESSION['contact_form_token'])) {
    $_SESSION['contact_form_token'] = md5(uniqid(mt_rand(), true));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>KLICKMYBABY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files   -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">  
  
  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS for form messages -->
  <style>
    /* Enhanced Alert Styles */
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    .alert-success {
      color: #3c763d;
      background-color: #dff0d8;
      border-color: #d6e9c6;
    }
    .alert-danger {
      color: #a94442;
      background-color: #f2dede;
      border-color: #ebccd1;
    }
    
    /* Enhanced Review Item Styles */
    .review-item {
      padding: 25px;
      text-align: center;
      background-color: #ffffff;
      border-radius: 12px;
      margin: 0 auto;
      max-width: 80%;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .review-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    /* Enhanced Booking Form Styles */
    .booking-form {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 35px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .booking-form:hover {
      transform: translateY(-5px);
    }
    
    /* Enhanced Package Card Styles */
    .package-card {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 25px;
      transition: all 0.4s ease;
      background-color: #ffffff;
      position: relative;
      overflow: hidden;
    }
    .package-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .package-card.selected {
      border-color: #8e44ad;
      background-color: #f5eef8;
    }
    .package-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #8e44ad, #9b59b6);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.4s ease;
    }
    .package-card:hover::before {
      transform: scaleX(1);
    }
    
    /* Smooth Scrolling */
    html {
      scroll-behavior: smooth;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background: #8e44ad;
      border-radius: 5px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #7d3c98;
    }
    
    /* Enhanced Navigation - REMOVED UNDERLINE */
    .nav-menu a {
      position: relative;
      transition: color 0.3s ease;
    }
    .nav-menu a:hover, .nav-menu .active > a, .nav-menu li:hover > a {
      color: var(--primary-color);
    }
    
    /* Enhanced Form Inputs */
    .form-control {
      transition: all 0.3s ease;
      border: 1px solid #e0e0e0;
    }
    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.2);
      border-color: #8e44ad;
    }
    
    /* Enhanced Buttons */
    .btn {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .btn::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%) scale(0);
      opacity: 0;
      transition: transform 0.5s ease, opacity 0.5s ease;
    }
    .btn:hover::after {
      transform: translate(-50%, -50%) scale(2);
      opacity: 1;
    }
    
    /* Enhanced FAQ Section */
    .faq-item {
      padding: 20px;
      margin-bottom: 15px;
      border-radius: 10px;
      background-color: #ffffff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    .faq-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    /* Page Loader */
    .page-loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    .loader {
      width: 50px;
      height: 50px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #8e44ad;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    /* New Color Scheme */
    :root {
      --primary-color: #8e44ad;
      --primary-light: #9b59b6;
      --primary-dark: #7d3c98;
      --secondary-color: #2ecc71;
      --accent-color: #f1c40f;
      --text-color: #333333;
      --light-bg: #f9f9f9;
    }
    
    /* Apply New Color Scheme */
    #header .logo a {
      color: var(--primary-color);
    }
    .nav-menu a:hover, .nav-menu .active > a, .nav-menu li:hover > a {
      color: var(--primary-color);
    }
    .section-title h2::after {
      background: var(--primary-color);
    }
    .btn-primary, #hero .btn-get-started {
      background: var(--primary-color);
    }
    .btn-primary:hover, #hero .btn-get-started:hover {
      background: var(--primary-light);
    }
    #hero .carousel-indicators li.active {
      background: var(--primary-color);
    }
    .back-to-top i {
      background: var(--primary-color);
    }
    .back-to-top i:hover {
      background: var(--primary-light);
    }
    #footer .social-links a {
      background: var(--primary-color);
    }
    #footer .social-links a:hover {
      background: var(--primary-light);
    }
    
    /* Image Hover Effects */
    .gallery-wrap {
      transition: transform 0.5s ease;
    }
    .gallery-wrap:hover {
      transform: scale(1.03);
    }
    
    /* New Animated Background for Hero */
    #hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(142, 68, 173, 0.8), rgba(41, 128, 185, 0.8));
      z-index: 1;
      opacity: 0.7;
    }
    #hero .carousel-container {
      z-index: 2;
    }

    /* AOS Preload Fix */
    .aos-preload * {
      visibility: hidden;
    }
    body:not(.aos-preload) * {
      visibility: visible;
      transition: visibility 0s ease;
    }
    
    /* Logo Styling */
    .site-logo {
      max-height: 70px;
      margin-right: 10px;
    }
    
    /* Enhanced Footer with Background Image */
    #footer {
      background: url('assets/img/footer-bg.jpg') center center no-repeat;
      background-size: cover;
      position: relative;
      color: #fff;
      padding: 60px 0 30px;
    }
    
    #footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(142, 68, 173, 0.9), rgba(41, 128, 185, 0.9));
      z-index: 1;
    }
    
    #footer .container {
      position: relative;
      z-index: 2;
    }
    
    #footer h3, #footer p, #footer .social-links a, #footer .copyright, #footer .credits {
      color: #fff;
    }
    
    #footer .social-links a {
      background: rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }
    
    #footer .social-links a:hover {
      background: rgba(255, 255, 255, 0.4);
      transform: translateY(-3px);
    }
  </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="80">
  <!-- Page Loader -->
  <div class="page-loader">
    <div class="loader"></div>
  </div>

  <!-- Header -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
      <!-- Added Logo -->
      <img src="assets/img/logo.png" alt="KLICKMYBABY Logo" class="site-logo">
      <h1 class="logo mr-auto"><a href="index.php">KLICKMYBABY Studio</a></h1>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#booking">Book a Session</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#story-intro">Our Story</a></li>
          <li><a href="#contact-us">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url(assets/img/slide/slide-1.jpg)"></div>
        <div class="carousel-item" style="background-image: url(assets/img/slide/slide-2.jpg)"></div>
        <div class="carousel-item" style="background-image: url(assets/img/slide/slide-3.jpg)"></div>
      </div>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
      
      <!-- Added animated text overlay -->
      <div class="carousel-container" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
          <h2 class="animate__animated animate__fadeInDown">Capturing Precious Moments</h2>
          <p class="animate__animated animate__fadeInUp">Creating timeless memories of your little ones</p>
          <a href="#booking" class="btn-get-started animate__animated animate__fadeInUp scrollto">Book Now</a>
        </div>
      </div>
    </div>
  </section>

<!-- Review Section -->
<section id="reviews" class="reviews section-bg">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="800">
      <h2>Customer Reviews</h2>
      <p>See what our clients have to say about their experience!</p>
    </div>
    
    <?php
    // Display success or error messages for review submission
    if (isset($_GET['review_status'])) {
        $status = $_GET['review_status'];
        $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
        
        if ($status === 'success') {
            echo '<div class="alert alert-success" data-aos="fade-up">' . htmlspecialchars($message) . '</div>';
        } else {
            echo '<div class="alert alert-danger" data-aos="fade-up">' . htmlspecialchars($message) . '</div>';
        }
    }
    ?>
    
    <!-- Review Submission Form -->
    <form action="process_review.php" method="post" role="form" class="php-email-form" data-aos="fade-up">
      <input type="hidden" name="form_token" value="<?php echo $_SESSION['review_form_token']; ?>">
      <div class="row">
        <div class="col-md-6 form-group">
          <input type="text" name="name" class="form-control" placeholder="Your Name" required>
        </div>
        <div class="col-md-6 form-group">
          <select name="rating" class="form-control" required>
            <option value="">Rate Us</option>
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <textarea name="review" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit Review</button>
      </div>
    </form>
    
    <!-- Review Carousel - Include PHP to display reviews from database -->
    <div class="mt-5" data-aos="fade-up" data-aos-delay="200">
      <?php include 'display_reviews.php'; ?>
    </div>
  </div>
</section>

  <!-- ======= Gallery Section ======= -->
  <section id="gallery" class="gallery">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Our Gallery</h2>
        <p>Explore our beautiful collection of newborn and family photography</p>
      </div>

      <div class="row gallery-container">

        <div class="col-lg-4 col-md-6 gallery-item filter-home" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/home-1.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Home 1</h4>
              <p>Home</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/home-1.jpg" data-gall="galleryGallery" class="venobox" title="Home 1"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Vacation 2</h4>
              <p>Vacation</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-2.jpg" data-gall="galleryGallery" class="venobox" title="Vacation 2"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-home" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/home-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Home 2</h4>
              <p>Home</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/home-2.jpg" data-gall="galleryGallery" class="venobox" title="Home 2"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/beach-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Beach 2</h4>
              <p>Beach</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/beach-2.jpg" data-gall="galleryGallery" class="venobox" title="Beach 2"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-1.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Vacation 1</h4>
              <p>Vacation</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-1.jpg" data-gall="galleryGallery" class="venobox" title="Vacation 1"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-home" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/home-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Home 3</h4>
              <p>Home</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/home-3.jpg" data-gall="galleryGallery" class="venobox" title="Home 3"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/beach-1.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Beach 1</h4>
              <p>Beach</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/beach-1.jpg" data-gall="galleryGallery" class="venobox" title="Beach 1"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/beach-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Beach 3</h4>
              <p>Beach</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/beach-3.jpg" data-gall="galleryGallery" class="venobox" title="Beach 3"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="10">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <h4>Vacation 3</h4>
              <p>Vacation</p>
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-3.jpg" data-gall="galleryGallery" class="venobox" title="Vacation 3"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Gallery Section -->

  <!-- ======= Booking Section ======= -->
  <section id="booking" class="booking section-bg">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Book a Session</h2>
        <p>Schedule your photoshoot with us</p>
      </div>
      
      <?php
      // Display success or error messages for booking submission
      if (isset($_GET['booking_status'])) {
          $status = $_GET['booking_status'];
          $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
          
          if ($status === 'success') {
              echo '<div class="alert alert-success" data-aos="fade-up">' . htmlspecialchars($message) . '</div>';
          } else {
              echo '<div class="alert alert-danger" data-aos="fade-up">' . htmlspecialchars($message) . '</div>';
          }
      }
      ?>
      
      <div class="row">
        <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-duration="800">
          <div class="package-card" data-package="Basic">
            <h3 class="text-center">Basic Package</h3>
            <h4 class="text-center price">₹3,999</h4>
            <hr>
            <ul class="list-unstyled">
              <li><i class="bx bx-check text-success"></i> 1-hour photoshoot session</li>
              <li><i class="bx bx-check text-success"></i> 10 digital images</li>
              <li><i class="bx bx-check text-success"></i> 1 outfit change</li>
              <li><i class="bx bx-check text-success"></i> Basic editing</li>
              <li><i class="bx bx-check text-success"></i> Online gallery</li>
            </ul>
            <div class="text-center mt-3">
              <button class="btn btn-outline-primary select-package" data-package="Basic">Select Package</button>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-duration="800">
          <div class="package-card" data-package="Premium">
            <h3 class="text-center">Premium Package</h3>
            <h4 class="text-center price">₹5,999</h4>
            <hr>
            <ul class="list-unstyled">
              <li><i class="bx bx-check text-success"></i> 2-hour photoshoot session</li>
              <li><i class="bx bx-check text-success"></i> 20 digital images</li>
              <li><i class="bx bx-check text-success"></i> 2 outfit changes</li>
              <li><i class="bx bx-check text-success"></i> Advanced editing</li>
              <li><i class="bx bx-check text-success"></i> Online gallery</li>
              <li><i class="bx bx-check text-success"></i> 1 printed photo album (8x8)</li>
            </ul>
            <div class="text-center mt-3">
              <button class="btn btn-outline-primary select-package" data-package="Premium">Select Package</button>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-duration="800">
          <div class="package-card" data-package="Deluxe">
            <h3 class="text-center">Deluxe Package</h3>
            <h4 class="text-center price">₹8,999</h4>
            <hr>
            <ul class="list-unstyled">
              <li><i class="bx bx-check text-success"></i> 3-hour photoshoot session</li>
              <li><i class="bx bx-check text-success"></i> 30 digital images</li>
              <li><i class="bx bx-check text-success"></i> 3 outfit changes</li>
              <li><i class="bx bx-check text-success"></i> Premium editing</li>
              <li><i class="bx bx-check text-success"></i> Online gallery</li>
              <li><i class="bx bx-check text-success"></i> 1 premium photo album (10x10)</li>
              <li><i class="bx bx-check text-success"></i> 2 canvas prints (8x10)</li>
              <li><i class="bx bx-check text-success"></i> Family photos included</li>
            </ul>
            <div class="text-center mt-3">
              <button class="btn btn-outline-primary select-package" data-package="Deluxe">Select Package</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
        <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-duration="800">
          <div class="booking-form">
            <form action="process_booking.php" method="post" role="form" class="php-email-form">
              <input type="hidden" name="form_token" value="<?php echo $_SESSION['booking_form_token']; ?>">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" id="booking-name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="email">Your Email</label>
                  <input type="email" class="form-control" name="email" id="booking-email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="phone">Phone Number</label>
                  <input type="tel" name="phone" class="form-control" id="booking-phone" placeholder="Your Phone Number" required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="package_type">Package</label>
                  <select name="package_type" class="form-control" id="package_type" required>
                    <option value="">Select a Package</option>
                    <option value="Basic">Basic Package</option>
                    <option value="Premium">Premium Package</option>
                    <option value="Deluxe">Deluxe Package</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="preferred_date">Preferred Date</label>
                  <input type="date" name="preferred_date" class="form-control" id="preferred_date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>
                <div class="col-md-6 form-group">
                  <label for="preferred_time">Preferred Time</label>
                  <select name="preferred_time" class="form-control" id="preferred_time" required>
                    <option value="">Select a Time</option>
                    <option value="Morning (9AM-12PM)">Morning (9AM-12PM)</option>
                    <option value="Afternoon (12PM-3PM)">Afternoon (12PM-3PM)</option>
                    <option value="Evening (3PM-6PM)">Evening (3PM-6PM)</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="special_requests">Special Requests or Notes</label>
                <textarea class="form-control" name="special_requests" id="special_requests" rows="4" placeholder="Any special requests or notes for your session..."></textarea>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Book Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Booking Section -->

  <!-- FAQ Section with enhanced styling -->
  <section id="faq" class="faq">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <p>Everything you need to know about our photography sessions</p>
      </div>
      
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="faq-item" data-aos="fade-up" data-aos-duration="800">
            <h5>1. When is the ideal time to have a newborn session?</h5>
            <p>The best time to have a newborn photoshoot is between the 2nd and 3rd week after birth. During this time, babies tend to sleep deeply and maintain their natural curled-up positions. If your baby is older than 3 weeks, we can still capture beautiful images, but traditional newborn poses may be harder to achieve.</p>
          </div>
          <div class="faq-item" data-aos="fade-up" data-aos-duration="800">
            <h5>2. When should I book my newborn session?</h5>
            <p>It's best to book during pregnancy, as slots fill up quickly. We reserve a tentative date around your due date, and once your baby arrives, we finalize the schedule.</p>
          </div>
          <div class="faq-item" data-aos="fade-up" data-aos-duration="800">
            <h5>3. My baby is already here! Can I still do a newborn session?</h5>
            <p>Yes! While younger newborns are easier to pose, we can still create beautiful memories with older babies. Last-minute slots may be available, so feel free to inquire.</p>
          </div>
          <div class="faq-item" data-aos="fade-up" data-aos-duration="800">
            <h5>4. How long will the newborn session last?</h5>
            <p>Sessions typically last between 1.5 to 3 hours, depending on the package chosen. If necessary, we can schedule an additional session for an extra fee.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <main id="main">
    <section id="story-intro" class="story-intro">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Our Story</h2>
          <p>Learn about our passion for newborn photography</p>
        </div>
        
        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-duration="800">
            <img src="assets/img/intro.jpg" class="img-fluid rounded shadow" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-duration="800">
            <h3>Our Journey</h3>
            <p>Welcome to Clickmybaby, where we specialize in capturing the precious early moments of your newborn's life. We understand that those first few weeks pass by in the blink of an eye, and our mission is to preserve those beautiful memories forever.</p>
            <p>With years of experience in newborn photography, we provide a warm, safe, and comfortable environment for both baby and parents. Our sessions are designed to be stress-free, allowing you to relax while we work our magic. We focus on natural, timeless, and heartfelt images that showcase the innocence and beauty of your little one.</p>
            <p>From delicate poses to intimate family moments, we take pride in creating artistic photographs that you will cherish for a lifetime. We use soft lighting, gentle props, and a calming approach to ensure your baby feels secure throughout the session.</p>
            <p>At Clickmybaby, we believe every family has a unique story to tell, and we are honored to be a part of yours. Whether you are welcoming your first child or adding to your growing family, we are here to create stunning portraits that celebrate the joy and love of new life.</p>
            <p>Let's create something beautiful together!</p>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <!-- Contact Us Section -->
  <section id="contact-us" class="contact-us">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Contact Us</h2>
        <p>Get in touch with our team</p>
      </div>

      <div data-aos="fade-up" data-aos-duration="800">
        <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248849.90089943376!2d77.46612593299314!3d12.953945614011557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670c9b44e6d%3A0xf8dfc3e8517e4fe0!2sBengaluru%2C%20Karnataka%2C%20India!5e0!3m2!1sen!2sus!4v1738569867486!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div class="row mt-5">
        <div class="col-lg-4" data-aos="fade-right" data-aos-duration="800">
          <div class="info">
            <div class="address">
              <i class="icofont-google-map"></i>
              <h4>Location:</h4>
              <p>Bangalore</p>
            </div>

            <div class="email">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p><a href="mailto:info@klickmybaby.com">clickmybabyphotography@gmail.com</a></p>
            </div>

            <div class="phone">
              <i class="icofont-phone"></i>
              <h4>Call:</h4>
              <p>+91 9901249096</p>
            </div>
          </div>
        </div>

        <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="800">
          <?php
          // Display success or error messages for contact form submission
          if (isset($_GET['contact_status'])) {
              $status = $_GET['contact_status'];
              $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
              
              if ($status === 'success') {
                  echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
              } else {
                  echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
              }
          }
          ?>

          <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <input type="hidden" name="form_token" value="<?php echo $_SESSION['contact_form_token']; ?>">
            <div class="form-row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="validate"></div>
              </div>
              <div class="col-md-6 form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                <div class="validate"></div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
              <div class="validate"></div>
            </div>
            <div class="mb-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit">Send Message</button></div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- End Contact Us Section -->

  <!-- Footer -->
  <footer id="footer">
    <div class="container">
      <h3>Klickmybaby Studio</h3>
      <p>Creating memories that last a lifetime</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>Clickmybaby</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a>Clickmybaby</a>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files  -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>   
  
  <!-- AOS Animation Library -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- Template Main JS File  -->
  <script src="assets/js/main.js"></script>  

  <!-- Bootstrap JS and Popper.js (required for carousel) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript for enhanced effects -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Ensure all content is loaded before animations
    document.body.classList.add('aos-preload');
    window.addEventListener('load', function() {
      document.body.classList.remove('aos-preload');
      // Force AOS refresh after everything is loaded
      setTimeout(function() {
        AOS.refresh();
      }, 100);
    });

    // Initialize AOS animation library
    AOS.init({
      duration: 800,
      easing: 'ease-out',
      once: true,
      offset: 50,
      delay: 0,
      disable: 'mobile'
    });

    // Refresh AOS when page is fully loaded to fix sync issues
    window.addEventListener('load', function() {
      AOS.refresh();
    });

    // Refresh AOS on window resize to maintain sync
    window.addEventListener('resize', function() {
      AOS.refresh();
    });
    
    // Page loader
    setTimeout(function() {
      const loader = document.querySelector('.page-loader');
      loader.style.opacity = '0';
      setTimeout(function() {
        loader.style.display = 'none';
      }, 500);
    }, 1000);
    
    // Handle review form submission with AJAX
    const reviewForm = document.querySelector('#reviews .php-email-form');
    if (reviewForm) {
      reviewForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('process_review.php', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            this.reset();
            // Update the form token with the new one from the server
            if (data.token) {
              this.querySelector('input[name="form_token"]').value = data.token;
            }
            // Reload the page to show the new review (if approved)
            setTimeout(() => {
              window.location.href = 'index.php#reviews';
            }, 1000);
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });
    }
    
    // Handle contact form submission with AJAX
    const contactForm = document.querySelector('#contact-us .php-email-form');
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const loadingElement = this.querySelector('.loading');
        const errorElement = this.querySelector('.error-message');
        const sentElement = this.querySelector('.sent-message');
        
        // Show loading
        loadingElement.style.display = 'block';
        errorElement.style.display = 'none';
        sentElement.style.display = 'none';
        
        fetch('forms/contact.php', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          // Hide loading
          loadingElement.style.display = 'none';
          
          if (data.status === 'success') {
            sentElement.innerHTML = data.message;
            sentElement.style.display = 'block';
            this.reset();
            // Update the form token with the new one from the server
            if (data.token) {
              this.querySelector('input[name="form_token"]').value = data.token;
            }
          } else {
            errorElement.innerHTML = data.message;
            errorElement.style.display = 'block';
          }
        })
        .catch(error => {
          loadingElement.style.display = 'none';
          errorElement.innerHTML = 'An error occurred. Please try again.';
          errorElement.style.display = 'block';
          console.error('Error:', error);
        });
      });
    }
    
    // Handle booking package selection with animation
    const packageCards = document.querySelectorAll('.package-card');
    const packageSelect = document.getElementById('package_type');
    
    packageCards.forEach(card => {
      card.addEventListener('click', function() {
        const packageType = this.getAttribute('data-package');
        
        // Remove selected class from all cards with animation
        packageCards.forEach(c => {
          c.classList.remove('selected');
          c.style.transform = 'translateY(0)';
        });
        
        // Add selected class to clicked card with animation
        this.classList.add('selected');
        this.style.transform = 'translateY(-10px)';
        
        // Update the select dropdown
        packageSelect.value = packageType;
      });
    });
    
    // Handle select package buttons with smooth scroll
    const selectButtons = document.querySelectorAll('.select-package');
    selectButtons.forEach(button => {
      button.addEventListener('click', function() {
        const packageType = this.getAttribute('data-package');
        
        // Remove selected class from all cards
        packageCards.forEach(c => {
          c.classList.remove('selected');
          c.style.transform = 'translateY(0)';
        });
        
        // Add selected class to parent card with animation
        const parentCard = this.closest('.package-card');
        parentCard.classList.add('selected');
        parentCard.style.transform = 'translateY(-10px)';
        
        // Update the select dropdown
        packageSelect.value = packageType;
        
        // Scroll to booking form with smooth animation
        document.querySelector('.booking-form').scrollIntoView({ 
          behavior: 'smooth',
          block: 'start'
        });
      });
    });
    
    // Handle booking form submission with AJAX
    const bookingForm = document.querySelector('#booking .php-email-form');
    if (bookingForm) {
      bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('process_booking.php', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            this.reset();
            // Update the form token with the new one from the server
            if (data.token) {
              this.querySelector('input[name="form_token"]').value = data.token;
            }
            // Reload the page
            setTimeout(() => {
              window.location.href = 'index.php#booking';
            }, 1000);
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });
    }
    
    // Add parallax effect to hero section
    window.addEventListener('scroll', function() {
      const scrollPosition = window.pageYOffset;
      const heroSection = document.querySelector('#hero');
      if (heroSection) {
        heroSection.style.backgroundPositionY = scrollPosition * 0.3 + 'px';
      }
    });
    
    // Add hover effects to gallery items
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
      item.addEventListener('mouseenter', function() {
        this.querySelector('.gallery-wrap').style.transform = 'scale(1.03)';
      });
      
      item.addEventListener('mouseleave', function() {
        this.querySelector('.gallery-wrap').style.transform = 'scale(1)';
      });
    });
  });
</script>

</body>
</html>