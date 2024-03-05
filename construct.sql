CREATE DATABASE GEMASAS_Prueba;
USE GEMASAS_Prueba;

CREATE TABLE estado (
	id_estado INTEGER NOT NULL,
	desc_estado VARCHAR(20),
	PRIMARY KEY (id_estado)
);

CREATE TABLE usuario (
	id_usuario INTEGER AUTO_INCREMENT NOT NULL,
	email_usuario VARCHAR(50) NOT NULL,
	nombre_usuario VARCHAR(25),
	apellido_usuario VARCHAR(25),
	estado_usuario INTEGER NOT NULL,
	PRIMARY KEY (id_usuario),
	CONSTRAINT estado_usuario_fk FOREIGN KEY(estado_usuario) REFERENCES estado (id_estado)
);

INSERT INTO estado VALUES (1, 'ACTIVO');
INSERT INTO estado VALUES (2, 'INACTIVO');
INSERT INTO estado VALUES (3, 'EN PROCESO DE ESPERA');

COMMIT;