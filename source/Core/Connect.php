<?php

namespace Source\Core;

/**
 *  CLASSE DE CONEXÃO [ Singleton Pattern ]
 *
 * @author Luiz Paulo Escobal
 */
class Connect
{

    /** @const array OPÇÕES*/
    private const OPTIONS = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ];

    /** @var \PDO */
    private static $instance;

    /**
     * Método responsável por retornar uma instancia única
     * @return \PDO
     */
    public static function getInstance(): ?\PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new \PDO(
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    self::OPTIONS
                );
            } catch (\PDOException $exception) {
                redirect("/ops/problemas");
            }
        }

        return self::$instance;
    }

    /**
     * Connect constructor.
     * Não pode ser contruido por se tratar de uma instancia unica
     */
    private function __construct()
    {
    }

    /**
     * Connect clone.
     * Não pode ser clonado por se tratar de uma instancia unica
     */
    private function __clone()
    {
    }
}