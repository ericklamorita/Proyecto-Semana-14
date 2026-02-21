CREATE DATABASE libreria;
USE libreria;

-- Tabla de trabajador
CREATE TABLE trabajador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    entrada INT NOT NULL,
    salida INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de producto
CREATE TABLE producto (
	id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    precio INT NOT NULL,
    imagen VARCHAR(500)
    );
    

INSERT INTO categorias (nombre) VALUES ('PHP');
INSERT INTO categorias (nombre) VALUES ('HTML');
INSERT INTO categorias (nombre) VALUES ('CSS');

SELECT * FROM usuarios;

insert INTO usuarios (nombre, email, password) VALUES ('Marco', 'marcoesteban116@hotmail.com', '123456');