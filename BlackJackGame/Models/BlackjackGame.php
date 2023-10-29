<?php

// ゲームクラスを作成

namespace BlackjackGame\Models;

class BlackjackGame
{
    private $player; // プレイヤーオブジェクトを格納するプライベート変数
    private $dealer; // ディーラーオブジェクトを格納するプライベート変数
    private $deck; // デッキオブジェクトを格納するプライベート変数

    public function __construct()
    {
        $this->player = new Player(); // 新しいプレイヤーオブジェクトを作成
        $this->dealer = new Dealer(); // 新しいディーラーオブジェクトを作成
        $this->deck = new Deck(); // 新しいデッキオブジェクトを作成
    }

    // ゲームのメイン処理を開始するメソッド
    public function start()
    {
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
    private function displayHands()
    {
        echo "あなたの引いたカードは{$this->player->hand[0]->suit}の{$this->player->hand[0]->rank}です。\n";
        echo "あなたの引いたカードは{$this->player->hand[1]->suit}の{$this->player->hand[1]->rank}です。\n";
        echo "ディーラーの引いたカードは{$this->dealer->hand[0]->suit}の{$this->dealer->hand[0]->rank}です。\n";
        echo "ディーラーの引いた2枚目のカードはわかりません。\n";
    }

    // プレイヤーのターンを処理するメソッド
    private function playerTurn()
    {
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
    private function dealerTurn()
    {
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
    private function determineWinner()
    {
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
