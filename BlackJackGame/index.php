<?php

// ブラックジャックゲーム

// 各クラスを読み込む
include 'Blackjack\Models/Card.php';
include 'Blackjack\Models/Deck.php';
include 'Blackjack\Models/Player.php';
include 'Blackjack\Models/Dealer.php';
include 'Blackjack\Models/BlackjackGame.php';

// 名前空間を指定して各クラスをインポート
use Blackjack\Models\Card;
use Blackjack\Models\Deck;
use Blackjack\Models\Player;
use Blackjack\Models\Dealer;
use Blackjack\Models\BlackjackGame;

// ゲームを開始
$game = new BlackjackGame();
$game->start();
