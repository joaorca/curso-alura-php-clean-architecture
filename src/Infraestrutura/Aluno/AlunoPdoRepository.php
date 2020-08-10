<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Infraestrutura\Aluno;

use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Aluno\AlunoRepository;
use Alura\Arquitetura\Dominio\Aluno\Telefone;
use Alura\Arquitetura\Dominio\Cpf;

class AlunoPdoRepository implements AlunoRepository
{
    private \PDO $conexao;

    public function __construct(\PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function adicionar(Aluno $aluno): void
    {
        $sql = 'INSERT INTO alunos VALUES (:cpf, :nome, :email)';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue('cpf', $aluno->cpf());
        $stmt->bindValue('nome', $aluno->nome());
        $stmt->bindValue('email', $aluno->email());
        $stmt->execute();

        /** Telefone $telefone */
        foreach ($aluno->telefones() as $telefone) {
            $sql = 'INSERT INTO telefones VALUES (:ddd, :numero, :cpf_aluno)';
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue('ddd', $telefone->ddd());
            $stmt->bindValue('numero', $telefone->numero());
            $stmt->bindValue('cpf_aluno', $aluno->cpf());
        }
    }

    public function buscarPorCpf(Cpf $cpf): Aluno
    {
        // TODO: Implement buscarPorCpf() method.
    }

    public function buscarTodos(): array
    {
        // TODO: Implement buscarTodos() method.
    }
}