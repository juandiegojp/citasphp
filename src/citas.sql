DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios (
    id_usuario bigserial PRIMARY KEY,
    nombre varchar(255) NOT NULL,
    password varchar(255) NOT NULL
);

DROP TABLE IF EXISTS citas CASCADE;
CREATE TABLE citas (
    id_cita bigserial PRIMARY KEY,
    fecha timestamp  NOT NULL DEFAULT localtimestamp(0),
    hora timestamp  NOT NULL DEFAULT localtimestamp(0),
    id_usuario bigint NOT NULL REFERENCES usuarios (id_usuario)
);

-- Carga inicial de datos de prueba:

INSERT INTO usuarios (nombre, password)
    VALUES ('admin', crypt('admin', gen_salt('bf', 10))),
           ('pepe', crypt('pepe', gen_salt('bf', 10)));