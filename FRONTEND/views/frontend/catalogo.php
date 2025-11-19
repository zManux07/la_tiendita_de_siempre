<?php include 'header.php'; ?>

<div class="container my-5">
    <h2 class="mb-4">Catálogo de Productos</h2>

    <div class="row">
        <div class="col-md-3 mb-4">
            <h5 class="mb-3">Filtrar por Categoría</h5>
            <div class="list-group">
                <a href="index.php?route=catalogo" class="list-group-item list-group-item-action <?= !isset($_GET['categoria']) ? 'active' : '' ?>">
                    Todas las categorías
                </a>
                <?php
                require_once 'config/Database.php';
                require_once 'models/CategoriaModel.php';

                $db = new Database();
                $conn = $db->connect();
                $categoriaModel = new CategoriaModel($conn);
                $categorias = $categoriaModel->obtenerTodas();

                foreach ($categorias as $cat):
                ?>
                    <a href="index.php?route=catalogo&categoria=<?= $cat['idCATEGORIA'] ?>"
                       class="list-group-item list-group-item-action <?= isset($_GET['categoria']) && $_GET['categoria'] == $cat['idCATEGORIA'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat['nomCATEGORIA']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <?php
                require_once 'models/ProductoModel.php';
                $productoModel = new ProductoModel($conn);

                if (isset($_GET['categoria'])) {
                    $productos = $productoModel->obtenerPorCategoria($_GET['categoria']);
                } else {
                    $productos = $productoModel->obtenerTodos();
                }

                if (empty($productos)):
                ?>
                    <div class="col-12">
                        <div class="alert alert-info">No hay productos disponibles en esta categoría</div>
                    </div>
                <?php else:
                    foreach ($productos as $producto):
                ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 card-hover">
                            <?php if ($producto['fotoPRODUCTO']): ?>
                                <img src="<?= htmlspecialchars($producto['fotoPRODUCTO']) ?>" 
                                class="card-img-top"
                                alt="<?= htmlspecialchars($producto['nomPRODUCTO']) ?>"
                                style="height: 250px; object-fit: contain; background:white;">

                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <span class="text-muted">Sin imagen</span>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($producto['nomPRODUCTO']) ?></h5>
                                <p class="card-text text-muted small"><?= htmlspecialchars($producto['marcaPRODUCTO']) ?></p>
                                <p class="card-text text-secondary small">
                                    <?= htmlspecialchars($producto['nomCATEGORIA']) ?>
                                </p>
                                <p class="text-primary fw-bold fs-5">$<?= number_format($producto['precioPRODUCTO'], 2) ?></p>
                                <p class="text-secondary small">
                                    <?php if ($producto['cantidadenstockPRODUCTO'] > 0): ?>
                                        ✓ Disponible (<?= $producto['cantidadenstockPRODUCTO'] ?> en stock)
                                    <?php else: ?>
                                        <span class="text-danger">✗ Agotado</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="index.php?route=producto&id=<?= $producto['idPRODUCTO'] ?>" class="btn btn-primary btn-sm w-100">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
