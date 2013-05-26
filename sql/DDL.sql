CREATE DATABASE diegoramos2
  WITH OWNER = diegoramos2
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'C'
       LC_CTYPE = 'C'
       CONNECTION LIMIT = -1;

-- DROP TABLE url;
CREATE TABLE url
(
  id serial NOT NULL,
  url_original character varying NOT NULL,
  url_compacta character varying NOT NULL,
  chave character varying(255) NOT NULL,
  datacadastro date NOT NULL DEFAULT now(),
  CONSTRAINT fk_id PRIMARY KEY (id ),
  CONSTRAINT unik_chave UNIQUE (chave )
)
WITH (
  OIDS=FALSE
);
ALTER TABLE url
  OWNER TO diegoramos2;

-- Table: rank

-- DROP TABLE rank;
CREATE TABLE rank
(
  id serial NOT NULL,
  visitas integer NOT NULL,
  ultima_visita date NOT NULL DEFAULT now(),
  chave character varying NOT NULL,
  CONSTRAINT pk_id PRIMARY KEY (id ),
  CONSTRAINT fk_chave FOREIGN KEY (chave)
      REFERENCES url (chave) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT rank_chave_key UNIQUE (chave )
)
WITH (
  OIDS=FALSE
);
ALTER TABLE rank
  OWNER TO diegoramos2;
