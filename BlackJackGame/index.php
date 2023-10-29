<?php

// ブラックジャックゲーム

// 各クラスを読み込む
include 'Models/Card.php';
include 'Models/Deck.php';
include 'Models/Player.php';
include 'Models/Dealer.php';
include 'Models/BlackjackGame.php';

// 名前空間を指定して各クラスをインポート
use BlackjackGame\Models\Card;
use BlackjackGame\Models\Deck;
use BlackjackGame\Models\Player;
use BlackjackGame\Models\Dealer;
use BlackjackGame\Models\BlackjackGame;

// ゲームを開始
$game = new BlackjackGame();
$game->start();
