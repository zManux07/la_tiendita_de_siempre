
INSERT INTO usuario (numdocUSUARIO, tipodocumenUSUARIO, nomUSUARIO, direcUSUARIO, telUSUARIO, emailUSUARIO, pass, rolUSUARIO, cargoUSUARIO)
VALUES (123456, 'CC', 'Usuario Demo', 'Direccion 123', 3001234567, 'demo@example.com', 
       '$2y$10$abcdefghijklmnopqrstuv/12345678901234567890123456789012', 'cliente', 'N/A');

INSERT INTO categoria (nomCATEGORIA, descripcionCATEGORIA)
VALUES ('Bebidas', 'Categoría de bebidas'),
       ('Aseo', 'Categoría de aseo'),
       ('Misceláneos', 'Varios productos');

INSERT INTO proveedor (nomPROVEEDOR, telPROVEEDOR, direcPROVEEDOR, emailPROVEEDOR)
VALUES ('Proveedor 1', '3001112233', 'Calle 10 #20-30', 'prov1@example.com'),
       ('Proveedor 2', '3002223344', 'Carrera 15 #40-20', 'prov2@example.com');

INSERT INTO producto (nomPRODUCTO, marcaPRODUCTO, precioPRODUCTO, cantidadenstockPRODUCTO, fechaingrePRODUCTO, unidadMedidaPRODUCTO, fotoPRODUCTO, idCATEGORIA, idPROVEEDOR)
VALUES 
('Coca Cola 1.5L', 'Coca Cola', 5000, 50, CURDATE(), 'Unidad', 'producto1.jpeg', 1, 1),
('Detergente 1Kg', 'Ariel', 12000, 30, CURDATE(), 'Unidad', 'producto2.jpeg', 2, 2),
('Galletas Festival', 'Noel', 3000, 40, CURDATE(), 'Paquete', 'producto6.jpeg', 3, 1);
