/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- ----------------------------------------------------------------------
-- 1) ELIMINAMOS LAS TABLAS (ORDEN INVERSO A LAS FKs)
-- ----------------------------------------------------------------------
DROP TABLE IF EXISTS `transfer_reservas`;
DROP TABLE IF EXISTS `transfer_precios`;
DROP TABLE IF EXISTS `transfer_viajeros`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `transfer_vehiculo`;
DROP TABLE IF EXISTS `transfer_hotel`;
DROP TABLE IF EXISTS `transfer_tipo_reserva`;
DROP TABLE IF EXISTS `transfer_zona`;

-- ----------------------------------------------------------------------
-- 2) CREAMOS TABLAS EN ORDEN MAESTRO → DEPENDIENTES
-- ----------------------------------------------------------------------

-- ==========================
-- Table: transfer_zona
-- ==========================
CREATE TABLE `transfer_zona` (
  `id_zona` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_zona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_hotel
-- id_hotel -> VARCHAR(50)
-- ==========================
CREATE TABLE `transfer_hotel` (
  `id_hotel` VARCHAR(50) NOT NULL,
  `id_zona` INT DEFAULT NULL,
  `Comision` INT DEFAULT NULL,
  `usuario` INT DEFAULT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_hotel`),  -- Quitar auto_increment, ahora es PK de tipo VARCHAR
  KEY `FK_HOTEL_ZONA` (`id_zona`),
  CONSTRAINT `FK_HOTEL_ZONA`
    FOREIGN KEY (`id_zona`) 
    REFERENCES `transfer_zona` (`id_zona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_vehiculo
-- id_vehiculo -> VARCHAR(50)
-- ==========================
CREATE TABLE `transfer_vehiculo` (
  `id_vehiculo` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `email_conductor` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_vehiculo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_tipo_reserva
-- ==========================
CREATE TABLE `transfer_tipo_reserva` (
  `id_tipo_reserva` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_tipo_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: usuarios
-- ==========================
CREATE TABLE `usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(100) DEFAULT NULL,
  `rol` ENUM('particular','corporativo','admin') NOT NULL DEFAULT 'particular',
  `creado_en` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_viajeros
-- ==========================
CREATE TABLE `transfer_viajeros` (
  `id_viajero` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido1` VARCHAR(100) NOT NULL,
  `apellido2` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `codigoPostal` VARCHAR(100) NOT NULL,
  `ciudad` VARCHAR(100) NOT NULL,
  `pais` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_viajero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_precios
--  id_vehiculo -> VARCHAR(50)
--  id_hotel    -> VARCHAR(50)
-- ==========================
CREATE TABLE `transfer_precios` (
  `id_precios` INT NOT NULL AUTO_INCREMENT,
  `id_vehiculo` VARCHAR(50) NOT NULL,
  `id_hotel` VARCHAR(50) NOT NULL,
  `Precio` INT NOT NULL,
  PRIMARY KEY (`id_precios`),
  KEY `FK_PRECIOS_HOTEL` (`id_hotel`),
  KEY `FK_PRECIOS_VEHICULO` (`id_vehiculo`),
  CONSTRAINT `FK_PRECIOS_HOTEL` 
    FOREIGN KEY (`id_hotel`) 
    REFERENCES `transfer_hotel` (`id_hotel`),
  CONSTRAINT `FK_PRECIOS_VEHICULO`
    FOREIGN KEY (`id_vehiculo`)
    REFERENCES `transfer_vehiculo` (`id_vehiculo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ==========================
-- Table: transfer_reservas
--  id_hotel, id_destino -> VARCHAR(50)
--  id_vehiculo -> VARCHAR(50)
-- ==========================
CREATE TABLE `transfer_reservas` (
  `id_reserva` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `localizador` VARCHAR(100) NOT NULL,
  `id_hotel` VARCHAR(50) DEFAULT NULL COMMENT 'Hotel que realiza la reserva',
  `id_tipo_reserva` INT NOT NULL,
  `email_cliente` VARCHAR(100) NOT NULL,
  `fecha_reserva` DATETIME NOT NULL,
  `fecha_modificacion` DATETIME NOT NULL,
  `id_destino` VARCHAR(50) NOT NULL,  -- también VARCHAR(50)
  `fecha_entrada` DATE NOT NULL,
  `hora_entrada` TIME NOT NULL,
  `numero_vuelo_entrada` VARCHAR(50) NOT NULL,
  `origen_vuelo_entrada` VARCHAR(50) NOT NULL,
  `hora_vuelo_salida` TIME NOT NULL,
  `fecha_vuelo_salida` DATE NOT NULL,
  `numero_vuelo_salida` VARCHAR(50) DEFAULT NULL,
  `hora_recogida` TIME DEFAULT NULL,
  `num_viajeros` INT NOT NULL,
  `id_vehiculo` VARCHAR(50) NOT NULL,
  `creado_por` ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',  -- Nueva columna
  PRIMARY KEY (`id_reserva`),
  KEY `FK_RESERVAS_DESTINO` (`id_destino`),
  KEY `FK_RESERVAS_HOTEL` (`id_hotel`),
  KEY `FK_RESERVAS_TIPO` (`id_tipo_reserva`),
  KEY `FK_RESERVAS_VEHICULO` (`id_vehiculo`),
  KEY `fk_usuario_reserva` (`id_usuario`),
  CONSTRAINT `FK_RESERVAS_DESTINO` 
    FOREIGN KEY (`id_destino`) 
    REFERENCES `transfer_hotel` (`id_hotel`),
  CONSTRAINT `FK_RESERVAS_HOTEL` 
    FOREIGN KEY (`id_hotel`) 
    REFERENCES `transfer_hotel` (`id_hotel`),
  CONSTRAINT `FK_RESERVAS_TIPO` 
    FOREIGN KEY (`id_tipo_reserva`) 
    REFERENCES `transfer_tipo_reserva` (`id_tipo_reserva`),
  CONSTRAINT `FK_RESERVAS_VEHICULO` 
    FOREIGN KEY (`id_vehiculo`) 
    REFERENCES `transfer_vehiculo` (`id_vehiculo`),
  CONSTRAINT `fk_usuario_reserva`
    FOREIGN KEY (`id_usuario`) 
    REFERENCES `usuarios` (`id_usuario`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------------------
-- 3) INSERTAMOS DATOS DE EJEMPLO
-- ----------------------------------------------------------------------

-- Insertamos algunas zonas (ejemplo):
INSERT INTO `transfer_zona` (descripcion) VALUES
('Zona Norte'),
('Zona Sur'),
('Zona Este'),
('Zona Oeste'),
('Zona Centro');


-- Insertamos 5 ejemplos en transfer_hotel
-- (id_hotel es ahora varchar(50))
INSERT INTO `transfer_hotel` (`id_hotel`, `id_zona`, `Comision`, `usuario`, `password`) VALUES
('HOTEL_BAHIA',  1, 10,   111, 'hotel1pass'),
('HOTEL_SOL',    2, 15,   112, 'hotel2pass'),
('HOTEL_MAR',    3, 12,   113, 'hotel3pass'),
('HOTEL_MONTAÑA',   4, 18,   114, 'hotel4pass'),
('HOTEL_CIUDAD',   5, 20,   115, 'hotel5pass');

-- Insertamos 5 ejemplos en transfer_vehiculo
-- (id_vehiculo es varchar(50))
INSERT INTO `transfer_vehiculo` (`id_vehiculo`, `descripcion`, `email_conductor`, `password`) VALUES
('VEH_VAN1', 'Van de 8 plazas', 'conductor1@empresa.com', 'van1pass'),
('VEH_MINI2', 'Minibus', 'conductor2@empresa.com', 'mini2pass'),
('VEH_SEDAN3', 'Sedán Confort', 'conductor3@empresa.com', 'sedan3pass'),
('VEH_LUX4', 'Luxury Car', 'conductor4@empresa.com', 'lux4pass'),
('VEH_BUS5', 'Autobús 25 pax', 'conductor5@empresa.com', 'bus5pass');

-- Insertamos algunos tipos de reserva
INSERT INTO `transfer_tipo_reserva` (descripcion) VALUES
('Aeropuerto-Hotel'),
('Hotel-Aeropuerto'),
('Ida y Vuelta');

-- Insertamos algunos usuarios de prueba
INSERT INTO `usuarios` (email, password, nombre, rol) VALUES
('rafa@gmail.com', '$2y$10$kDh/j2pGfa8WhjaUH3IL7uHZF7DcwKQKv1jcamyUYzVP5BnxiIo2y', 'Rafa Admin', 'admin'),
('rballestercoll@gmail.com', '$2y$10$jEXl7YrVE3iMnQ.Zzes5ae/R7ZQhnLgugiEGq2pkqkT732rT7wiKW', 'Rafa Particular', 'particular'),
('rafaelius@gmail.com', '$2y$10$AQLYE70rNDo.3yu1bh.Bte/pXFM1cniCSFEGcL6ViMZs1xR9mpj9S', 'Rafa Corporativo', 'corporativo');

-- [Opcional: insertar en transfer_reservas o transfer_precios si deseas datos iniciales]
-- Por ejemplo, un precio ejemplo:
INSERT INTO `transfer_precios` (id_vehiculo, id_hotel, Precio) VALUES
('VEH_VAN1', 'HOTEL_BAHIA', 35),
('VEH_MINI2', 'HOTEL_SOL', 40),
('VEH_SEDAN3', 'HOTEL_MAR', 45),
('VEH_LUX4', 'HOTEL_MONTAÑA', 60),
('VEH_BUS5', 'HOTEL_CIUDAD', 75);


-- ----------------------------------------------------------------------
-- FIN DEL SCRIPT
-- ----------------------------------------------------------------------

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
