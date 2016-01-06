<?php
/**
 * Created by PhpStorm.
 * Copyright: Bertschi AG, 2016
 * User: jbaumann
 * File: TokenLogin.php
 * Date: 06.01.2016
 * Time: 10:43
 */

namespace JRA\Responsibilities\Responsible;


use JRA\Config\Authenticate;
use JRA\Factories\InternalFactory;

use JRA\Interfaces\ConfigInterface;
use JRA\Responsibilities\Handlers\AbstractLoginHandler;

class TokenLogin extends AbstractLoginHandler
{

    /**
     * @param ConfigInterface $pConfig
     * @param InternalFactory $pInternalFactory
     * @return bool true if the request has been processed, false otherwise
     */
    protected function process(ConfigInterface $pConfig, InternalFactory $pInternalFactory)
    {
        if ($pConfig->getAuthenticationMethod() !== Authenticate::AUTH_METHOD_TOKEN) {
            return false;
        }
        $token = $pConfig->getAuthenticationCredentials();
        return
            json_decode(
                $pInternalFactory
                    ->getGuzzleFactory()
                    ->getNewGuzzleMapper($pConfig)
                    ->guzzleRequest(
                        'token/' . $token
                    )
            );
    }
}