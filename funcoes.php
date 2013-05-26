<?php
ob_start();
function redirecionar($url, $segundos = 0)
{
  $url_padrao = 'http://e.diegoramos.info/';

  if(empty($url))
    $url = $url_padrao;
  if(!is_numeric($segundos) || $segundos < 0)
    $segundos = 0;

  if($segundos > 0)
  {
    //header('Refresh: ' .$segundos. '; url= ' .$url);
    //exit;
    echo '<meta http-equiv="refresh" content="' . $segundos . '; url='.$url.'">';
  }
  else
  {
    //header("Location: " . $url);
    //exit;
    echo '<meta http-equiv="refresh" content="0; url='.$url.'">';
  }
}
?>