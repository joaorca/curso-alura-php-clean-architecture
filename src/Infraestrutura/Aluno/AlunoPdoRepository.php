<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Infraestrutura\Aluno;

use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Aluno\AlunoNaoEncontradoException;
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

        $sql = 'INSERT INTO telefones VALUES (:ddd, :numero, :cpf_aluno)';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue('cpf_aluno', $aluno->cpf());

        /** Telefone $telefone */
        foreach ($aluno->telefones() as $telefone) {
            $stmt->bindValue('ddd', $telefone->ddd());
            $stmt->bindValue('numero', $telefone->numero());
            $stmt->execute();
        }
    }

    public function buscarPorCpf(Cpf $cpf): Aluno
    {
        $sql = '
        SELECT cpf, nome, email, ddd, numero AS numero_telefone
        FROM alunos
        LEFT JOIN telefones on alunos.cpf = telefones.cpf_aluno
        WHERE alunos.cpf = ? 
        ';

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, (string)$cpf);
        $stmt->execute();

        $dadosAluno = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (count($dadosAluno) === 0) {
            throw new AlunoNaoEncontradoException($cpf);
        }

        return $this->mapearAluno($dadosAluno);
    }

    public function buscarTodos(): array
    {
        $sql = '
        SELECT cpf, nome, email, ddd, numero AS numero_telefone
        FROM alunos
        LEFT JOIN telefones ON telefones.cpf_aluno = alunos.cpf
        ';

        $stmt = $this->conexao->query($sql);

        $listaDadosAlunos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $alunos = [];

        foreach ($listaDadosAlunos as $dadosAluno) {
            if (!array_key_exists($dadosAluno['cpf'], $alunos)) {
                $alunos[$dadosAluno['cpf']] = Aluno::comCpfNomeEmail(
                    $dadosAluno['cpf'],
                    $dadosAluno['nome'],
                    $dadosAluno['email']
                );
            }

            $alunos[$dadosAluno['cpf']]->adicionarTelefone($dadosAluno['ddd'], $dadosAluno['numero_telefone']);
        }
        return array_values($alunos);
    }

    private function mapearAluno(array $dadosAluno): Aluno
    {
        $primeiraLinha = $dadosAluno[0];
        $aluno = Aluno::comCpfNomeEmail(
            $primeiraLinha['cpf'],
            $primeiraLinha['nome'],
            $primeiraLinha['email']
        );
        $telefones = array_filter(
            $dadosAluno,
            fn($linha) => $linha['ddd'] !== null && $linha['numero_telefone'] !== null
        );
        foreach ($telefones as $linha) {
            $aluno->adicionarTelefone($linha['ddd'], $linha['numero_telefone']);
        }

        return $aluno;
    }
}