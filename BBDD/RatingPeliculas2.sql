
/*-- ELIMINAR BASE DE DATOS Y ROLES SI EXISTEN*/
DROP DATABASE IF EXISTS RatingPeliculasBDD;
DROP ROLE IF EXISTS usuario;
DROP ROLE IF EXISTS administrador;

CREATE DATABASE RatingPeliculasBDD;
USE RatingPeliculasBDD;

-- ===========================
--  Usuario
-- ===========================
CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(70) NOT NULL,
    apellido VARCHAR(70) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    estado ENUM('activo', 'bloqueado') DEFAULT 'activo'
);

-- ===========================
--  Género
-- ===========================
CREATE TABLE Genero (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO Genero (nombre) VALUES 
('Acción'), ('Ciencia Ficción'), ('Drama'), ('Romance'),
('Aventura'), ('Crimen'), ('Histórica'), ('Animación');

-- ===========================
--  Película
-- ===========================
CREATE TABLE Pelicula (
  id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descripcion TEXT,
  anio INT,
  director VARCHAR(100),
  clasificacion ENUM('ATP', 'ATPR', 'P-13', 'P-16', 'P-18') DEFAULT 'ATP',
  duracion VARCHAR(20),
  fecha_agregada DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_genero) REFERENCES Genero(id_genero)
);


INSERT INTO Pelicula (titulo, descripcion, anio, director, clasificacion, duracion)
VALUES
('The Shawshank Redemption', 'Un hombre es encarcelado injustamente y forma una amistad duradera.', 1994, 'Frank Darabont', 'B', '2h 22m'),
('The Godfather', 'El ascenso de una familia mafiosa.', 1972, 'Francis Ford Coppola', '+13', '2h 55m'),
('Inception', 'Un ladrón que roba secretos del subconsciente.', 2010, 'Christopher Nolan', '+13', '2h 28m'),
('The Dark Knight', 'Batman enfrenta al Joker.', 2008, 'Christopher Nolan', '+13', '2h 32m'),
('Pulp Fiction', 'Historias cruzadas de crimen y redención.', 1994, 'Quentin Tarantino', '+16', '2h 34m'),
('Forrest Gump', 'Un hombre simple que marca la historia.', 1994, 'Robert Zemeckis', 'ATP', '2h 22m'),
('Titanic', 'Una historia de amor en el trágico hundimiento.', 1997, 'James Cameron', '+13', '3h 14m'),
('Avatar', 'Un ex-marine en un mundo alienígena.', 2009, 'James Cameron', '+13', '2h 42m'),
('The Matrix', 'La realidad es una simulación.', 1999, 'Lana Wachowski', '+13', '2h 16m'),
('Toy Story', 'Los juguetes cobran vida.', 1995, 'John Lasseter', 'ATP', '1h 21m');


CREATE TABLE Pelicula_Genero (
    id_pelicula INT,
    id_genero INT,
    PRIMARY KEY (id_pelicula, id_genero),
    FOREIGN KEY (id_pelicula) REFERENCES Pelicula(id_pelicula),
    FOREIGN KEY (id_genero) REFERENCES Genero(id_genero)
);
INSERT INTO Pelicula_Genero (id_pelicula, id_genero)
VALUES
(1, 3), -- Shawshank: Drama
(2, 6), -- Godfather: Crimen
(3, 2), -- Inception: Ciencia Ficción
(3, 1), -- Inception: Acción
(4, 1), -- Dark Knight: Acción
(4, 6), -- Dark Knight: Crimen
(5, 6), -- Pulp Fiction: Crimen
(6, 3), -- Forrest Gump: Drama
(7, 4), -- Titanic: Romance
(8, 2), -- Avatar: Ciencia Ficción
(9, 2), -- Matrix: Ciencia Ficción
(10, 8); -- Toy Story: Animación
-- ===========================
-- ⭐ Calificación
-- ===========================
CREATE TABLE Calificacion (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 10),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_pelicula) REFERENCES Pelicula(id_pelicula),
    UNIQUE (id_usuario, id_pelicula)
);

-- ===========================
--  Comentario
-- ===========================
CREATE TABLE Comentario (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT,
    contenido TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_pelicula) REFERENCES Pelicula(id_pelicula)
);

