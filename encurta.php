<?php
ob_start();
require_once 'conexao.php';

if($_POST['inputurl'])
{
	$comando = "SELECT * FROM SpCadastraUrl('" . $_POST['inputurl'] . "');";
	$resultado = pg_query($conexao, $comando);
	
	$chave = pg_fetch_result($resultado, 0, 0);
	
	if($chave)
  {
    $comando = "SELECT * FROM SpUrlCompacta('" . $chave . "');";
    @$resultado = pg_query($conexao, $comando);
    
    $url = pg_fetch_result($resultado, 0, 0);
    
    echo 'Anote sua url compactada <br><span>' . $url . '</span><br />';
  }
	else
		{
			echo 'N&atilde;o foi possivel encurtar sua URL';
		}

}
else
  header ('Location: http://e.diegoramos.info/')
?>
