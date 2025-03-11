<?php
// Include necessary files
require_once 'includes/db_connect.php';
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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS for form messages -->
  <style>
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 4px;
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
    .review-item {
      padding: 20px;
      text-align: center;
      background-color: #f9f9f9;
      border-radius: 8px;
      margin: 0 auto;
      max-width: 80%;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="80">

      <h1 class="logo mr-auto"><a href="index.php">KLICKMYBABY Studio</a></h1>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#gallery">Gallery</a></li>
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
    </div>
  </section>

<!-- Review Section -->
<section id="reviews" class="reviews section-bg">
  <div class="container">
    <div class="section-title">
      <h2>Customer Reviews</h2>
      <p>See what our clients have to say about their experience!</p>
    </div>
    
    <?php
    // Display success or error messages for review submission
    if (isset($_GET['review_status'])) {
        $status = $_GET['review_status'];
        $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
        
        if ($status === 'success') {
            echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
        } else {
            echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
        }
    }
    ?>
    
    <!-- Review Submission Form -->
    <form action="process_review.php" method="post" role="form" class="php-email-form">
  <div class="row">
    <div class="col-md-6 form-group">
      <input type="text" name="name" class="form-control" placeholder="Your Name" required>
    </div>
    <div class="col-md-6 form-group">
      <select name="rating" class="form-control" required placeholder="Your Name" required>
        <option value="" disabled selected>Rate Us</option>
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
    <?php include 'display_reviews.php'; ?>
  </div>
</section>

  <!-- ======= Gallery Section ======= -->
  <section id="gallery" class="gallery">
    <div class="container">

      <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
       
        </div>
      </div>

      <div class="row gallery-container">

        <div class="col-lg-4 col-md-6 gallery-item filter-home">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/gallery-1.jpg" class="img-fluid" alt="">
            <div class="gallery-info">           
              <div class="gallery-links">
                <a href="assets/img/gallery/gallery-1.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-2.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-home">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/home-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
             <div class="gallery-links">
                <a href="assets/img/gallery/home-2.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/beach-2.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/beach-2.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-1.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-1.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-home">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/home-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/home-3.jpg" data-gall="galleryGallery" class="venobox" ><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/gallery-5.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/gallery-5.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-beach">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/beach-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/beach-3.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item filter-vacation">
          <div class="gallery-wrap">
            <img src="assets/img/gallery/vacation-3.jpg" class="img-fluid" alt="">
            <div class="gallery-info">
              <div class="gallery-links">
                <a href="assets/img/gallery/vacation-3.jpg" data-gall="galleryGallery" class="venobox"><i class="bx bx-plus"></i></a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Gallery Section -->

    <section id="faq" class="faq">
      <div class="container">
        <h3>Frequently Asked Questions</h3>
        <div class="faq-item">
          <h5>1. When is the ideal time to have a newborn session?</h5>
          <p>The best time to have a newborn photoshoot is between the 2nd and 3rd week after birth. During this time, babies tend to sleep deeply and maintain their natural curled-up positions. If your baby is older than 3 weeks, we can still capture beautiful images, but traditional newborn poses may be harder to achieve.</p>
        </div>
        <div class="faq-item">
          <h5>2. When should I book my newborn session?</h5>
          <p>It's best to book during pregnancy, as slots fill up quickly. We reserve a tentative date around your due date, and once your baby arrives, we finalize the schedule.</p>
        </div>
        <div class="faq-item">
          <h5>3. My baby is already here! Can I still do a newborn session?</h5>
          <p>Yes! While younger newborns are easier to pose, we can still create beautiful memories with older babies. Last-minute slots may be available, so feel free to inquire.</p>
        </div>
        <div class="faq-item">
          <h5>4. How long will the newborn session last?</h5>
          <p>Sessions typically last between 1.5 to 3 hours, depending on the package chosen. If necessary, we can schedule an additional session for an extra fee.</p>
        </div>
      </div>
    </section>
  </main>

    <!-- about us  -->
    <main id="main">
      <section id="story-intro" class="story-intro">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 order-1 order-lg-2">
              <img src="assets/img/intro.jpg" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
              <h3>Our Story</h3>
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
  <!-- ======= Contact Us Section ======= -->
    <section id="contact-us" class="contact-us">
      <div class="container">

        <div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248849.90089943376!2d77.46612593299314!3d12.953945614011557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s<Thinking>
I need to continue the PHP code for the index.php file that was cut off. The cut-off point was in the Google Maps iframe src attribute in the Contact Us section. I'll continue from there, completing the iframe URL and then continuing with the rest of the contact form section and any remaining parts of the index.php file.
</Thinking>

d248849.90089943376!2d77.46612593299314!3d12.953945614011557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670c9b44e6d%3A0xf8dfc3e8517e4fe0!2sBengaluru%2C%20Karnataka%2C%20India!5e0!3m2!1sen!2sus!4v1738569867486!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Location:</h4>
                <p>Bangalore</p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p><a href="mailto:info@klickmybaby.com">info@klickmybaby.com</a></p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call:</h4>
                <p>+91 8951199385</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">
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
      <p>Creating memories</p>
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
        Designed by <a href="#">Clickmybaby</a>
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

  <!-- Template Main JS File  -->
  <script src="assets/js/main.js"></script>  

  <!-- Bootstrap JS and Popper.js (required for carousel) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript for form handling -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
  </script>
</body>

</html>