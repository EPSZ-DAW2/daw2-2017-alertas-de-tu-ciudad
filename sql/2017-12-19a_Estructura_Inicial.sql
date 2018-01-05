
-- Model: DAW2-Alertas    Version: 1.0

-- Proyecto en Grupo - Alertas de tu Ciudad.
-- Desarrollo de Aplicaciones Web II.
-- Escuela Politécnica Superior de Zamora.
-- Universidad de Salamanca.
-- 

-- -----------------------------------------------------
-- Schema daw2_alertas
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `daw2_alertas` ;

-- -----------------------------------------------------
-- Schema daw2_alertas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `daw2_alertas` DEFAULT CHARACTER SET utf8 ;
USE `daw2_alertas` ;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`alertas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`alertas` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`alertas` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` TEXT NOT NULL COMMENT 'Titulo corto para la alerta.',
  `descripcion` TEXT NULL COMMENT 'Descripción breve de la alerta o NULL si no es necesaria.',
  `fecha_inicio` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de inicio/activación de la alerta o NULL si no se conoce (mostrar próximamente).',
  `duracion_estimada` INT(6) NOT NULL DEFAULT '0' COMMENT 'Tiempo en Minutos de duración estimada de la alerta, si es CERO no se conoce o no es relevante.',
  `direccion` TEXT NULL DEFAULT NULL COMMENT 'Dirección concreta del lugar de la alerta o NULL si no se conoce, aunque no debería estar vacío este dato.',
  `notas_lugar` TEXT NULL DEFAULT NULL COMMENT 'Notas adicionales sobre el lugar de la alerta que no forman parte de la dirección o de las indicaciones, o NULL si no hay.',
  `area_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Area/Zona de la alerta o CERO si no existe o aún no está indicado (como si fuera NULL).',
  `detalles` TEXT NULL DEFAULT NULL COMMENT 'Detalles de la alerta si es necesario o NULL si no hay.',
  `notas` TEXT NULL DEFAULT NULL COMMENT 'Notas adicionales sobre la alerta que no forman parte de las posibles notas anteriores o NULL si no hay.',
  `url` TEXT NULL DEFAULT NULL COMMENT 'Dirección web externa (opcional) que enlaza con otra página o NULL si no hay.',
  `imagen_id` VARCHAR(40) NULL COMMENT 'Nombre identificativo (fichero interno) con la imagen principal o \"de presentación\" de la alerta, o NULL si no hay.',
  `imagen_revisada` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.',
  `categoria_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Categoría de la alerta o CERO si no existe o aún no está indicada (como si fuera NULL).' ,
  `activada` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Indicador de alerta para mostrar la alerta a los usuarios o solo para los creadores/administraddores: 0=Desactivada, 1=Activa.',
  `visible` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Indicador de alerta visible a los usuarios o invisible (se está manteniendo): 0=Invisible, 1=Visible.',
  `terminada` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de alerta terminada: 0=No, 1=Realizada, 2=Suspendida, 3=Cancelada por Inadecuada, ...',
  `fecha_terminacion` DATETIME NULL COMMENT 'Fecha y Hora de terminación de la alerta. Debería estar a NULL si no está terminada.',
  `notas_terminacion` TEXT NULL DEFAULT NULL COMMENT 'Notas visibles sobre el motivo de la terminación de la alerta.',
  `num_denuncias` INT(9) NOT NULL DEFAULT '0' COMMENT 'Contador de denuncias de la alerta o CERO si no ha tenido.',
  `fecha_denuncia1` DATETIME NULL COMMENT 'Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.',
  `bloqueada` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de alerta bloqueada: 0=No, 1=Si(bloqueada por denuncias), 2=Si(bloqueada por administrador), 3=Si(bloqueada por moderador), ...',
  `bloqueo_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha bloqueado la alerta o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` DATETIME NULL COMMENT 'Fecha y Hora del bloqueo de la alerta. Debería estar a NULL si no está bloqueada o si se desbloquea.',
  `bloqueo_notas` TEXT NULL DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo de la alerta o NULL si no hay -se muestra por defecto según indique \"bloqueada\"-.',
  `crea_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.',
  `notas_admin` TEXT NULL COMMENT 'Notas adicionales para los administradores sobre la alerta o NULL si no hay.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`areas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`areas` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`areas` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clase_area_id` CHAR(1) NOT NULL COMMENT 'Código de clase de area: 0=Planeta, 1=Continente, 2=Pais, 3=Estado, 4=Region, 5=Provincia, 6=Municipio, 7=Localidad, 8=Barrio, 9=Zona, ...',
  `nombre` VARCHAR(50) NOT NULL COMMENT 'Nombre del area que lo identifica.',
  `area_id` INT(12) UNSIGNED NULL DEFAULT 0 COMMENT 'Area relacionada. Nodo padre de la jerarquia o CERO si es nodo raiz.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`alerta_imagenes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`alerta_imagenes` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`alerta_imagenes` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alerta_id` INT(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `orden` INT(3) NOT NULL DEFAULT '0' COMMENT 'Orden de aparición de la imagen dentro del grupo de imagenes de la alerta. Opcional.',
  `imagen_id` VARCHAR(40) NOT NULL COMMENT 'Nombre identificativo (fichero interno) con la imagen para la alerta, aqui no puede ser NULL si no hay.',
  `imagen_revisada` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.',

  `crea_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.',
  `notas_admin` TEXT NULL COMMENT 'Notas adicionales para los administradores sobre la alerta o NULL si no hay.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`etiquetas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`etiquetas` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`etiquetas` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`alerta_etiquetas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`alerta_etiquetas` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`alerta_etiquetas` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alerta_id` INT(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `etiqueta_id` INT(12) UNSIGNED NOT NULL COMMENT 'Etiqueta relacionada.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`categorias` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`categorias` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(25) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL COMMENT 'Texto adicional que describe la categoria o clasificación para las etiquetas que engloba.',
  `categoria_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Categoria relacionada. Nodo padre de la jerarquia o CERO si es nodo raiz.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `daw2_alertas`.`clasificacion_etiquetas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`categorias_etiquetas` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`categorias_etiquetas` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria_id` INT(12) UNSIGNED NOT NULL COMMENT 'Clasificacion relacionada, para saber a que grupo pertenece.',
  `etiqueta_id` INT(12) UNSIGNED NOT NULL COMMENT 'Etiqueta relacionada.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`alerta_comentarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`alerta_comentarios` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`alerta_comentarios` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alerta_id` INT(12) UNSIGNED NOT NULL COMMENT 'Alerta relacionada',
  `crea_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha creado el comentario o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `crea_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de creación del comentario o NULL si no se conoce por algún motivo.',
  `modi_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha modificado el comentario por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.',
  `modi_fecha` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de la última modificación del comentario o NULL si no se conoce por algún motivo.',
  `texto` TEXT NOT NULL COMMENT 'El texto del comentario.',
  `comentario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Comentario relacionado, si se permiten encadenar respuestas. Nodo padre de la jerarquia de comentarios, CERO si es nodo raiz.',
  `cerrado` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de cierre de los comentarios: 0=No, 1=Si(No se puede responder al comentario)',
  `num_denuncias` INT(9) NOT NULL DEFAULT '0' COMMENT 'Contador de denuncias del comentario o CERO si no ha tenido.',
  `fecha_denuncia1` DATETIME NULL COMMENT 'Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.',
  `bloqueado` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de comentario bloqueado: 0=No, 1=Si(bloqueado por denuncias), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...',
  `bloqueo_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha bloqueado el comentario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` DATETIME NULL COMMENT 'Fecha y Hora del bloqueo del comentario. Debería estar a NULL si no está bloqueado o si se desbloquea.',
  `bloqueo_notas` TEXT NULL DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo del comentario o NULL si no hay -se muestra por defecto según indique \"bloqueado\"-.',  
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`usuarios` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL COMMENT 'Correo Electronico y \"login\" del usuario.',
  `password` VARCHAR(60) NOT NULL,
  `nick` VARCHAR(25) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL COMMENT 'Fecha de nacimiento del usuario o NULL si no lo quiere informar.',
  `direccion` TEXT NULL COMMENT 'Direccion del usuario o NULL si no quiere informar.',
  `area_id` INT(12) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Area/Zona de localización del usuario o CERO si no lo quiere informar (como si fuera NULL), aunque es recomendable.',
  `rol` CHAR(1) NOT NULL COMMENT 'Código de la Clase / Tipo de Perfil: N=Normal, M=Moderador, A=Administrador',
  `fecha_registro` DATETIME NULL COMMENT 'Fecha y Hora de registro del usuario o NULL si no se conoce por algún motivo (que no debería ser).',
  `confirmado` TINYINT(1) NOT NULL COMMENT 'Indicador de usuario ha confirmado su registro o no.',
  `fecha_acceso` DATETIME NULL COMMENT 'Fecha y Hora del ultimo acceso del usuario. Debería estar a NULL si no ha accedido nunca.',
  `num_accesos` INT(9) NOT NULL DEFAULT '0' COMMENT 'Contador de accesos fallidos del usuario o CERO si no ha tenido o se ha reiniciado por un acceso valido o por un administrador.',
  `bloqueado` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indicador de usuario bloqueado: 0=No, 1=Si(bloqueado por fallos de acceso), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...',
  `bloqueo_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario que ha bloqueado el usuario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.',
  `bloqueo_fecha` DATETIME NULL COMMENT 'Fecha y Hora del bloqueo del usuario. Debería estar a NULL si no está bloqueado o si se desbloquea.',
  `bloqueo_notas` TEXT NULL DEFAULT NULL COMMENT 'Notas visibles sobre el motivo del bloqueo del usuario o NULL si no hay -se muestra por defecto según indique \"bloqueado\"-.',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `nick_UNIQUE` (`nick` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`usuarios_area_moderacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`usuarios_area_moderacion` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`usuarios_area_moderacion` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(12) UNSIGNED NOT NULL COMMENT 'Usuario relacionado con un Area para su moderación.',
  `area_id` INT(12) UNSIGNED NOT NULL COMMENT 'Area relacionada con el Usuario que puede moderarla.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`usuario_incidencias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`usuario_incidencias` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`usuario_incidencias` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `crea_fecha` DATETIME NOT NULL COMMENT 'Fecha y Hora de creación de la incidencia.',
  `clase_incidencia_id` CHAR(1) NOT NULL DEFAULT 'M' COMMENT 'código de clase de incidencia: A=Aviso, N=Notificación, D=Denuncia, C=Consulta, M=Mensaje Genérico,...',
  `texto` TEXT NULL COMMENT 'Texto con el mensaje de incidencia.',
  `destino_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario relacionado, destinatario de la incidencia, o NULL si no es para administración y no está gestionado.',
  `origen_usuario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Usuario relacionado, origen de la incidencia, o NULL si es del sistema.',
  `alerta_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'alerta relacionada o NULL si no tiene que ver con una alerta.',
  `comentario_id` INT(12) UNSIGNED NULL DEFAULT '0' COMMENT 'Comentario relacionado o NULL si no tiene que ver con un comentario.',
  `fecha_lectura` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de lectura de la incidencia o NULL si no se ha leido o se ha desmarcado como tal.',
  `fecha_borrado` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de la marca de borrado de la incidencia o NULL si no se ha marcado como borrado.',
  `fecha_aceptado` DATETIME NULL DEFAULT NULL COMMENT 'Fecha y Hora de aceptación de la incidencia o NULL si no se ha aceptado para su gestión por un moderador o administrador. No se usa en otros usuarios.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `daw2_alertas`.`configuraciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`configuraciones` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`configuraciones` (
  `variable` VARCHAR(40) NOT NULL,
  `valor` TEXT NULL,
  PRIMARY KEY (`variable`))
ENGINE = InnoDB;

INSERT INTO `daw2_alertas`.`configuraciones` (variable, valor) 
VALUES 
('numero_alertas_portada','30'),
('numero_lineas_pagina','25'),
('numero_denuncias_alerta','7'),
('numero_denuncias_comentario','3'),
('numero_intentos_usuario','5'),
('dias_incidencias_leidas','60'),
('dias_incidencias_borradas','30');


-- -----------------------------------------------------
-- Table `daw2_alertas`.`logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `daw2_alertas`.`logs` ;

CREATE TABLE IF NOT EXISTS `daw2_alertas`.`logs` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `crea_fecha` DATETIME NOT NULL COMMENT 'Fecha y Hora del mensaje de LOG.',
  `clase_log_id` CHAR(1) NOT NULL COMMENT 'código de clase de log: E=Error, A=Aviso, S=Seguimiento, I=Información, D=Depuración, ...',
  `modulo` VARCHAR(40) NULL DEFAULT 'app' COMMENT 'Modulo o Sección de la aplicación que ha generado el mensaje de LOG.',
  `texto` TEXT NULL COMMENT 'Texto con el mensaje de LOG.',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
