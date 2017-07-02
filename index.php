<?php
require_once('correios.php');

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

if ($_POST) {
    $dados = Correios::getEndereco($_POST["CEP"]);

    var_dump($dados);
}
?>
<form name="form" id="form" method="post" action="index.php">
    <input type="text" name="CEP" id="CEP" value="">
    <input type="submit" id="btn" value="buscar">
</form>
