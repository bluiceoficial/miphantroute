<?php
// Copyright (C) 2025-2026 Murilo Gomes Julio
// SPDX-License-Identifier: MIT

// Site: https://www.bluice.com.br

namespace MiPhantRoute;

class MiPhantRoute
{
    private array $sURLs = [];
    private bool $encontrado = false;
    private bool $error404 = true;

    public function __construct($cliServer = false)
    {
        $sRequestURI = getenv('REQUEST_URI');
        if ($cliServer) {
            $sRequestURI = $_SERVER['REQUEST_URI'];
        }
        if (version_compare(PHP_VERSION, '8.5.0', '>=')) {
            $uri = new \Uri\Rfc3986\Uri($sRequestURI);
            $sURLs = rtrim($uri->getPath(), '/');
        } else {
            $sURLs = rtrim(parse_url($this->CleanDB($sRequestURI), PHP_URL_PATH), '/');
        }
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

    /**
     * Aplica conceito do paradigma funcional
     */
    public function getPart(string $name, callable $function)
    {
        if (!$this->encontrado) {
            $sURL = (empty($this->getFullURL())) ? '/' : sprintf('/%s', $this->getFullURL());

            if (preg_match('#^' . $name . '$#iu', $sURL, $matches)) {
                array_shift($matches);
                call_user_func_array($function, $matches);
                $this->error404 = false;
                $this->encontrado = true;
            }
        }
    }

    public function getError(callable $function)
    {
        if ($this->error404) {
            $function();
        }
    }
}
