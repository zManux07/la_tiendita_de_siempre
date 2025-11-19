<?php include 'header.php'; ?>

<div class="hero-banner bg-primary-blue text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Bienvenido a La Tiendita de Siempre</h1>
        <p class="lead mb-4">Encuentra los mejores productos de tu preferencia</p>
        <a href="index.php?route=catalogo" class="btn btn-light btn-lg">Ver Catálogo</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-5">Productos Destacados</h2>
    <div class="row">
        <?php
        require_once 'config/Database.php';
        require_once 'models/ProductoModel.php';

        $db = new Database();
        $conn = $db->connect();
        $productoModel = new ProductoModel($conn);
        $productos = $productoModel->obtenerDestacados();

        foreach (array_slice($productos, 0, 6) as $producto):
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 card-hover">
                    <?php if ($producto['fotoPRODUCTO']): ?>
                        <?php if ($producto['fotoPRODUCTO']): ?>
    <img src="<?= htmlspecialchars($producto['fotoPRODUCTO']) ?>" 
         class="card-img-top producto-img" 
         alt="<?= htmlspecialchars($producto['nomPRODUCTO']) ?>">
<?php else: ?>
    <div class="card-img-top bg-light d-flex align-items-center justify-content-center producto-img">
        <span class="text-muted">Sin imagen</span>
                </div>
                <?php endif; ?>

                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">Sin imagen</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nomPRODUCTO']) ?></h5>
                        <p class="card-text text-muted small"><?= htmlspecialchars($producto['marcaPRODUCTO']) ?></p>
                        <p class="text-primary fw-bold">$<?= number_format($producto['precioPRODUCTO'], 2) ?></p>
                        <p class="text-secondary small">Stock: <?= $producto['cantidadenstockPRODUCTO'] ?></p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="index.php?route=producto&id=<?= $producto['idPRODUCTO'] ?>" class="btn btn-primary btn-sm w-100">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">¿Por qué elegirnos?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">✓</div>
                <h5>Productos de Calidad</h5>
                <p>Seleccionamos cuidadosamente cada artículo</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">✓</div>
                <h5>Precios Competitivos</h5>
                <p>Los mejores precios del mercado</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">✓</div>
                <h5>Atención Personalizada</h5>
                <p>Estamos aquí para ayudarte</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
