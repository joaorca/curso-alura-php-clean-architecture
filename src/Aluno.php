<?php

declare(strict_types=1);

namespace Alura\Arquitetura;

class Aluno
{
    private Cpf $cpf;
    private string $nome;
    private Email $email;
    private array $telefones;

    public static function comCpfNomeEmail(string $cpf, string $nome, string $email): self
    {
        return new Aluno(
            new Cpf($cpf),
            $nome,
            new Email($email)
        );
    }

    public function __construct(Cpf $cpf, string $nome, Email $email)
    {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->email = $email;
    }

    public function adicionarTelefone(string $ddd, string $numero): self
    {
        $this->telefones[] = new Telefone($ddd, $numero);
        return $this;
    }
}