<?php

// プレイヤークラスを作成

namespace BlackjackGame\Models;

class Player
{
    public $hand = []; // 手札を格納する配列

    // カードを手札に追加するメソッド
    public function drawCard($card)
    {
        $this->hand[] = $card;
    }

    // 手札の合計値を計算するメソッド
    public function calculateHandValue()
    {
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
