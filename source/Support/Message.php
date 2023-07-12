<?php

namespace Source\Support;

/**
 * CLASSE DE MANIPULAÇÃO DE MENSAGEM [MEIO ACTIVE RECORD MEIO CLASSE NORMAL KKK]
 *
 * @author Luiz Paulo Escobar
 */
class Message
{
    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Método getter responsável por pegar o texto setado na classe
     * 
     * @return string
     */
    protected function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Método getter responsável por pegar o tipo do texto (classe css) setado na classe
     * 
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Método de abstração da classe css de warning (verde)
     * 
     * @param string $message
     * @return Message
     */
    public function success(string $message): Message
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * Método de abstração da classe css de warning (amarelo)
     * 
     * @param string $message
     * @return Message
     */
    public function warning(string $message): Message
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * Método de abstração da classe css de erro (vermelho)
     * 
     * @param string $message
     * @return Message
     */
    public function error(string $message): Message
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * Método responsável por buildar a tag do alerta personalizado
     * 
     * @return string
     */
    public function render(): string
    {
        return "<div class='" . CONF_MESSAGE_CLASS . " animated bounce {$this->getType()}'>{$this->getText()}</div>";
    }

    /**
     * Método responsável por filtrar o texto setado
     * 
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}