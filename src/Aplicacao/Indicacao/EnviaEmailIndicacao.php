<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Aplicacao\Indicacao;

use Alura\Arquitetura\Dominio\Aluno\Aluno;

interface EnviaEmailIndicacao
{
    public function enviaPara(Aluno $alunoIndicado): void;
}