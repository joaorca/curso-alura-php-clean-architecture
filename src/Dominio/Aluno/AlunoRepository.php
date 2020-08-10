<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Dominio\Aluno;

use Alura\Arquitetura\Dominio\Cpf;

interface AlunoRepository
{
    public function adicionar(Aluno $aluno): void;

    public function buscarPorCpf(Cpf $cpf): Aluno;

    /** @return Aluno[] */
    public function buscarTodos(): array;

}