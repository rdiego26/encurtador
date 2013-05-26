<?php
ob_start();
require_once 'conexao.php';
require_once 'funcoes.php';

if($_GET['p'])  
{
  $comando = "SELECT * FROM SpConsultaChave('" . $_GET['p'] . "')";
  $resultado = pg_query($conexao, $comando);
  $chave = pg_fetch_result($resultado, 0, 0);  
  if($chave)
  {
    $comando = "SELECT * FROM SpUrlOriginal('" . $_GET['p'] . "');";
    $resultado = pg_query($conexao, $comando);

    //DEBUG
    //exit($comando);
    
    $url = pg_fetch_result($resultado, 0, 0);
    //DEBUG
    //exit($url);
    
    if(!$url)
      $url = 'http://encurtador.diegoramos.info/';
  }
}
  else
    $url = 'http://encurtador.diegoramos.info/';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Encurtador</title>
<meta http-equiv="refresh" content="0; url=<?php echo $url ?>" />
</head>
<body></body>
</html>