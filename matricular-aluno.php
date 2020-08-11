<?php

declare(strict_types=1);

use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Infraestrutura\Aluno\AlunoRepositoryMemory;

require 'vendor/autoload.php';

$cpf = $argv[1];
$nome = $argv[2];
$email = $argv[3];
$ddd = $argv[4];
$numero = $argv[5];

$aluno = Aluno::comCpfNomeEmail(
    $cpf,
    $nome,
    $email
);

$aluno->adicionarTelefone($ddd, $numero);

$repositorio = new AlunoRepositoryMemory();
$repositorio->adicionar($aluno);