-- Eliminar la base de datos si existe.
DROP DATABASE IF EXISTS sanidad;

-- Crear la base de datos.
CREATE DATABASE IF NOT EXISTS sanidad COMMENT 'Base de datos para gestionar usuarios, actividades de los usuarios, materiales y modificaciones de los materiales sanitarios';

-- Seleccionar la base de datos 'sanidad' para su uso.
USE sanidad;

-- Establecer InnoDB como motor de la base de datos.
SET default_storage_engine = InnoDB;

-- Crear la tabla de usuarios.
CREATE TABLE usuarios (
    id_usuario                   VARCHAR(40)  NOT NULL COMMENT 'Identificador del usuario',
    nombre                       VARCHAR(40)  NOT NULL COMMENT 'Nombre del usuario',
    apellidos                    VARCHAR(60)  NOT NULL COMMENT 'Apellidos del usuario',
    fecha_alta                   DATE         NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha de alta del usuario',
    fecha_ultima_modificacion    DATE         NOT NULL COMMENT 'Fecha de la última modificación de datos',
    email                        VARCHAR(100)  NOT NULL COMMENT 'Email del usuario',
    clave                        VARCHAR(255)  NOT NULL COMMENT 'Contraseña del usuario (hasheada)',
    tipo_usuario                 ENUM('alumno', 'docente', 'admin') NOT NULL COMMENT 'Tipo de usuario',
    PRIMARY KEY (id_usuario),
    UNIQUE KEY (email)
);

-- Crear la tabla de materiales.
CREATE TABLE materiales (
    id_material  VARCHAR(40)  NOT NULL COMMENT 'Identificador del material',
    nombre       VARCHAR(60) NOT NULL COMMENT 'Nombre del material',
    descripcion  VARCHAR(100) NOT NULL COMMENT 'Descripción del material',
    ruta_imagen  VARCHAR(100)  NOT NULL COMMENT 'Ruta donde está guardada la imagen en el servidor',
    PRIMARY KEY (id_material)
);

-- Crear la tabla de almacenamiento.
CREATE TABLE almacenamiento (
    id_material   VARCHAR(40)              NOT NULL COMMENT 'Identificador del material',
    tipo_almacen  ENUM('uso', 'reserva')   NOT NULL COMMENT 'Tipo de almacenamiento',
    armario       INT UNSIGNED             NOT NULL COMMENT 'Número de armario',
    balda         INT UNSIGNED             NOT NULL COMMENT 'Número de balda',
    unidades      INT UNSIGNED             NOT NULL COMMENT 'Cantidad de unidades',
    min_unidades  INT UNSIGNED             NOT NULL COMMENT 'Cantidad mínima de unidades',
    PRIMARY KEY (id_material, tipo_almacen),
    FOREIGN KEY (id_material) REFERENCES materiales(id_material) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla del historial de modificaciones.
CREATE TABLE modificaciones (
    id_usuario         VARCHAR(40)  NOT NULL COMMENT 'Identificador del usuario',
    id_material        VARCHAR(40)  NOT NULL COMMENT 'Identificador del material',
    tipo_almacen       ENUM('uso', 'reserva') NOT NULL COMMENT 'Tipo de almacenamiento modificado',
    fecha_hora_accion  DATETIME     NOT NULL COMMENT 'Fecha y hora de la modificación',
    unidades           INT          NOT NULL COMMENT 'Cantidad de unidades modificadas (positivas o negativas)',
    PRIMARY KEY (id_usuario, id_material, tipo_almacen, fecha_hora_accion),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_material, tipo_almacen) REFERENCES almacenamiento(id_material, tipo_almacen) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla de actividades realizadas por el usuario.
CREATE TABLE actividades (
    id_actividad   VARCHAR(40) NOT NULL COMMENT 'Identificador de la actividad',
    id_usuario     VARCHAR(40) NOT NULL COMMENT 'Identificador del usuario que realiza la actividad',
    descripcion    VARCHAR(100) NOT NULL COMMENT 'Descripción de la actividad realizada por el usuario',
    fecha_alta     DATE         NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha de la actividad',
    PRIMARY KEY (id_actividad, id_usuario),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla para registrar los materiales utilizados por el usuario en una actividad.
CREATE TABLE material_actividad (
    id_actividad  VARCHAR(40) NOT NULL COMMENT 'Identificador de la actividad',
    id_material   VARCHAR(40) NOT NULL COMMENT 'Identificador del material',
    cantidad      INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_actividad, id_material),
    FOREIGN KEY (id_actividad) REFERENCES actividades(id_actividad) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_material)  REFERENCES materiales(id_material) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear índices para optimizar consultas.
CREATE INDEX idx_almacenamiento_material ON almacenamiento (id_material) COMMENT 'Búsquedas por material';
CREATE INDEX idx_almacenamiento_tipo ON almacenamiento (id_tipo_almacen) COMMENT 'Búsquedas por tipo de almacén';
CREATE INDEX idx_almacenamiento_unidades ON almacenamiento (unidades) WHERE unidades < min_unidades COMMENT 'Búsquedas por unidades que sean menores que el mínimo de unidades en alamcenamiento';

CREATE INDEX idx_modificaciones_usuario ON modificaciones (id_usuario) COMMENT 'Búsquedas por usuario';
CREATE INDEX idx_modificaciones_almacen ON modificaciones (id_almacenamiento) COMMENT 'Búsquedas por ubicación de almacén';
CREATE INDEX idx_modificaciones_fecha ON modificaciones (fecha_hora_accion) COMMENT 'Búsquedas por fecha';
CREATE INDEX idx_modificaciones_usuario_fecha ON modificaciones (id_usuario, fecha_hora_accion) COMMENT 'Búsquedas por usuario y fecha en modificaciones';

CREATE INDEX idx_material_actividad_material ON material_actividad (id_material) COMMENT 'Búsquedas por material en actividades';

CREATE INDEX idx_actividades_fecha ON actividades (fecha_alta) COMMENT 'Búsquedas por fecha de actividad';

-- Confirmar cambios.
COMMIT;