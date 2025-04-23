-- Eliminar la base de datos si existe.
DROP DATABASE IF EXISTS sanidad;

-- Crear la base de datos.
CREATE DATABASE IF NOT EXISTS sanidad COMMENT 'Base de datos para gestionar usuarios, materiales y modificaciones de sanidad';

-- Seleccionar la base de datos 'sanidad' para su uso.
USE sanidad;

-- Establecer InnoDB como motor de la base de datos.
SET default_storage_engine = InnoDB;

-- Crear la tabla de usuarios.
CREATE TABLE usuarios (
    id_usuario      VARCHAR(40)                 NOT NULL COMMENT 'Identificador del usuario',
    nombre          VARCHAR(40)                 NOT NULL COMMENT 'Nombre del usuario',
    apellidos       VARCHAR(40)                 NOT NULL COMMENT 'Apellidos del usuario',
    fecha_alta      DATE                        NOT NULL COMMENT 'Fecha de alta del usuario',
    tipo_usuario    ENUM('alumno', 'docente')   NOT NULL COMMENT 'Tipo de usuario',
    PRIMARY KEY (id_usuario)
);

-- Crear la tabla de materiales.
CREATE TABLE materiales (
    id_material     VARCHAR(40)     NOT NULL COMMENT 'Identificador del material',
    nombre          VARCHAR(100)    NOT NULL COMMENT 'Nombre del material',
<<<<<<< HEAD
    descripcion     VARCHAR(255)    NOT NULL COMMENT 'Descripción del material',
=======
    descripcion     VARCHAR(150)    NOT NULL COMMENT 'Descripción del material',
>>>>>>> 7e26924e0143c84eb5a3258a89828d6c14c2ab3c
    PRIMARY KEY (id_material)
);

-- Crear la tabla de almacenamiento.
CREATE TABLE almacenamiento (
    id_material     VARCHAR(40)             NOT NULL COMMENT 'Identificador del material',
    tipo_almacen    ENUM('uso', 'reserva')  NOT NULL COMMENT 'Tipo de almacenamiento',
    armario         INT UNSIGNED            NOT NULL COMMENT 'Número de armario',
    balda           INT UNSIGNED            NOT NULL COMMENT 'Número de balda',
    unidades        INT UNSIGNED            NOT NULL COMMENT 'Cantidad de unidades',
    min_unidades    INT UNSIGNED            NOT NULL COMMENT 'Cantidad mínima de unidades',
    PRIMARY KEY (id_material, tipo_almacen),
    FOREIGN KEY (id_material) REFERENCES materiales(id_material) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla del historial de modificaciones.
CREATE TABLE modificaciones (
    id_usuario          VARCHAR(40)                 NOT NULL COMMENT 'Identificador del usuario',
    id_material         VARCHAR(40)                 NOT NULL COMMENT 'Identificador del material',
    tipo_almacen        ENUM('uso', 'reserva')      NOT NULL COMMENT 'Tipo de almacenamiento modificado',
    fecha_hora_accion   DATETIME                    NOT NULL COMMENT 'Fecha y hora de la modificación',
    accion              ENUM('sumar', 'restar')     NOT NULL COMMENT 'Tipo de acción realizada',
    unidades            INT UNSIGNED                NOT NULL COMMENT 'Cantidad de unidades modificadas',
    PRIMARY KEY (id_usuario, id_material, tipo_almacen, fecha_hora_accion),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_material, tipo_almacen) REFERENCES almacenamiento(id_material, tipo_almacen) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear índices para optimizar consultas.
CREATE INDEX idx_almacenamiento_material ON almacenamiento (id_material) COMMENT 'Índice para búsquedas por la clave primaria del material en la tabla almacenamiento';
CREATE INDEX idx_almacenamiento_tipo ON almacenamiento (tipo_almacen) COMMENT 'Índice para búsquedas por el tipo del material (uso, reserva) en la tabla almacenamiento';
CREATE INDEX idx_modificaciones_usuario ON modificaciones (id_usuario) COMMENT 'Índice para búsquedas por la clave primaria del usuario en la tabla modificaciones';
CREATE INDEX idx_modificaciones_material ON modificaciones (id_material) COMMENT 'Índice para búsquedas por la clave primaria del material en la tabla modificaciones';
CREATE INDEX idx_modificaciones_fecha ON modificaciones (fecha_hora_accion) COMMENT 'Índice para búsquedas por la fecha en la tabla modificaciones';

-- Confirmar cambios.
COMMIT;
