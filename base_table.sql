DROP TABLE IF EXISTS sistema_financeiro.usuarios;
CREATE TABLE sistema_financeiro.usuarios (
	id VARCHAR(36) NOT NULL ,
	nome VARCHAR(255) NULL ,
	usuario VARCHAR(255) NULL,
	senha VARCHAR(255) NULL,
	email VARCHAR(255) NULL,
	ativo BOOLEAN NOT NULL DEFAULT FALSE,
	is_admin BOOLEAN NOT NULL DEFAULT FALSE,
	tipo VARCHAR(255) NULL,
	hash_esqueci_senha varchar(255) NULL,
	ultima_troca_senha datetime NULL,
	deletado BOOLEAN NOT NULL DEFAULT FALSE ,
	data_criacao DATETIME NULL ,
	usuario_criacao VARCHAR(36) NULL ,
	data_modificacao DATETIME NULL ,
	usuario_modificacao VARCHAR(36) NULL ,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
