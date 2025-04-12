-- Active: 1744469964834@@127.0.0.1@3307@cursos
CREATE DATABASE IF NOT EXISTS cursos;
USE cursos;

CREATE TABLE categorias(
	id INT PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(50) NOT NULL
)ENGINE=INNODB; 

CREATE TABLE cursos (
	id INT PRIMARY KEY AUTO_INCREMENT,
	titulo VARCHAR(100) NOT NULL,
    duracionhoras TIME,
    nivel ENUM('basico', 'intermedio', 'avanzado') NOT NULL,
    precio DECIMAL(8,2),
    fechainicio DATETIME,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=INNODB;

INSERT INTO categorias (categoria) VALUES
('Programación'),
('Diseño Gráfico'),
('Marketing Digital'),
('Desarrollo Web'),
('Finanzas'),
('Idiomas'),
('Ofimática'),
('Ciberseguridad'),
('Bases de Datos'),
('Inteligencia Artificial');

