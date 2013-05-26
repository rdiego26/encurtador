-- Function: spatualizarank(character varying)
-- DROP FUNCTION spatualizarank(character varying);

CREATE OR REPLACE FUNCTION spatualizarank(character varying)
  RETURNS boolean AS
$BODY$
DECLARE
	LclChave ALIAS FOR $1;
	LclBoolAux boolean;
	LclContAux integer;
BEGIN
	-- ESSA FUNÇÃO SÓ É CHAMADA PELA SpConsultaChave, em caso da chave existir, ou seja, sempre retornará TRUE
	--SELECT INTO LclBoolAux SpConsultaChave FROM SpConsultaChave(LclChave);
	--IF LclBoolAux IS TRUE THEN
		-- Esse link ja teve outras visitas 
		SELECT INTO LclContAux Visitas FROM Rank WHERE Chave = LclChave; 
		IF FOUND THEN -- Caso Sim
			SELECT INTO LclContAux (LclContAux + 1);
			UPDATE Rank SET Visitas = LclContAux, Ultima_visita = NOW() WHERE Chave = LclChave;
			RETURN TRUE;
		ELSE	-- Primeira visita
			INSERT INTO Rank(Visitas, Ultima_visita, Chave) VALUES(1, NOW(), LclChave);
			RETURN TRUE;
		END IF;
	--ELSE	-- Chave nao encontrada, link nao cadastrado ainda
	--	RETURN FALSE;
	--END IF;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spatualizarank(character varying)
  OWNER TO diegoramos2;

-- Function: spcadastraurl(character varying)
-- DROP FUNCTION spcadastraurl(character varying);
CREATE OR REPLACE FUNCTION spcadastraurl(character varying)
  RETURNS integer AS
$BODY$
DECLARE
	LclUrlOriginal ALIAS FOR $1;
	LclChave character varying;
	LclAux character varying; -- Armazena a url compacta
	LclAuxUrl character varying DEFAULT LclUrlOriginal;
	LclInt integer DEFAULT 0;
BEGIN
	-- Verificar se a url passada não é nula ou em branco
	IF LclUrlOriginal IS NULL OR LclUrlOriginal = '' THEN
			RETURN 0;
	ELSE
		-- Verificar se na url tem http://
		LclInt := STRPOS(LOWER(LclUrlOriginal), 'http://');
		
		IF LclInt = 0 THEN --Não achou como minuscula
			LclAuxUrl := 'http://' || LclUrlOriginal; -- Inserindo http:// antes de cadastrar
			SELECT INTO LclChave nextval('url_id_seq');
			SELECT INTO LclAux 'http://e.diegoramos.info/' || LclChave;
			INSERT INTO url(id, url_original, url_compacta, chave, datacadastro) VALUES(nextval('url_id_seq'), LclAuxUrl, LclAux, LclChave, NOW());
		RETURN LclChave;
		ELSE
			SELECT INTO LclChave nextval('url_id_seq');
			SELECT INTO LclAux 'http://e.diegoramos.info/' || LclChave;
			INSERT INTO url(id, url_original, url_compacta, chave, datacadastro) VALUES(nextval('url_id_seq'), LclAuxUrl, LclAux, LclChave, NOW());
		RETURN LclChave;
		END IF;
	END IF;
	RETURN 0;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spcadastraurl(character varying)
  OWNER TO diegoramos2;


-- Function: spconsultachave(character varying)
-- DROP FUNCTION spconsultachave(character varying);
CREATE OR REPLACE FUNCTION spconsultachave(character varying)
  RETURNS boolean AS
$BODY$
DECLARE
	LclChave ALIAS FOR $1;
	LclChaveAux character varying;
BEGIN
	SELECT INTO LclChaveAux Chave FROM Url WHERE Chave = LclChave;
	IF FOUND THEN
		PERFORM SpAtualizaRank(LclChaveAux);
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spconsultachave(character varying)
  OWNER TO diegoramos2;

-- Function: spmaisacessados()
-- DROP FUNCTION spmaisacessados();
CREATE OR REPLACE FUNCTION spmaisacessados()
  RETURNS SETOF tpmaisacessados AS
$BODY$
DECLARE Linha TpMaisAcessados;
BEGIN
	FOR Linha IN SELECT
		U.url_original,
		U.url_compacta,
		U.datacadastro,
		R.visitas,
		R.ultima_visita
			FROM url U
		INNER JOIN rank R ON(R.chave = U.chave)
		ORDER BY visitas DESC LIMIT 5
	LOOP
		RETURN NEXT Linha;
	END LOOP;
	RETURN;
	
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spmaisacessados()
  OWNER TO diegoramos2;

-- Function: spurlcompacta(character varying)
-- DROP FUNCTION spurlcompacta(character varying);
CREATE OR REPLACE FUNCTION spurlcompacta(character varying)
  RETURNS character varying AS
$BODY$
DECLARE
	LclUrlCompacta character varying;
	LclChave ALIAS FOR $1;
	LclAux character varying; -- Armazena a url compacta
BEGIN
	SELECT INTO LclUrlCompacta Url_Compacta FROM Url WHERE Chave = LclChave;
	IF FOUND THEN
		RETURN LclUrlCompacta;
	ELSE
		RETURN 'Url nao encontrada';
	END IF;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spurlcompacta(character varying)
  OWNER TO diegoramos2;


-- Function: spurloriginal(character varying)
-- DROP FUNCTION spurloriginal(character varying);
CREATE OR REPLACE FUNCTION spurloriginal(character varying)
  RETURNS character varying AS
$BODY$
DECLARE
	LclUrlOriginal character varying;
	LclChave ALIAS FOR $1;
	LclAux character varying; -- Armazena a url compacta
BEGIN
	SELECT INTO LclUrlOriginal Url_Original FROM Url WHERE Chave = LclChave;
	IF FOUND THEN
		RETURN LclUrlOriginal;
	ELSE
		RETURN 'Url nao encontrada';
	END IF;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spurloriginal(character varying)
  OWNER TO diegoramos2;
