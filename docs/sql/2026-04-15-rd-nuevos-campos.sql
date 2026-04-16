CREATE TABLE dimensiones_detector (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tipos_centellador (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE filtros_aplicados_rd (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(150) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE softwares_adquisicion_rd (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(150) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE informes_rd
    ADD COLUMN dimension_detector_id BIGINT UNSIGNED NULL AFTER tipo_pelicula_id,
    ADD COLUMN tipo_centellador_id BIGINT UNSIGNED NULL AFTER ici_id,
    ADD COLUMN pitch DECIMAL(10,2) NULL AFTER pantalla,
    ADD COLUMN srb_dwi DECIMAL(10,2) NULL AFTER pitch,
    ADD COLUMN filtro_aplicado_rd_id BIGINT UNSIGNED NULL AFTER srb_dwi,
    ADD COLUMN software_adquisicion_rd_id BIGINT UNSIGNED NULL AFTER filtro_aplicado_rd_id,
    ADD CONSTRAINT fk_informes_rd_dimension_detector
        FOREIGN KEY (dimension_detector_id) REFERENCES dimensiones_detector(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT fk_informes_rd_tipo_centellador
        FOREIGN KEY (tipo_centellador_id) REFERENCES tipos_centellador(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT fk_informes_rd_filtro_aplicado
        FOREIGN KEY (filtro_aplicado_rd_id) REFERENCES filtros_aplicados_rd(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT fk_informes_rd_software_adquisicion
        FOREIGN KEY (software_adquisicion_rd_id) REFERENCES softwares_adquisicion_rd(id)
        ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE posicion_rd
    ADD COLUMN r_densidad DECIMAL(10,2) NULL AFTER densidad,
    ADD COLUMN mng DECIMAL(10,2) NULL AFTER r_densidad,
    ADD COLUMN snrn DECIMAL(10,2) NULL AFTER mng;

INSERT INTO dimensiones_detector (descripcion, created_at, updated_at) VALUES
('100 x 100', NOW(), NOW()),
('140 x 170', NOW(), NOW());

INSERT INTO tipos_centellador (descripcion, created_at, updated_at) VALUES
('CsI', NOW(), NOW()),
('Gadox', NOW(), NOW());

INSERT INTO filtros_aplicados_rd (descripcion, created_at, updated_at) VALUES
('Cu 0.1 mm', NOW(), NOW()),
('Al 1 mm', NOW(), NOW());

INSERT INTO softwares_adquisicion_rd (descripcion, created_at, updated_at) VALUES
('D-Tect X', NOW(), NOW()),
('Acq Studio', NOW(), NOW());
