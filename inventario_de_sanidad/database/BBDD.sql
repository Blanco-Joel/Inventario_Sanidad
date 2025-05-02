-- Eliminar la base de datos si existe.
DROP DATABASE IF EXISTS healthcare;

-- Crear la base de datos.
CREATE DATABASE IF NOT EXISTS healthcare 
    COMMENT 'Base de datos para gestionar usuarios, actividades escolares, material médico y cambios en el inventario';

-- Seleccionar la base de datos 'healthcare' para su uso.
USE healthcare;

-- Establecer InnoDB como motor de la base de datos.
SET default_storage_engine = InnoDB;

-- Crear la tabla de usuarios.
CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador del usuario',
    first_name VARCHAR(40) NOT NULL COMMENT 'Nombre del usuario',
    last_name VARCHAR(60) NOT NULL COMMENT 'Apellidos del usuario',
    email VARCHAR(100) NOT NULL COMMENT 'Correo electrónico del usuario',
    hashed_password VARCHAR(255) NOT NULL COMMENT 'Contraseña encriptada',
    role ENUM('student', 'teacher', 'admin') NOT NULL COMMENT 'Rol o tipo del usuario',
    created_at DATETIME NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha y hora de registro',
    updated_at DATETIME NOT NULL COMMENT 'Fecha y hora de la última actualización de datos',
    CONSTRAINT pk_users PRIMARY KEY (user_id),
    CONSTRAINT uq_users_email UNIQUE KEY (email)
);

-- Crear la tabla de materiales.
CREATE TABLE materials (
    material_id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador del material',
    name VARCHAR(100) NOT NULL COMMENT 'Nombre del material',
    description TEXT NOT NULL COMMENT 'Descripción del material',
    image_path VARCHAR(255) NOT NULL COMMENT 'Ruta de la imagen almacenada',
    CONSTRAINT pk_materials PRIMARY KEY (material_id)
);

-- Crear la tabla de almacenamiento.
CREATE TABLE storage (
    material_id INT UNSIGNED NOT NULL COMMENT 'Identificador del material',
    storage_type ENUM('use', 'reserve') NOT NULL COMMENT 'Tipo de almacenamiento',
    cabinet INT UNSIGNED NOT NULL COMMENT 'Número del armario',
    shelf INT UNSIGNED NOT NULL COMMENT 'Número de la balda',
    quantity INT UNSIGNED NOT NULL COMMENT 'Unidades disponibles',
    min_quantity INT UNSIGNED NOT NULL COMMENT 'Cantidad mínima requerida',
    CONSTRAINT pk_storage PRIMARY KEY (material_id, storage_type),
    CONSTRAINT fk_storage_material FOREIGN KEY (material_id)
        REFERENCES materials(material_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla del historial de modificaciones.
CREATE TABLE modifications (
    user_id INT UNSIGNED NOT NULL COMMENT 'Usuario que realizó el cambio',
    material_id INT UNSIGNED NOT NULL COMMENT 'Material involucrado',
    storage_type ENUM('use', 'reserve') NOT NULL COMMENT 'Tipo de almacenamiento afectado',
    timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora del cambio',
    quantity INT NOT NULL COMMENT 'Cantidad añadida o eliminada',
    CONSTRAINT pk_modifications PRIMARY KEY (user_id, material_id, storage_type, timestamp),
    CONSTRAINT fk_modifications_user FOREIGN KEY (user_id)
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_modifications_storage FOREIGN KEY (material_id, storage_type)
        REFERENCES storage(material_id, storage_type) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla de asignaturas para las actividades.
CREATE TABLE subjects (
    subject_id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador de la asignatura',
    name VARCHAR(50) NOT NULL COMMENT 'Nombre de la asignatura',
    CONSTRAINT pk_subjects PRIMARY KEY (subject_id)
);

-- Crear la tabla de actividades realizadas por el usuario.
CREATE TABLE activities (
    activity_id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador de la actividad',
    user_id INT UNSIGNED NOT NULL COMMENT 'Estudiante que realizó la actividad',
    subject_id INT UNSIGNED NOT NULL COMMENT 'Asignatura asociada con la actividad',
    description TEXT NOT NULL COMMENT 'Descripción de la actividad realizada',
    activity_date DATE NOT NULL DEFAULT CURRENT_DATE COMMENT 'Fecha de la actividad',
    CONSTRAINT pk_activities PRIMARY KEY (activity_id),
    CONSTRAINT fk_activities_user FOREIGN KEY (user_id)
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_activities_subject FOREIGN KEY (subject_id)
        REFERENCES subjects(subject_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear la tabla para registrar los materiales utilizados por el usuario en una actividad.
CREATE TABLE activity_material (
    activity_id INT UNSIGNED NOT NULL COMMENT 'Actividad en la que se utilizó el material',
    material_id INT UNSIGNED NOT NULL COMMENT 'Material utilizado',
    quantity INT UNSIGNED NOT NULL COMMENT 'Cantidad utilizada en la actividad',
    CONSTRAINT pk_activity_material PRIMARY KEY (activity_id, material_id),
    CONSTRAINT fk_activity_material_activity FOREIGN KEY (activity_id)
        REFERENCES activities(activity_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_activity_material_material FOREIGN KEY (material_id)
        REFERENCES materials(material_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear índices para optimizar consultas.
CREATE INDEX idx_storage_material ON storage (material_id);
CREATE INDEX idx_storage_type ON storage (storage_type);
CREATE INDEX idx_storage_quantities ON storage (quantity, min_quantity);

CREATE INDEX idx_modifications_user ON modifications (user_id);
CREATE INDEX idx_modifications_storage_type ON modifications (storage_type);
CREATE INDEX idx_modifications_timestamp ON modifications (timestamp);
CREATE INDEX idx_modifications_user_timestamp ON modifications (user_id, timestamp);

CREATE INDEX idx_activity_material_material ON activity_material (material_id);
CREATE INDEX idx_activities_date ON activities (activity_date);

-- Confirmar cambios.
COMMIT;