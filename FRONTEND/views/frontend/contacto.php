<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="text-center mb-5">Contacto</h2>

            <div class="card shadow mb-5">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Envíanos tu mensaje</h5>

                    <form method="POST" action="index.php?route=mensaje/enviar" class="needs-validation">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono">
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">📞 Teléfono</h5>
                            <p class="card-text">+57 318 256 90 54</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">📧 Email</h5>
                            <p class="card-text">info@tiendita.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">📍 Dirección</h5>
                            <p class="card-text">Barrio La Gaviota, Ibague - Tolima</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
