<?php

namespace App\Service;
use SoapClient;

class OperativaService
{
    public function getOperativasByDate($usernameWs, $passwordWs, $dtFecha, $username, $idMaquinaria)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array(
            'userNameWS' => $usernameWs,
            'passwordWS' => $passwordWs,
            'dtFecha' => $dtFecha,
            'userName' => $username,
            'IdMaquinaria' => $idMaquinaria
        );

        $response = $soapClient->__call('GetListAllOperativasByDate', array($params));

        return $response;
    }

    public function checkServicioOperativaVsOperario($usernameWs, $passwordWs, $idOperativa, $username, $idMaquinaria)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array(
            'userNameWS' => $usernameWs,
            'passwordWS' => $passwordWs,
            'idOperativa' => $idOperativa,
            'userHM' => $username,
            'idMaquinaria' => $idMaquinaria
        );

        $response = $soapClient->__call('CheckServicioOperativaVsOperario', array($params));

        return $response;
    }
}