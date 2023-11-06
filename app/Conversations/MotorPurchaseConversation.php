<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MotorPurchaseConversation extends Conversation
{
  protected $name;
  protected $location;
  protected $brand;
  protected $category;
  protected $type;
  protected $paymentMethod;
  protected $leasing;
  protected $tenor;

  public function askName()
  {
    $this->ask('Silahkan ketikan nama Anda .', function (Answer $answer) {
      $this->name = $answer->getText();
      $this->say("Hallo, $this->name");
      $this->askLocation();
    });
  }

  public function askLocation()
  {
    $this->say("Dengan melanjutkan percakapan ini, Anda menyetujui proses pengumpulan dan pemrosesan data pribadi yang Anda berikan kepada kami sesuai dengan tujuan yang ditentukan dalam dan sebagaimana diatur dalam Kebijakan Privasi kami di sini");
    $question = Question::create('Mohon beritahu kami alamat domisili Anda.')
      ->addButtons([
        Button::create('Jakarta Selatan')->value('Jakarta Selatan'),
        Button::create('Bogor')->value('Bogor'),
        Button::create('Depok')->value('Depok'),
        Button::create('Tanggerang')->value('Tanggerang'),
        Button::create('Bekasi')->value('Bekasi'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->location = $answer->getValue();
        $this->say("Lokasi yang Anda pilih adalah: $this->location");
        $this->askBrand();
      }
    });
  }

  public function askBrand()
  {
    $question = Question::create('Silakan pilih merk motor yang anda inginkan.')
      ->addButtons([
        Button::create('Honda')->value('Honda'),
        Button::create('Yamaha')->value('Yamaha'),
        Button::create('Suzuki')->value('Suzuki'),
        Button::create('Kawasaki')->value('Kawasaki'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->brand = $answer->getValue();
        $this->say("Merk motor yang Anda pilih adalah: $this->brand");
        $this->askCategory();
      }
    });
  }

  public function askCategory()
  {
    $question = Question::create('Silakan pilih kategori motor yang anda inginkan.')
      ->addButtons([
        Button::create('Matic')->value('Matic'),
        Button::create('Bebek')->value('Bebek'),
        Button::create('Sport')->value('Sport'),
        Button::create('EV')->value('EV'),
        Button::create('Big Bike')->value('Big Bike'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->category = $answer->getValue();
        $this->say("Kategori motor yang Anda pilih adalah: $this->category");
        $this->askType();
      }
    });
  }

  public function askType()
  {
    $this->ask('Silahkan ketikan type nama motor yang anda inginkan.', function (Answer $answer) {
      $this->type = $answer->getText();
      $this->say("Tipe motor yang Anda pilih adalah: $this->type");
      $this->askPaymentMethod();
    });
  }

  public function askPaymentMethod()
  {
    $question = Question::create('Silahkan pilih metode pembayaran yang anda inginkan.')
      ->addButtons([
        Button::create('Kredit')->value('Kredit'),
        Button::create('Cash')->value('Cash'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->paymentMethod = $answer->getValue();
        $this->say("Metode pembayaran yang Anda pilih adalah: $this->paymentMethod");
        $this->askLeasing();
      }
    });
  }

  public function askLeasing()
  {
    $question = Question::create('Silahkan pilih leasing yang anda inginkan.')
      ->addButtons([
        Button::create('Adira')->value('Adira'),
        Button::create('FIF')->value('FIF'),
        Button::create('MCF')->value('MCF'),
        Button::create('OTO')->value('OTO'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->leasing = $answer->getValue();
        $this->say("Leasing motor yang Anda pilih adalah: $this->leasing");
        $this->askTenor();
      }
    });
  }

  public function askTenor()
  {
    $question = Question::create('Silahkan pilih tenor yang anda inginkan.')
      ->addButtons([
        Button::create('11')->value('11'),
        Button::create('17')->value('17'),
        Button::create('23')->value('23'),
        Button::create('27')->value('27'),
        Button::create('29')->value('29'),
        Button::create('33')->value('33'),
        Button::create('35')->value('35'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        $this->tenor = $answer->getValue();
        $this->say("Tenor yang Anda pilih adalah: $this->tenor");
        $this->confirmDetails();
      }
    });
  }

  public function confirmDetails()
  {
    $this->say("Anda akan terhubung dengan sales dengan detail data.");
    $this->say("Nama: $this->name");
    $this->say("Domisili: $this->location");
    $this->say("Merk: $this->brand");
    $this->say("Kategori: $this->category");
    $this->say("Type motor: $this->type");
    $this->say("Metode Pembayaran: $this->paymentMethod");
    $this->say("Leasing: $this->leasing");
    $this->say("Tenor: $this->tenor");

    $question = Question::create("Apakah data tersebut sudah sesuai?")
      ->addButtons([
        Button::create('Y')->value('Y'),
        Button::create('N')->value('N'),
      ]);

    $this->ask($question, function (Answer $answer) {
      if ($answer->isInteractiveMessageReply()) {
        if ($answer->getValue() === 'Y') {
          $this->say('Chat customer service sekarang. !');
        } else {
          $this->askLocation();
        }
      }
    });
  }

  public function run()
  {
    // This will be called immediately
    $this->askName();
  }
}
