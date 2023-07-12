<?php

namespace Source\Core;

use Source\Support\Message;

/**
 * CLASSE DE ABSTRAÇÃO DA SESSÃO
 *
 * @author Luiz Paulo Escobal
 */
class Session
{
    /**
     * Método que inicia a sessão
     * 
     * Session Ccontrutor.
     */
    public function __construct()
    {
        if (!session_id()) {
            ini_set('session.gc_maxlifetime', 60 * 60 * 3);
            session_start();
        }
    }

    /**
     * Método responsável por pegar um dados na sessão apartir do indice
     * 
     * @param $name
     * @return null|mixed
     */
    public function __get($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * Método responsável por verificar um dado com stateless na sessão
     * 
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * Método responsável por pegar toda a sessão
     * 
     * @return null|object
     */
    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    /**
     * Método responsável por setar um dado na sessão
     * 
     * @param string $key
     * @param mixed $value
     * @return Session
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * Método responsável por dessetar um dado na sessão
     * 
     * @param string $key
     * @return Session
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * Método responsável por verificar um dado na sessão
     * 
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Método responsável por regenerar se necessário a sessão
     * 
     * @return Session
     */
    public function regenerate(): Session
    {
        session_regenerate_id(true);
        return $this;
    }

    /**
     * Método responsável por destruir a sessão
     * 
     * @return Session
     */
    public function destroy(): Session
    {
        session_destroy();
        return $this;
    }


    /**
     * Método responsável por adicionar uma hash csrf na sessão
     * 
     * CSRF Token
     */
    public function csrf(): void
    {
        $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
    }
}