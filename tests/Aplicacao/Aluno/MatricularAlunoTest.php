<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Tests\Aplicacao\Aluno;

use Alura\Arquitetura\Aplicacao\Aluno\MatricularAluno\MatricularAluno;
use Alura\Arquitetura\Aplicacao\Aluno\MatricularAluno\MatricularAlunoDto;
use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Cpf;
use Alura\Arquitetura\Infraestrutura\Aluno\AlunoRepositoryMemory;
use PHPUnit\Framework\TestCase;

class MatricularAlunoTest extends TestCase
{
    public function testAlunoDeveSerAdicionadoAoRepositorio()
    {
        $dadosAluno = new MatricularAlunoDto(
            '123.456.789-10',
            'Teste',
            'email@example.com'
        );

        $alunoRepository = new AlunoRepositoryMemory();
        $useCase = new MatricularAluno($alunoRepository);
        $useCase->executa($dadosAluno);

        $aluno = $alunoRepository->buscarPorCpf(new Cpf('123.456.789-10'));
        $this->assertSame('Teste', $aluno->nome());
        $this->assertSame('email@example.com', $aluno->email());
        $this->assertEmpty($aluno->telefones());
    }
}