DROP DATABASE IF EXISTS libreria;
CREATE DATABASE libreria;
USE libreria;

CREATE TABLE trabajador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    entrada INT DEFAULT 0,
    salida INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    precio INT NOT NULL,
    imagen VARCHAR(500),
    categoria_id INT -- Agregamos esto para que el catálogo funcione después
);

USE libreria;

-- Para que funcione tu index.php (Asistencias)
-- El ON DELETE CASCADE es un seguro de limpieza:
-- Si algún día borramos a un trabajador de la tabla trabajador, el sistema borrará automáticamente todas sus asistencias de esta tabla. Así no quedan "datos huérfanos" ocupando espacio sin pertenecer a nadie.
CREATE TABLE asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trabajador_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME,
    hora_salida TIME,
    estado VARCHAR(50) DEFAULT 'Presente',
    FOREIGN KEY (trabajador_id) REFERENCES trabajador(id) ON DELETE CASCADE
);

CREATE TABLE alquileres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    total_pago INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES producto(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, email, password) 
VALUES ('Marco', 'marcoesteban116@hotmail.com', '123456');

INSERT INTO usuarios (nombre, email, password) 
VALUES ('Marco', 'marcoesteban777@gmail.com', '123456');



USE libreria;


INSERT INTO categorias (nombre) VALUES 
('Fantasía'), 
('Terror'), 
('Clásicos'), 
('Aventura');

ALTER TABLE producto MODIFY COLUMN precio DECIMAL(10,2) NOT NULL;
ALTER TABLE alquileres MODIFY COLUMN total_pago DECIMAL(10,2) NOT NULL;

INSERT INTO producto (id, titulo, descripcion, precio, imagen, categoria_id) VALUES  
(1, 'Cien años de soledad', 'Alquiler por 30 días. Formato Digital.', 3.99, 'https://m.media-amazon.com/images/I/81WojUM97dL.jpg', 3);


SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO trabajador (nombre, email, password, entrada, salida) 
VALUES ('admin', 'admin@libreria.com', '123456', 0, 0);


-- Desactivar verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Vaciar completamente la tabla producto
TRUNCATE TABLE producto;

-- Volver a activar las claves foráneas
SET FOREIGN_KEY_CHECKS = 1;