-- ========================
-- TABLA: Palabras Prohibidas
-- ========================
CREATE TABLE PalabrasProhibidas (
    id_palabra INT AUTO_INCREMENT PRIMARY KEY,
    palabra VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO PalabrasProhibidas (palabra) VALUES 
('tonto'),
('idiota'),
('mierda'),
('negro'),
('estúpido'),
('imbécil'),
('burro'),
('perra'),
('asqueroso'),
('maldito');

-- ========================
-- VISTA: Promedio de puntuaciones
-- ========================
CREATE VIEW Vista_Puntuaciones AS
SELECT 
    p.titulo,
    ROUND(AVG(c.puntuacion), 2) AS promedio_puntuacion,
    COUNT(c.id_calificacion) AS total_calificaciones
FROM Pelicula p
LEFT JOIN Calificacion c ON p.id_pelicula = c.id_pelicula
GROUP BY p.id_pelicula;

-- ========================
-- VISTA: Comentarios moderados
-- ========================
CREATE VIEW Vista_ComentariosModerados AS
SELECT 
    u.nombre AS usuario,
    p.titulo AS pelicula,
    REPLACE(REPLACE(REPLACE(REPLACE(
    REPLACE(REPLACE(REPLACE(REPLACE(
    REPLACE(REPLACE(LOWER(c.contenido),
        'tonto', '***'),
        'idiota', '***'),
        'mierda', '***'),
        'negro', '***'),
        'estúpido', '***'),
        'imbécil', '***'),
        'burro', '***'),
        'perra', '***'),
        'asqueroso', '***'),
        'maldito', '***') AS comentario,
    c.fecha
FROM Comentario c
JOIN Usuario u ON u.id_usuario = c.id_usuario
JOIN Pelicula p ON p.id_pelicula = c.id_pelicula;


-- ========================
-- VISTA: Top 10 películas
-- ========================
CREATE VIEW Vista_Top5 AS
SELECT 
    p.titulo,
    ROUND(AVG(c.puntuacion), 2) AS promedio
FROM Pelicula p
JOIN Calificacion c ON p.id_pelicula = c.id_pelicula
GROUP BY p.id_pelicula
ORDER BY promedio DESC
LIMIT 5;

-- ========================
-- TRIGGER: Log de calificaciones
-- ========================
CREATE TABLE LogCalificaciones (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT,
    puntuacion INT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER tr_log_calificacion
AFTER INSERT ON Calificacion
FOR EACH ROW
BEGIN
    INSERT INTO LogCalificaciones (id_usuario, id_pelicula, puntuacion)
    VALUES (NEW.id_usuario, NEW.id_pelicula, NEW.puntuacion);
END;
//
DELIMITER ;

-- ========================
-- TRIGGER: Auditoría de estado de usuarios
-- ========================
CREATE TABLE Auditoria_Usuarios (
    id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    accion VARCHAR(50),
    ejecutado_por INT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER tr_auditar_estado_usuario
AFTER UPDATE ON Usuario
FOR EACH ROW
BEGIN
    IF OLD.estado <> NEW.estado THEN
        INSERT INTO Auditoria_Usuarios (id_usuario, accion, ejecutado_por)
        VALUES (NEW.id_usuario, NEW.estado, NULL);
    END IF;
END;
//
DELIMITER ;

-- ========================
-- TRIGGER: Bloqueo de comentarios ofensivos
-- ========================
DELIMITER //
CREATE TRIGGER tr_bloquear_insultos
BEFORE INSERT ON Comentario
FOR EACH ROW
BEGIN
  IF LOWER(NEW.contenido) REGEXP 'tonto|idiota|mierda|negro' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Comentario contiene lenguaje ofensivo.';
  END IF;
END;
//
DELIMITER ;

-- ========================
-- ÍNDICES
-- ========================
CREATE INDEX idx_email_usuario ON Usuario(email);
CREATE INDEX idx_titulo_pelicula ON Pelicula(titulo);
CREATE INDEX idx_puntaje_usuario_pelicula ON Calificacion(id_usuario, id_pelicula);

-- ========================
-- ROLES Y PERMISOS
-- ========================
CREATE ROLE IF NOT EXISTS usuario;
CREATE ROLE IF NOT EXISTS administrador;

GRANT SELECT, INSERT, UPDATE ON Calificacion TO usuario;
GRANT SELECT, INSERT, UPDATE ON Comentario TO usuario;
GRANT SELECT ON Pelicula TO usuario;

GRANT SELECT, INSERT, UPDATE ON Pelicula TO administrador;
GRANT SELECT, INSERT, UPDATE ON Genero TO administrador;
GRANT SELECT, UPDATE ON Usuario TO administrador;