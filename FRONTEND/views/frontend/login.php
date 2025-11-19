<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>

                    <form method="POST" action="index.php?route=auth/login" class="needs-validation">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>
                    </form>

                    <hr>
                    <p class="text-center">
                        ¿No tienes cuenta? <a href="index.php?route=registro">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
