<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Infraestrutura\Aluno;

use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Aluno\AlunoNaoEncontradoException;
use Alura\Arquitetura\Dominio\Aluno\AlunoRepository;
use Alura\Arquitetura\Dominio\Cpf;

class AlunoMemoryRepository implements AlunoRepository
{
    private array $alunos = [];

    public function adicionar(Aluno $aluno): void
    {
        $this->alunos[] = $aluno;
    }

    public function buscarPorCpf(Cpf $cpf): Aluno
    {
        $alunosFiltrados = array_filter(
            $this->alunos,
            fn($aluno) => $aluno->cpf == $cpf
        );

        if (count($alunosFiltrados) === 0) {
            throw new AlunoNaoEncontradoException($cpf);
        }

        return $alunosFiltrados[0];
    }

    public function buscarTodos(): array
    {
        return $this->alunos;
    }
}