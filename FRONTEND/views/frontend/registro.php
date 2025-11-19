<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Crear Nueva Cuenta</h2>

                    <form method="POST" action="index.php?route=auth/registro" class="needs-validation">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipodoc" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="tipodoc" name="tipodocumenUSUARIO" required>
                                    <option value="CC">Cédula</option>
                                    <option value="TI">Tarjeta de Identidad</option>
                                    <option value="PAS">Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numdoc" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control" id="numdoc" name="numdocUSUARIO" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nomUSUARIO" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="emailUSUARIO" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telUSUARIO">
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direcUSUARIO">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass" required minlength="6">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pass_confirm" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" required minlength="6">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Registrarse</button>
                    </form>

                    <hr>
                    <p class="text-center">
                        ¿Ya tienes cuenta? <a href="index.php?route=login">Inicia sesión aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
