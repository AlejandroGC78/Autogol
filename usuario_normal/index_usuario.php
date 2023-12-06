<?php
session_start();
if (!isset($_SESSION["usuario"])){
    echo '<script>
        alert("Por favor debes iniciar sesión");
        window.location = "../vistas/login.php";
    </script>';
    session_destroy();
    die();
}
?>
<?php 
include '../modelos/config.php';
include '../modelos/conexion.php';
include './carrito.php';
include '../vistas/cabecera_usuario.php';
?>

      <h3 class="h3"></h3>
      <div class="row">
          <div class="col-md-3 col-sm-6">
              <div class="product-grid5">
                  <div class="product-image5">
                      <a href="#">
                          <img class="pic-1" src="../assets/imagenes/America.jpeg">
                          <img class="pic-2" src="../assets/imagenes/america2.jpeg">
                      </a>
                      <ul class="social">
                          <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                          <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                          <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                      </ul>
                      <a href="#" class="select-options"><i class="fa fa-arrow-right "></i> Select Options</a>
                  </div>
                  <div class="product-content">
                      <h3 class="title"><a href="equipos.php">Camiseta Club America Aguilas 2023/24 Primera Equipación Local Hombre Nike - Versión Replica</a></h3>
                      <div class="price">$456.90</div>
                  </div>
              </div>
          </div>
          
          <div class="col-md-3 col-sm-6">
              <div class="product-grid5">
                  <div class="product-image5">
                      <a href="#">
                          <img class="pic-1" src="../assets/imagenes/Chivas.jpeg">
                          <img class="pic-2" src="../assets/imagenes/chivas2.jpeg">
                      </a>
                      <ul class="social">
                          <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                          <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                          <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                      </ul>
                      <a href="#" class="select-options"><i class="fa fa-arrow-right"></i> Select Options</a>
                  </div>
                  <div class="product-content">
                      <h3 class="title"><a href="equipos.php">Camiseta Chivas 2023/24 Primera Equipación Local Hombre Puma - Versión Replica</a></h3>
                      <div class="price">$480.00</div>
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-6">
              <div class="product-grid5">
                  <div class="product-image5">
                      <a href="#">
                          <img class="pic-1" src="../assets/imagenes/cruzazul.jpeg">
                          <img class="pic-2" src="../assets/imagenes/cruzazul2.jpeg">
                      </a>
                      <ul class="social">
                          <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                          <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                          <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                      </ul>
                      <a href="#" class="select-options"><i class="fa fa-arrow-right"></i> Select Options</a>
                  </div>
                  <div class="product-content">
                      <h3 class="title"><a href="equipos.php">Camiseta Cruz Azul 2023/24 Primera Equipación Local Hombre - Versión Replica</a></h3>
                      <div class="price">$500.00</div>
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-6">
              <div class="product-grid5">
                  <div class="product-image5">
                      <a href="#">
                          <img class="pic-1" src="../assets/imagenes/Pumas.jpeg">
                          <img class="pic-2" src="../assets/imagenes/pumas2.jpeg">
                      </a>
                      <ul class="social">
                          <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                          <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                          <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                      </ul>
                      <a href="#" class="select-options"><i class="fa fa-arrow-right"></i> Select Options</a>
                  </div>
                  <div class="product-content">
                      <h3 class="title"><a href="equipos.php">Camiseta Pumas UNAM 2023/24 Segunda Equipación Visitante Hombre Nike - Versión Replica</a></h3>
                      <div class="price">$250.00</div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <hr>
  <main>
    <section>
      <!-- Carrusel de cursos -->
      <div id="carruselCursos" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
              <div class="curso_columna col-md-6">
                <img src="../assets/imagenes/bannerAzul.jpeg" alt="">
                <div class="info_curso">
                  <h3>Cruz Azul</h3>
                  <p>Cruz Azul es un club de fútbol profesional con sede en la ciudad de México, México. También es conocido como "La Máquina Azul" o "La Máquina Azul". El club fue fundado en 1927</p>
                </div>
              </div>
              <div class="curso_columna col-md-6">
                <img src="../assets/imagenes/bannerAme.jpeg" alt="">
                <div class="info_curso">
                  <h3>América</h3>
                  <p>Club América, también conocido como "Las Águilas" (Las Águilas) y "El Super Club" (El Super Club), es uno de los clubes de fútbol más exitosos y populares en México. Fundado en 1916, el equipo ha ganado 13 títulos de liga</p>
                </div>
              </div>
            </div>
          </div>
  
          <!-- Agregar más elementos de carrusel aquí -->
          <div class="carousel-item">
            <div class="row">
              <div class="curso_columna col-md-6">
                <img src="../assets/imagenes/bannerPuma.jpeg" alt="">
                <div class="info_curso">
                  <h3>Pumas UNAM</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>
                </div>
              </div>
              <div class="curso_columna col-md-6">
                <img src="../assets/imagenes/bannerAzul.jpeg" alt="">
                <div class="info_curso">
                  <h3>Cruz Azul</h3>
                  <p>Información adicional de Cruz Azul...</p>
                </div>
              </div>
            </div>
          </div>
  
          <!-- Agregar más elementos de carrusel aquí -->
        </div>
        <a class="carousel-control-prev" href="#carruselCursos" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carruselCursos" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>
  </main>
  <footer id="dk-footer" class="dk-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="dk-footer-box-info">
                    <a href="index_usuario.php" class="footer-logo">
                        <img src="../assets/imagenes/AutoGol.png" alt="footer_logo" class="img-fluid">
                    </a>
                    <p class="footer-info-text">
                       Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.
                    </p>
                    <div class="footer-social-link">
                        <h3>Follow us</h3>
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/profile.php?id=100089225509845">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Social link -->
                </div>
                <!-- End Footer info -->
                <div class="footer-awarad">
                    <img src="../images/icon/best.png" alt="">
                    <p>Best Design Company 2019</p>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-us">
                            <div class="contact-icon">
                                <i class="fa fa-map-o" aria-hidden="true"></i>
                            </div>
                            <!-- End contact Icon -->
                            <div class="contact-info">
                                <h3>Neutla, Comonfort GTO</h3>
                                <p>Calle San Martin #13</p>
                            </div>
                            <!-- End Contact Info -->
                        </div>
                        <!-- End Contact Us -->
                    </div>
                    <!-- End Col -->
                    <div class="col-md-6">
                        <div class="contact-us contact-us-last">
                            <div class="contact-icon">
                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                            </div>
                            <!-- End contact Icon -->
                            <div class="contact-info">
                                <h3>95 711 9 5353</h3>
                                <p>Give us a call</p>
                            </div>
                            <!-- End Contact Info -->
                        </div>
                        <!-- End Contact Us -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Contact Row -->
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget footer-left-widget">
                            <div class="section-heading">
                                <h3>Useful Links</h3>
                                <span class="animate-border border-black"></span>
                            </div>
                            <ul>
                                <li>
                                    <a href="../vistas/aboutus.html">About us</a>
                                </li>
                                <li>
                                    <a href="#">Services</a>
                                </li>
                                <li>
                                    <a href="#">Projects</a>
                                </li>
                                <li>
                                    <a href="#">Our Team</a>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <a href="../vistas/contactus.html">Contact us</a>
                                </li>
                                <li>
                                    <a href="#">Blog</a>
                                </li>
                                <li>
                                    <a href="#">Testimonials</a>
                                </li>
                                <li>
                                    <a href="#">Faq</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Footer Widget -->
                    </div>
                    <!-- End col -->
                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget">
                            <div class="section-heading">
                                <h3>Subscribe</h3>
                                <span class="animate-border border-black"></span>
                            </div>
                            <p><!-- Don’t miss to subscribe to our new feeds, kindly fill the form below. -->
                            Reference site about Lorem Ipsum, giving information on its origins, as well.</p>
                            <form action="#">
                                <div class="form-row">
                                    <div class="col dk-footer-form">
                                        <input type="email" class="form-control" placeholder="Email Address">
                                        <button type="submit" >
                                            <i class="fa fa-send" ></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- End form -->
                        </div>
                        <!-- End footer widget -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Widget Row -->
    </div>
    <!-- End Contact Container -->



    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span>Copyright © 2019, All Right Reserved Seobin</span>
                </div>
                <!-- End Col -->
                <div class="col-md-6">
                    <div class="copyright-menu">
                        <ul>
                            <li>
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="#">Terms</a>
                            </li>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Copyright Container -->
    </div>
    <!-- End Copyright -->
    <!-- Back to top -->
    <div id="back-to-top" class="back-to-top">
        <button class="btn btn-dark" title="Back to Top" style="display: block;">
            <i class="fa fa-angle-up"></i>
        </button>
    </div>
    <!-- End Back to top -->
</footer>
</body>
</html>
