<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Aplicacao\Aluno\MatricularAluno;

use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Aluno\AlunoRepository;

class MatricularAluno
{
    private AlunoRepository $alunoRepository;

    public function __construct(AlunoRepository $alunoRepository)
    {
        $this->alunoRepository = $alunoRepository;
    }

    public function executa(MatricularAlunoDto $dados): void
    {
        $aluno = Aluno::comCpfNomeEmail(
            $dados->cpfAluno,
            $dados->nomeAluno,
            $dados->emailAluno
        );
        $this->alunoRepository->adicionar($aluno);
    }
}