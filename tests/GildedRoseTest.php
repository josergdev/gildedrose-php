<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{

    public function test_it_should_decrease_quality_of_normal_items_in_one_point(): void
    {
        $items = [new Item('Normal Item', 10, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame('Normal Item', $items[0]->name);
        $this->assertSame(9,  $items[0]->sell_in);
        $this->assertSame(9,  $items[0]->quality);
    }

    public function test_it_should_decrease_quality_of_normal_items_in_two_points_if_sell_date_has_passed(): void
    {
        $items = [new Item('Normal Item', 0, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame('Normal Item', $items[0]->name);
        $this->assertSame(-1,  $items[0]->sell_in);
        $this->assertSame(8,  $items[0]->quality);
    }

    public function test_it_should_not_decrease_quality_of_any_item_lower_than_zero(): void
    {
        $items = [
            new Item('Normal Item', 0, 0),
            new Item('Normal Item', 2, 0),
            new Item('Normal Item', -2, 0),
            new Item('Aged Brie', 2, 0),
            new Item('Sulfuras, Hand of Ragnaros', 2, 0),
            new Item('Backstage passes to a TAFKAL80ETC concert', 0, 0),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 0),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 0),
        ];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        foreach ($items as $item) {
            $this->assertGreaterThanOrEqual(0, $item->quality, $item->__toString());
        }
    }

    public function test_it_should_not_increase_quality_of_any_item_more_than_fifty(): void
    {
        $items = [
            new Item('Normal Item', 2, 49),
            new Item('Normal Item', -2, 50),
            new Item('Aged Brie', 2, 49),
            new Item('Aged Brie', -2, 50),
            new Item('Sulfuras, Hand of Ragnaros', 2, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 0, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 0, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
        ];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        foreach ($items as $item) {
            $this->assertLessThanOrEqual(50, $item->quality, $item->__toString());
        }
    }

    public function provideAgedBrieIncreasingQualityCases(): array
    {
        return [
            ['Aged Brie, 4, 50', new Item('Aged Brie', 5, 49)],
            ['Aged Brie, 4, 50', new Item('Aged Brie', 5, 50)],
            ['Aged Brie, -1, 50', new Item('Aged Brie', 0, 49)],
            ['Aged Brie, -6, 7', new Item('Aged Brie', -5, 5)],
            ['Aged Brie, -6, 50', new Item('Aged Brie', -5, 49)],
        ];
    }

    /**
     * @dataProvider provideAgedBrieIncreasingQualityCases
     */
    public function test_it_should_increase_quality_when_it_is_an_aged_brie(string $expectedOutput, Item $inputAgedBrieItem): void
    {
        $items = [$inputAgedBrieItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
    }
}
