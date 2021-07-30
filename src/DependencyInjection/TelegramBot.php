// SPDX-FileCopyrightText: 2021 Florian Völker <florian@flexibledeveloper.eu>
//
// SPDX-License-Identifier: AGPL-V3

<?php

namespace App\DependencyInjection;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramBot
{
    private $client;
    private $botToken;
    private $botChatId;

    public function __construct(HttpClientInterface $client, string $botToken, string $botChatId)
    {
        $this->client = $client;
        $this->botToken = $botToken;
        $this->botChatId = $botChatId;
    }

    public function sendMessageToTelegramBot(string $message)
    {
        $this->client->request(
            'GET',
            $this->getMessageURL(),
            [
                'query' => [
                    'parse_mode' => 'html',
                    'chat_id' => $this->botChatId,
                    'text' => $message,
                ],
            ]
        );
    }

    private function getBotBasicUrl(): string
    {
        return sprintf('https://api.telegram.org/bot%s/', $this->botToken);
    }

    private function getMessageURL(): string
    {
        return $this->getBotBasicUrl().'sendMessage';
    }
}
