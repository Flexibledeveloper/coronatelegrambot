// SPDX-FileCopyrightText: 2021 Florian Völker <florian@flexibledeveloper.eu>
//
// SPDX-License-Identifier: AGPL-V3

<?php

namespace App\Controller;

use App\DependencyInjection\CoronaDataProviderService;
use App\DependencyInjection\TelegramBot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private $coronaDataProviderService;
    private $telegramBot;

    public function __construct(CoronaDataProviderService $coronaDataProviderService, TelegramBot $telegramBot)
    {
        $this->coronaDataProviderService = $coronaDataProviderService;
        $this->telegramBot = $telegramBot;
    }

    public function index(): Response
    {
        return new Response('hello');
    }

    public function updateDataAndInformBot(Request $request): Response
    {
        $coronaData = $this->coronaDataProviderService->getCoronaData();
        
        $message = $this->formatMessage($coronaData);
        $this->telegramBot->sendMessageToTelegramBot($message);
        return new Response(
            'data send'
        );
    }
    
    private function formatMessage($coronaData) 
    {
        $formatedMessage = '';
            foreach ($coronaData as $key => $value) {
                if (str_contains($key, '_gestern')) {
                    continue;
                }
                
                $diffToYesterday = $value - $coronaData[$key.'_gestern'];
                
                if (0 < $diffToYesterday) {
                    $diffToYesterday = '+'.$diffToYesterday;
                }

                unset($coronaData[$key.'_gestern']);
                $formatedMessage .= sprintf('<b>%s</b>: %s (<i>%s</i>)', ucfirst($key), $value, $diffToYesterday);
                $formatedMessage .= PHP_EOL;
            }
            
        return $formatedMessage;
    }
}
