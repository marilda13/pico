<?php

namespace App\Entity;

class Price
{
    public function maxProfit($prices) {
        $min_price = PHP_INT_MAX;
        $max_profit = 0;
        foreach ($prices as $price) {
            if ($price < $min_price) {
                $min_price = $price;
            } else {
                $max_profit = max($max_profit, $price - $min_price);
            }
        }

        return $max_profit;
    }
}