<?php

// ブラックジャックゲーム

// 各クラスを読み込む
include 'classes/Card.php';
include 'classes/Deck.php';
include 'classes/Player.php';
include 'classes/Dealer.php';
include 'classes/BlackjackGame.php';

// 名前空間を指定して各クラスをインポート
use Chums424\Card;
use Chums424\Deck;
use Chums424\Player;
use Chums424\Dealer;
use Chums424\BlackjackGame;

// ゲームを開始
$game = new BlackjackGame();
$game->start();
