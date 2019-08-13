<?php

namespace App\Service;
use SoapClient;

class MaquinariaService
{
    public function getMaquinarias($usernameWs, $passwordWs, $idCentro)
    {
        $soapClient = new SoapClient('http://intranet.logicmove.es/WCFHmtest/HMovementsServiceService.svc?WSDL');
        $params = array('userNameWs' => $usernameWs, 'passwordWs' => $passwordWs, 'idCentro' => $idCentro);
        $response = $soapClient->__call('GetMaquinarias', array($params));

        return $response;
    }
}