<?php

// カードクラスを作成

namespace BlackjackGame\Models;

class Card
{
    // クラス定義するときに受け取る引数
    public $suit; // マーク（ハート、ダイヤ、クラブ、スペード）
    public $rank; // 数字（2から10、J, Q, K, A）

    // カードオブジェクトを初期化し、マークと数字を設定する
    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    // カードの点数を返すメソッド
    public function getCardValue()
    {
        if ($this->rank === "A") {
            return 11; // Aは11点として初期値を設定
        } elseif (in_array($this->rank, ['10', 'J', 'Q', 'K'])) {
            return 10; // 10, J, Q, Kは10点
        } else {
            return (int)$this->rank; // 2から9までは書かれている数の通りの点数
        }
    }
}
