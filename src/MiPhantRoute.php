<?php
// Copyright (C) 2025 Murilo Gomes Julio
// SPDX-License-Identifier: LGPL-2.1-only

// Site: https://www.mugomes.com.br

namespace MiPhantRoute;

class MiPhantRoute
{
    private array $sURLs = [];

    public function __construct()
    {
        $sURLs = rtrim(parse_url($this->CleanDB(getenv('REQUEST_URI')), PHP_URL_PATH), '/');
        if (empty($sURLs)) {
            $sURLs = '/';
        }

        $sURLParts = array_values(array_filter(explode('/', $sURLs)));
        $this->sURLs = [$sURLs, $sURLParts];
    }

    private function CleanDB(?string $value): ?string
    {
        if (is_null($value)) {
            $txt = '';
        } else {
            $txt = trim($value);
            $txt = strip_tags($txt);
            $txt = addslashes($txt);
        }

        return $txt;
    }

    public function getArrayURLs(): array
    {
        return $this->sURLs[1];
    }

    public function getFullURL(): string
    {
        return implode('/', $this->sURLs[1]);
    }

    public function checkURL(string $name): bool
    {
        if (preg_match('#^' . $name . '$#iu', $this->sURLs[0], $matches)) {
            $retorno = true;
        } else {
            $retorno = false;
        }

        return $retorno;
    }

    public function getURL(int $number): string
    {
        return empty($this->sURLs[1][$number]) ? '' : $this->sURLs[1][$number];
    }

    public function getFirstURL(): string
    {
        return empty($this->sURLs[1][0]) ? '' : $this->sURLs[1][0];
    }

    public function getPenultimateURL(): string
    {
        return empty($this->sURLs[1][count($this->sURLs[1]) - 2]) ? '' : $this->sURLs[1][count($this->sURLs[1]) - 2];
    }

    public function getLastURL(): string
    {
        return end($this->sURLs[1]);
    }
}
