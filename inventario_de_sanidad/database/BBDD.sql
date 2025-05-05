-- Eliminar la base de datos si existe.
DROP DATABASE IF EXISTS healthcare;

-- Crear la base de datos.
CREATE DATABASE IF NOT EXISTS sanidad COMMENT 'Base de datos para gestionar usuarios, actividades de los usuarios, materiales y modificaciones de los materiales sanitarios';

-- Seleccionar la base de datos 'healthcare' para su uso.
USE healthcare;

-- Establecer InnoDB como motor de la base de datos.
SET default_storage_engine = InnoDB;

-- Crear la tabla de usuarios.
CREATE TABLE users (
    user_id                    INT AUTO_INCREMENT NOT NULL COMMENT 'Identificador del usuario',
    first_name                 VARCHAR(40)  NOT NULL COMMENT 'Nombre del usuario',
    last_name                  VARCHAR(60)  NOT NULL COMMENT 'Apellidos del usuario',
    created_at                 DATE         NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha de alta del usuario',
    last_modified              DATE         COMMENT 'Fecha de la última modificación de datos',
    email                      VARCHAR(100)  NOT NULL COMMENT 'Email del usuario',
    password                   VARCHAR(255)  NOT NULL COMMENT 'Contraseña del usuario',
    hashed_password                   VARCHAR(255)  NOT NULL COMMENT 'Contraseña del usuario (hasheada)',
    user_type                  ENUM('alumno', 'docente', 'admin') NOT NULL COMMENT 'Tipo de usuario',
    PRIMARY KEY (user_id),
    UNIQUE KEY (email)
);

-- Crear la tabla de materiales.
CREATE TABLE materials (
    material_id   INT AUTO_INCREMENT NOT NULL COMMENT 'Identificador del material',
    name          VARCHAR(60) NOT NULL COMMENT 'Nombre del material',
    description   VARCHAR(100) NOT NULL COMMENT 'Descripción del material',
    image_path    VARCHAR(100) NOT NULL COMMENT 'Ruta donde está guardada la imagen en el servidor',
    PRIMARY KEY (material_id)
);

-- Crear la tabla de almacenamiento.
CREATE TABLE storage (
    material_id    INT              NOT NULL COMMENT 'Identificador del material',
    storage_type   ENUM('uso', 'reserva') NOT NULL COMMENT 'Tipo de almacenamiento',
    cabinet        INT UNSIGNED     NOT NULL COMMENT 'Número de armario',
    shelf          INT UNSIGNED     NOT NULL COMMENT 'Número de balda',
    units          INT UNSIGNED     NOT NULL COMMENT 'Cantidad de unidades',
    min_units      INT UNSIGNED     NOT NULL COMMENT 'Cantidad mínima de unidades',
    PRIMARY KEY (material_id, storage_type),
    FOREIGN KEY (material_id) REFERENCES materials(material_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla del historial de modificaciones.
CREATE TABLE modifications (
    user_id          INT NOT NULL COMMENT 'Identificador del usuario',
    material_id      INT NOT NULL COMMENT 'Identificador del material',
    storage_type     ENUM('uso', 'reserva') NOT NULL COMMENT 'Tipo de almacenamiento modificado',
    action_datetime  DATETIME     NOT NULL COMMENT 'Fecha y hora de la modificación',
    units            INT          NOT NULL COMMENT 'Cantidad de unidades modificadas (positivas o negativas)',
    PRIMARY KEY (user_id, material_id, storage_type, action_datetime),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (material_id, storage_type) REFERENCES storage(material_id, storage_type) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla de actividades realizadas por el usuario.
CREATE TABLE activities (
    activity_id   INT AUTO_INCREMENT NOT NULL COMMENT 'Identificador de la actividad',
    user_id       INT NOT NULL COMMENT 'Identificador del usuario que realiza la actividad',
    description   VARCHAR(100) NOT NULL COMMENT 'Descripción de la actividad realizada por el usuario',
    created_at    DATE         NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha de la actividad',
    PRIMARY KEY (activity_id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla para registrar los materiales utilizados por el usuario en una actividad.
CREATE TABLE activity_material (
    activity_id  INT NOT NULL COMMENT 'Identificador de la actividad',
    material_id  INT NOT NULL COMMENT 'Identificador del material',
    quantity     INT UNSIGNED NOT NULL,
    PRIMARY KEY (activity_id, material_id),
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materials(material_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear índices para optimizar consultas.
CREATE INDEX idx_storage_material ON storage (material_id) COMMENT 'Búsquedas por material';
CREATE INDEX idx_storage_type ON storage (storage_type) COMMENT 'Búsquedas por tipo de almacén';
CREATE INDEX idx_storage_units ON storage (units) COMMENT 'Búsquedas por unidades que sean menores que el mínimo de unidades en alamcenamiento';

CREATE INDEX idx_modifications_user ON modifications (user_id) COMMENT 'Búsquedas por usuario';
CREATE INDEX idx_modifications_material ON modifications (material_id) COMMENT 'Búsquedas por ubicación de almacén';
CREATE INDEX idx_modifications_datetime ON modifications (action_datetime) COMMENT 'Búsquedas por fecha';
CREATE INDEX idx_modifications_user_datetime ON modifications (user_id, action_datetime) COMMENT 'Búsquedas por usuario y fecha en modificaciones';

CREATE INDEX idx_activity_material_material ON activity_material (material_id) COMMENT 'Búsquedas por material en actividades';

CREATE INDEX idx_activities_created_at ON activities (created_at) COMMENT 'Búsquedas por fecha de actividad';

-- Confirmar cambios.
COMMIT;