<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Model;
use Source\Models\Citizen;
use Source\Support\Message;

/**
 * CLASSE FILHA DO CONTROLLADOR
 */
class App extends Controller
{

    /**
     * App contrutor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");
    }

    /**
     * Método controlador responsável por renderizar a home
     */
    public function home(): void
    {
        echo $this->view->render("home", []);
    }

    /**
     * Método controlador responsável por renderizar o formulário do app
     */
    public function citizen(?array $data): void
    {
        echo $this->view->render("form-citizen", []);
    }

    /**
     * Método responsável por controlar a persintência de um cidadão
     * 
     * @param array|null $data
     */
    public function createCitizen(?array $data): void
    {
        // VALIDA SE O NOME É VÁLIDO
        $isValidName = Citizen::filter($data, FILTER_VALIDATE_REGEXP, 'citizenName',['options' => ['regexp' => "/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/"]]);
        $messageValidName = "Digite um nome válido!";

        if (!$isValidName) { 
            $this->callbackJsonMessage(400, "warning", $messageValidName);
            return;
        }

        $citizenName = filter_var($data['citizenName'], FILTER_SANITIZE_SPECIAL_CHARS);

        // GERA O NUMERO NIS
        $socialIdentificationNumber = Citizen::socialIdentificationNumberCitizenRandomGenerator();
        
        // SALVA NO BANCO
        $citizenInstance = new Citizen();
        $citizenInstance->persistData($citizenName, $socialIdentificationNumber);

        $this->call(200, "success", (new Message())->success("Cidadão Cadastrado com sucesso! O NIS de {$citizenInstance->name}: {$citizenInstance->nis}")->render() , "alert")
        ->back();
    }

     /**
     * Método responsável por controlar a busca de um cidadão a partir do número NIS
     * 
     * @param array|null $data
     */
    public function searchCitizen(?array $data): void
    {
        $isValidNIS = Citizen::filter($data, FILTER_VALIDATE_INT, 'searchNIS' );
        $invalidMessageNIS = "Digite um número identificador NIS válido!";

        if (!$isValidNIS) {
            $this->callbackJsonMessage(400, "warning", $invalidMessageNIS );
            return;
        }

        if (strlen($data['searchNIS']) !== 11) {
            $this->callbackJsonMessage(400, "warning", $invalidMessageNIS);
            return;
        }

        // BUSCA CIDADÃO PELO NUMERO NIS
        $citizenInstance = (new Citizen())->findBySocialIdentificationNumber($data['searchNIS'], '*');
        if (!$citizenInstance instanceof Model) {
            $this->callbackJsonMessage(404, "warning", "Cidadão não encontrado!");
            return;
        }

        $this->call(200)->back(['citizenName' => $citizenInstance->name, 'citizenNis' => $citizenInstance->nis]);
    }

    public function callbackJsonMessage(int $httpCode, string $typeCssClass, string $messageToReturn = "Verifique os dados"): void
    {
        $this->call($httpCode, $typeCssClass, (new Message())->warning($messageToReturn)->render(), "alert")
        ->back();
    }

     /**
     * SITE ERROR OPPS
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = new \stdClass();
        
        $error->code = $data['errcode'];
        $error->title = "Ooops. Conteúdo indispinível :/";
        $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";

        echo $this->view->render("error", [
            "error" => $error
        ]);
    }

}

