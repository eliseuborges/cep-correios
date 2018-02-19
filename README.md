# CEP Correios Brasil

Busca CEP na base dos correios - Brasil

[![Build Status](https://travis-ci.org/eliseuborges/cep-correios.svg?branch=master)](https://travis-ci.org/eliseuborges/cep-correios)

## Exemplo de uso

```php
require 'vendor/autoload.php';

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

if ($_POST) {
    try {
        $dados = Eliseuborges\Correios::getEndereco( $_POST["CEP"] );
        var_dump($dados);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}
?>

<form name="form" id="form" method="post" action="index.php">
    <input type="text" name="CEP" id="CEP" value="">
    <input type="submit" id="btn" value="buscar">
</form>
```

## Contribuindo

1. Faça o _fork_ do projeto
2. Crie uma _branch_ para sua modificação (`git checkout -b feature/fooBar`)
3. Faça o _commit_ (`git commit -am 'Add some fooBar'`)
4. _Push_ (`git push origin feature/fooBar`)
5. Crie um novo _Pull Request_

## Licença

Esta biblioteca é um software open-source licenciado sob a licença MIT.
