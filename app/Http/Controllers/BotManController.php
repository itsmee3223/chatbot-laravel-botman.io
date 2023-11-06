<?php

namespace App\Http\Controllers;

use App\Conversations\MotorPurchaseConversation;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        $botman->hears('mulai', function ($bot) {
            $bot->startConversation(new MotorPurchaseConversation);
        });
        $botman->fallback(function($bot) {
            $bot->reply('Maaf saya tidak mengerti, silahkan ketikan "mulai" untuk melakukan pembelian motor');
        });
        $botman->listen();
    }
}
