<?php
require_once 'conexao.php';
$comando = 'SELECT * FROM SpMaisAcessados()';
$resultado = pg_query($conexao, $comando);
$linhas = pg_num_rows($resultado);

if($linhas < 0)
{
	echo '<p>Não existem dados.</p>';
}
else
{
	echo '<table>';
		echo '<tr>';
			echo '<th>URL</th>';
			echo '<th>Visitas</th>';
		echo '</tr>';
	//Populando tabela
		for($i=0;$i<$linhas;$i++)
		{
			echo '<tr>';
				echo '<td><a href="'. pg_fetch_result($resultado, $i, 'urlcompacta') . '" target="_blank">' . pg_fetch_result($resultado, $i, 'urlcompacta') . '</a>';
				echo '</td>';

				echo '<td>';
					echo pg_fetch_result($resultado, $i, 'visitas');
				echo '</td>';
			echo '</tr>';
		}
	
	echo '</table>';
}
?>