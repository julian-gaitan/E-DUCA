
</main>
        <!-- Inicio del componente "Footer" -->
        <footer class="bg-dark flex-grow-0 flex-shrink-0">
            <div class="container text-center">
                <div class="row justify-content-center py-3">
                    <div class="col-lg-7">
                        <!-- Elemento "Carusel" que permite rotar los anuncios al usuario -->
                        <div id="carouselAnnouncement" class="carousel slide" data-bs-ride="true">
                            <div class="carousel-inner">
                                <!-- Anuncio numero 1 (ofertas) -->
                                <div class="carousel-item active" data-bs-interval="10000">
                                    <h2>Obtenga 10% de descuento hoy</h2>
                                    <p><em>Aproveche la oferta de vacaciones.</em></p>
                                </div>
                                <!-- Anuncio numero 2 (beneficios) -->
                                <div class="carousel-item" data-bs-interval="10000">
                                    <h2>Pregunte por el plan grupal</h2>
                                    <p><em>Obtenga mayores beneficios de esta manera.</em></p>
                                </div>
                                <!-- Anuncio numero 3 (variedad) -->
                                <div class="carousel-item" data-bs-interval="10000">
                                    <h2>Encuentre lo que desea aprender</h2>
                                    <p><em>Contamos con una gran variedad en nuestra oferta educativa.</em></p>
                                </div>
                                <!-- Espacio para anuncios futuros -->
                                <div class="carousel-item" data-bs-interval="10000">
                                    <h2></h2>
                                    <p><em></em></p>
                                </div>
                            </div>
                            <!-- Botón para permitir ver los anuncios anteriores -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselAnnouncement" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <!-- Botón para permitir ver los anuncios posteriores -->
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselAnnouncement" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <!-- Contenedor que permite alinear los elementos -->
                    <div class="col-10 col-lg-5 d-flex align-items-center">
                        Componente formulario de búsqueda
                        <form class="d-flex flex-grow-1" role="search">
                            <!-- Elemento caja de texto para ingresar la información a buscar -->
                            <input class="form-control me-2" type="search" placeholder="¿Qué deseas aprender?">
                            <!-- Elemento botón para realizar la busquda digitada -->
                            <button class="btn btn-warning px-md-3 px-xl-4 px-xxl-5" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
                <p>E-DUCA &trade;</p>
            </div>
        </footer>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <?php
        $script_name = $_SERVER['SCRIPT_NAME'];
        $script_name = substr($script_name, 0, strrpos($script_name, "/") + 1) . "js" . str_replace(".php", ".js", strrchr($script_name, "/"));
        echo (file_exists($_SERVER['DOCUMENT_ROOT'] . $script_name) ? "<script src=\"$script_name?".time()."\" type=\"module\"></script>" : ""); // ?time() to avoid JS cached problems
          
    ?>
    <script>
        // $("h1:first-child").text("Hola");
    </script>
</body>

</html>