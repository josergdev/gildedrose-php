<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateQualityOfItem($item);
        }
    }

    private function updateQualityOfItem(Item $item): void
    {
        if ($this->isSulfurasItem($item)) {
            return;
        }

        if ($this->isAgedBrieItem($item)) {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
            }

            $item->sell_in = $item->sell_in - 1;

            if ($item->sell_in >= 0) {
                return;
            }

            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
            }
            return;
        }

        if ($this->isBackstageItem($item)) {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;

                if ($item->sell_in < 11) {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }

                if ($item->sell_in < 6) {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }

            $item->sell_in = $item->sell_in - 1;

            if ($item->sell_in >= 0) {
                return;
            }

            $item->quality = 0;

            return;
        }

        if ($item->quality > 0) {
            $item->quality = $item->quality - 1;
        }

        $item->sell_in = $item->sell_in - 1;

        if ($item->sell_in >= 0) {
            return;
        }

        if ($item->quality > 0) {
            $item->quality = $item->quality - 1;
        }
    }

    private function isSulfurasItem(Item $item): bool
    {
        return $item->name === 'Sulfuras, Hand of Ragnaros';
    }

    private function isAgedBrieItem(Item $item): bool
    {
        return $item->name === 'Aged Brie';
    }

    private function isBackstageItem(Item $item): bool
    {
        return $item->name === 'Backstage passes to a TAFKAL80ETC concert';
    }
}
