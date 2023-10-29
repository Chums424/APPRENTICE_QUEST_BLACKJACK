<?php

// ディーラークラスを作成

namespace BlackjackGame\Models;

class Dealer
{
    public $hand = []; // ディーラーの手札を格納する配列

    // カードを手札に追加するメソッド
    public function drawCard($card)
    {
        $this->hand[] = $card;
    }

    // 手札の合計値を計算するメソッド
    public function calculateHandValue()
    {
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
