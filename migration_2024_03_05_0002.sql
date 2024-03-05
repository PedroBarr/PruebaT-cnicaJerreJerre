ALTER TABLE usuario ADD COLUMN codigo_revisor INT(11) DEFAULT NULL;
ALTER TABLE usuario ADD CONSTRAINT fk_usuario_revisores FOREIGN KEY (codigo_revisor) REFERENCES revisores (id);