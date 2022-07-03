<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose implements QualityUpdatable
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
        $qualityUpdatables = array_map(
            fn(Item $item) => match($item->name) {
                'Sulfuras, Hand of Ragnaros' => new SulfurasItem($item),
                'Aged Brie' => new AgedBrieItem($item),
                'Backstage passes to a TAFKAL80ETC concert' => new BackstageItem($item),
                'Conjured Mana Cake' => new ConjuredItem($item),
                default => new NormalItem($item)
            },
            $this->items
        );

        foreach ($qualityUpdatables as $qualityUpdatable) {
            $qualityUpdatable->updateQuality();
        }
    }
}
