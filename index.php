<?php
require_once 'conexao.php';
require_once 'funcoes.php';
//

if($_GET['p'])
{
  $comando = "SELECT * FROM SpConsultaChave('" . $_GET['p'] . "')";
  $resultado = pg_query($conexao, $comando);
  $chave = pg_fetch_result($resultado, 0, 0);  
  if($chave)
  {
    $comando = "SELECT * FROM SpUrlOriginal('" . $_GET['p'] . "');";
    $resultado = pg_query($conexao, $comando);
//
    $url = pg_fetch_result($resultado, 0, 0);
//    
    if(!$url)
      $url = 'http://e.diegoramos.info/';
  }
  redirecionar($url, 1);
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
/*
if($_GET['p'])
{
  $comando = "SELECT * FROM SpConsultaChave('" . $_GET['p'] . "')";
  $resultado = pg_query($conexao, $comando);
  $chave = pg_fetch_result($resultado, 0, 0);  
  if($chave)
  {
    $comando = "SELECT * FROM SpUrlOriginal('" . $_GET['p'] . "');";
    $resultado = pg_query($conexao, $comando);
//
    $url = pg_fetch_result($resultado, 0, 0);
//    
    if(!$url)
      $url = 'http://e.diegoramos.info/';
  }
  redirecionar($url, 0);
}
*/
?>



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="cache-control" content="no-cache" /> 
<title>Encurtador - Encurte sua URL!</title>

<!-- Meta Tags -->
<meta name="Keywords" content="publicar, twitter, encurte, encurtar url, encurtador de url, shorturl, tinyurl, url curta, menor url, url menor, make url small, url small, shorten url" />
<meta name="description" content="Utilize o encurtador de url e reduza o tamanho de urls longas para utilizar em qualquer lugar." />
<meta name="Robots" content="all" />
<meta name="Googlebot" content="all" />
<meta name="Distribution" content="global" />

<meta name="Copyright" content="(c) 2011 Diego Ramos" />
<meta name="Author" content="Diego do Nascimento Ramos <rdiego26@gmail.com>" />

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="http://e.diegoramos.info/estilo.css" />

<!-- Javascript--> 
<script type="text/javascript" src="http://e.diegoramos.info/js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="http://e.diegoramos.info/js/lib.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  //Coloca foco no campo input
  $('#inputurl').focus();
  $('#msg').empty();
  //Carrega lista dos mais acessados
  $('#mais_acessados').load('tabela_mais_acessados.php');
	
  $('#frm_encurtador').submit(function() {
    var url = $('input:text[name=inputurl]').val();

/*  Reset dos campos utilizados na animação */
  $('#msg').empty();
  $('#msg').hide('fast');
  $('#loading').hide('fast');
  
    if(ValidaURL(url))
    {
  //Requisição Ajax
      $.post("encurta.php", { inputurl: url},
        function(data) { 
            $('#msg').empty();
            $('#msg').css('color', '#D3D3D3').html(data);
            $('.resultado').show('slow');
            });
     return false;
    }
    else
    {
      $('.resultado').css('color', '#FF0000').html('Url Inv&aacute;lida!');
      $('.resultado').show('slow');
    }
    return false;
  });
});
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19816568-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div id="principal"> <!-- div Principal -->
	<div id="loading"></div>
	
<form id="frm_encurtador" name="frm_encurtador" method="POST" action="#">
	<ul>
		<li><span>Insira sua URL a ser encurtada</span><br></li>
		<li><input type="text" id="inputurl" name="inputurl" maxlenght="5" size="25" onclick="this.focus(); this.select();" />&nbsp;<input type="submit" id="btn_encurtar" name="btn_encurtar" value="Encurtar!" /></li>
		<li>&nbsp;</li>
    <li><div id="resultado" name="resultado" class="resultado" style="display:none;">
          <span id="msg" name="msg"></span>
         </div> <!-- Fim da div resultado -->
    </li>
	</ul>
</form>

</div> <!-- fim div Principal -->
<div id="mais_acessados">
</div>
</body>
</html>