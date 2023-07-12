<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * MODELO DA TABELA CITIZEN [CIDADÃO]
 */
class Citizen extends Model
{
    /** Método contrutor dos dados de dependência */
    public function __construct()
    {
        parent::__construct('citizen', ['id'], ['name', 'nis']);
    }

    /**
     * Método responsável por persistir os dados do cidadão
     * 
     * @param string $citizenName
     * @param string $nis
     */
    public function persistData(string $citizenName, string $numberNis)
    {
        $this->name = $citizenName;
        $this->nis = $numberNis;
        $this->save();
    }

    /**
     * Método responsável por filtrar os dados com filtros básicos e incomuns
     * 
     * @return bool
     */
    public static function filter(array $data, int $filter, string $index, $regexp = 0): bool
    {
        $valid = true;
        // VALIDA ATAQUE CSRF
        if (!csrf_verify($data)) {
            $valid = false;
            return $valid;
        }

        self::validateIfDataIsNotNow($valid, $data, $index);

        if (filter_var($data[$index], $filter, $regexp) === false) {
            $valid = false;
            return $valid;
        }


        return $valid;
    }

    /**
     * Método responsável por verificar se os dados estão todos setados corretamente modificando por referencia o $valid de filter
     *  - fiz isso para um método não passar de 2 ifs seguindo uma boa qualidade de código
     * 
     * @param array $data
     * @param string $index
     * @return void
     */
    public static function validateIfDataIsNotNow(bool &$valid, array $data, string $index)
    {
        if (empty($data)) {
            $valid = false;
        }

        if (empty($data[$index])) {
            $valid = false;
        }
    }

    /**
     * Método recursivo responsável por gerar um número NIS valido e único para o cidadão a ser cadastrado 
     * - É isso mesmo, em algumas soluções gosto de usar a recursão a meu favor hehe
     * 
     * @return bool
     */
    public static function socialIdentificationNumberCitizenRandomGenerator(): string
    {
        $socialIdentificationNumber = '';
        for($i = 1; $i <= 11; $i++) {
            $socialIdentificationNumber .= (string)rand(1,9);
        }

        if (!Citizen::findBySocialIdentificationNumber($socialIdentificationNumber, 'nis') instanceof Model) {
            return $socialIdentificationNumber;
        }
        return self::socialIdentificationNumberCitizenRandomGenerator();
    }

    /**
     * Método responsável por encontrar um cidadão pelo número NIS
     */
    public static function findBySocialIdentificationNumber(string $socialIdentificationNumber, $columns = 'nis')
    {
        return (new self())->find("nis = :nis", "nis={$socialIdentificationNumber}", $columns)->fetch();
    }
}