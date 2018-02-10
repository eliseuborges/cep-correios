<?php

libxml_use_internal_errors(true);

use PHPUnit\Framework\TestCase;
use Eliseuborges\Correios;

final class CorreiosTest extends TestCase
{
	private $endereco;

	public function setUp()
	{
		parent::setUp();
		$this->endereco = array(
			'logradouro' => 'Praça da Sé - lado ímpar ',
			'bairro' => 'Sé ',
			'cidade' => 'São Paulo',
			'uf' => 'SP',
			'cep' => '01001-000',
		);
	}

	public function testGetEndereco()
	{
		$endereco = Correios::getEndereco('01001-000');
		$this->assertEquals($this->endereco, $endereco);
	}

	public function testCepNaoEncontrado()
	{
		try {
			$endereco = Correios::getEndereco( '00000-000' );
			$this->assertEquals(NULL, $endereco);
		} catch (\Eliseuborges\Exceptions\NotFoundException $e) {
			$this->assertEquals('CEP não encontrado', $e->getMessage());
		}
	}

	public function testCepInvalido()
	{
		try {
			$endereco = Correios::getEndereco( '' );
			$this->assertEquals(NULL, $endereco);
		} catch (\Eliseuborges\Exceptions\InvalidCepException $e) {
			$this->assertEquals('Informe um CEP válido', $e->getMessage());
		}
	}
}
