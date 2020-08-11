<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Aplicacao\Aluno\MatricularAluno;

class MatricularAlunoDto
{
    public string $cpfAluno;
    public string $nomeAluno;
    public string $emailAluno;

    public function __construct(string $cpfAluno, string $nomeAluno, string $emailAluno)
    {
        $this->cpfAluno = $cpfAluno;
        $this->nomeAluno = $nomeAluno;
        $this->emailAluno = $emailAluno;
    }

}