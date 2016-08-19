<?php
	function getEnderecoCorreios($cep){	
		$action="http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do" ;	
		$ch = curl_init($action);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt($ch, CURLOPT_POST, true );
		curl_setopt($ch, CURLOPT_POSTFIELDS, "CEP=".$cep."&Metodo=listaLogradouro&TipoConsulta=cep&StartRow=1&EndRow=10");
		
		$r=curl_exec($ch);
		curl_close($ch);
		
		//EXTRAINDO VALORES
		if ($pos   = strpos($r, '<table border="0" cellspacing="1" cellpadding="5" bgcolor="gray">')) {
			$table = substr($r,$pos,500);
			
			list($logradouro,$bairro,$uf,$cep) = split("    ",trim(strip_tags($table)));
			list($tipoLogr,$nomeLogr) = split(" ",$logradouro,2);
			
			print "Tipo Logradouro:".$tipoLogr."<br>";
			print "Nome Logradouro:".$nomeLogr."<br>";
			print "Bairro:".$bairro."<br>";
			print "UF:".$uf."<br>";
			print "CEP:".$cep."<br>";
		
		}else print "CEP Nao encontrado";
	}
	
	if ($_POST) {
		getEnderecoCorreios($_POST["CEP"]);
	}
?>
<form name="form" id="form" method="post" action="index.php">
	<input type="text" name="CEP" id="CEP" value="">
    <input type="submit" id="btn" value="buscar">
</form>
