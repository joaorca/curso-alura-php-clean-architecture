<?php

declare(strict_types=1);

namespace Alura\Arquitetura\Dominio;

class Email
{
    private string $endereco;

    public function __construct(string $endereco)
    {
        $this->setEndereco($endereco);
    }

    private function setEndereco(string $endereco): void
    {
        if (filter_var($endereco, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException(
                "Endereço de e-mail inválido ($endereco)"
            );
        }
        $this->endereco = $endereco;
    }

    public function __toString(): string
    {
        return $this->endereco;
    }
}