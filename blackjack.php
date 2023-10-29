<?php

// ブラックジャックゲーム

// カードクラスを作成
class Card {
    // クラス定義するときに受け取る引数
    public $suit; // マーク（ハート、ダイヤ、クラブ、スペード）
    public $rank; // 数字（2から10、J, Q, K, A）

    // カードオブジェクトを初期化し、マークと数字を設定する
    public function __construct($rank, $suit) {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    // カードの点数を返すメソッド
    public function getCardValue() {
        if ($this->rank === "A") {
            return 11; // Aは11点として初期値を設定
        } elseif (in_array($this->rank, ['10', 'J', 'Q', 'K'])) {
            return 10; // 10, J, Q, Kは10点
        } else {
            return (int)$this->rank; // 2から9までは書かれている数の通りの点数
        }
    }
}

// デッキクラスを作成
class Deck {
    public $cards = [];

    public function __construct() {
        $suits = ["ハート", "ダイヤ", "クラブ", "スペード"];
        $ranks = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];

        // 全てのカードを生成し、デッキに追加
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new Card($rank, $suit);
            }
        }
        shuffle($this->cards); // デッキをシャッフル
    }

    // デッキからカードを1枚引くメソッド
    public function drawCard() {
        return array_shift($this->cards); // array_shift — 配列の先頭から要素を一つ取り出す
    }
}


// プレイヤークラスを作成
class Player {
    public $hand = []; // 手札を格納する配列

    // カードを手札に追加するメソッド
    public function drawCard($card) {
        $this->hand[] = $card;
    }

    // 手札の合計値を計算するメソッド
    public function calculateHandValue() {
        $value = 0; // 手札の合計値を初期化
        $aces = 0; // 手札に含まれるAの数を初期化

        foreach ($this->hand as $card) {
            $value += $card->getCardValue(); // カードの点数を合計に加える
            if ($card->rank === 'A') {
              $aces++; // 手札にAがある場合、Aの数を増やす
            }
        }

        // Aを適切に11点または1点として数える
        while ($value > 21 && $aces > 0) {
          $value -= 10; // もし手札の合計値が21を超えており、Aが含まれている場合、Aの点数を1に変更
          $aces--; // 使用したAの数を減らす
        }

        return $value; // 計算した手札の合計値を返す
    }
}

// ディーラークラスを作成
class Dealer {
    public $hand = []; // ディーラーの手札を格納する配列

    // カードを手札に追加するメソッド
    public function drawCard($card) {
        $this->hand[] = $card;
    }

    // 手札の合計値を計算するメソッド
    public function calculateHandValue() {
        $value = 0;
        $aces = 0;

        foreach ($this->hand as $card) {
            $value += $card->getCardValue();
            if ($card->rank === 'A') {
                $aces++;
            }
        }

        // Aを適切に11点または1点として数える
        while ($value > 21 && $aces > 0) {
            $value -= 10;
            $aces--;
        }

        return $value;
    }
}

// ゲームクラスを作成
class BlackjackGame {
    private $player; // プレイヤーオブジェクトを格納するプライベート変数
    private $dealer; // ディーラーオブジェクトを格納するプライベート変数
    private $deck; // デッキオブジェクトを格納するプライベート変数

    public function __construct() {
      $this->player = new Player(); // 新しいプレイヤーオブジェクトを作成
      $this->dealer = new Dealer(); // 新しいディーラーオブジェクトを作成
      $this->deck = new Deck(); // 新しいデッキオブジェクトを作成
    }

    // ゲームのメイン処理を開始するメソッド
    public function start() {
      echo "ブラックジャックを開始します。\n";

      // カードをプレイヤーとディーラーに配る
      $this->player->drawCard($this->deck->drawCard());
      $this->dealer->drawCard($this->deck->drawCard());
      $this->player->drawCard($this->deck->drawCard());
      $this->dealer->drawCard($this->deck->drawCard());

      $this->displayHands(); // 手札を表示
      $this->playerTurn(); // プレイヤーのターン
      $this->dealerTurn(); // ディーラーのターン
      $this->determineWinner(); // 勝者を決定

      echo "ブラックジャックを終了します。\n";
    }

    // 手札を表示するメソッド
    private function displayHands() {
      echo "あなたの引いたカードは{$this->player->hand[0]->suit}の{$this->player->hand[0]->rank}です。\n";
      echo "あなたの引いたカードは{$this->player->hand[1]->suit}の{$this->player->hand[1]->rank}です。\n";
      echo "ディーラーの引いたカードは{$this->dealer->hand[0]->suit}の{$this->dealer->hand[0]->rank}です。\n";
      echo "ディーラーの引いた2枚目のカードはわかりません。\n";
    }

    // プレイヤーのターンを処理するメソッド
    private function playerTurn() {
      $playerValue = $this->player->calculateHandValue();
      while ($playerValue < 21) {
          echo "あなたの現在の得点は{$playerValue}です。カードを引きますか？（Y/N）\n";
          $choice = strtoupper(trim(fgets(STDIN)));
          if ($choice === 'Y') {
              $newCard = $this->deck->drawCard();
              $this->player->drawCard($newCard);
              echo "あなたの引いたカードは{$newCard->suit}の{$newCard->rank}です。\n";
              $playerValue = $this->player->calculateHandValue(); // 合計値を更新
          } elseif ($choice === 'N') {
              break;
          }
      }
    
      if ($playerValue > 21) {
        echo "あなたの得点が21を超えたため、あなたの負けです。\n";
        echo "ブラックジャックを終了します。\n";
        exit; // プレイヤーが負けた場合、ゲームを終了
      }
    }

    // ディーラーのターンを処理するメソッド
    private function dealerTurn() {

      // 2枚目のカードを表示
      echo "ディーラーの引いた2枚目のカードは{$this->dealer->hand[1]->suit}の{$this->dealer->hand[1]->rank}でした。\n";
      
      // 2枚目のカードの点数を含めて初期得点を計算
      $dealerValue = $this->dealer->calculateHandValue();
      echo "ディーラーの現在の得点は{$dealerValue}です。\n";
      
      while ($dealerValue < 17) {
          // カードを引いて点数を更新
          $newCard = $this->deck->drawCard();
          $this->dealer->drawCard($newCard);
          echo "ディーラーの引いたカードは{$newCard->suit}の{$newCard->rank}です。\n";
          $dealerValue = $this->dealer->calculateHandValue();
          echo "ディーラーの現在の得点は{$dealerValue}です。\n";
      }
    }

    // 勝者を決定し、結果を表示するメソッド
    private function determineWinner() {
      $playerValue = $this->player->calculateHandValue();
      $dealerValue = $this->dealer->calculateHandValue();

      echo "あなたの得点は{$playerValue}です。\n";
      echo "ディーラーの得点は{$dealerValue}です。\n";

      if ($playerValue > 21 || ($dealerValue <= 21 && $dealerValue > $playerValue)) {
          echo "ディーラーの勝ちです！\n";
      } elseif ($dealerValue > 21 || ($playerValue <= 21 && $playerValue > $dealerValue)) {
          echo "あなたの勝ちです！\n";
      } else {
          echo "引き分けです！\n";
      }
    }
}

// ゲームを開始
$game = new BlackjackGame();
$game->start();

?>