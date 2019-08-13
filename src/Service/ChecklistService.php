<?php

namespace App\Service;
use SoapClient;

class ChecklistService
{
    public function getLastCheckListMaquinaria($usernameWs, $passwordWs, $idMaquinaria, $tipoChecklist, $username)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array(
            'userName' => $usernameWs,
            'password' => $passwordWs,
            'idMaquinaria' => $idMaquinaria,
            'tipoCheckList' => $tipoChecklist,
            'userHM' => $username
        );
        $response = $soapClient->__call('getLastCheckListMaquinaria', array($params));

        return $response;
    }

    public function getLastCheckListMaquinariaunfinished($usernameWs, $passwordWs, $idMaquinaria, $tipoChecklist, $idOr)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array(
            'userName' => $usernameWs,
            'password' => $passwordWs,
            'idMaquinaria' => $idMaquinaria,
            'tipoCheckList' => $tipoChecklist,
            'idOR' => $idOr
        );
        $response = $soapClient->__call('GetLastCheckListMaquinariaunfinished', array($params));

        return $response;
    }
}