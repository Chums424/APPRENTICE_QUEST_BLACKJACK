<?php

// デッキクラスを作成

namespace BlackjackGame\Models;

class Deck
{
    public $cards = [];

    public function __construct()
    {
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
    public function drawCard()
    {
        return array_shift($this->cards); // array_shift — 配列の先頭から要素を一つ取り出す
    }
}
