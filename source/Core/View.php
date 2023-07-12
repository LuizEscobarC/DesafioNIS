<?php

namespace Source\Core;

use League\Plates\Engine;

/**
 * CLASSE DE VIEW [ DESIGN PATTERN FACAGEN]
 * Classe fachada para a Engine Plates
 *  - A fachada é util para futuras trocas de engine, centralizando em um único lugar a manipulação
 *
 * @author Luiz Paulo Escobal
 */
class View
{
    /** @var Engine */
    private $engine;

    /**
     * Método responsável por startar a engine
     * 
     * View construtor.
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = '', string $ext = CONF_VIEW_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    /**
     * Método responsável por setar a pasta de view e layouts
     * 
     * @param string $name
     * @param string $path
     * @return View
     */
    public function path(string $name, string $path): View
    {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * Método responsável por renderizar a visão com dados na tela
     * 
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        return $this->engine->render($templateName, $data);
    }

    /**
     * Método etter da engine
     * 
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine();
    }
}