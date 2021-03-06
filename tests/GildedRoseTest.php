<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

/**
 * @covers \GildedRose\GildedRose
 * @covers \GildedRose\Item
 * @covers \GildedRose\BackstageItem
 * @covers \GildedRose\LegendaryItem
 * @covers \GildedRose\ConjuredItem
 * @covers \GildedRose\VelocityItem
 */
class GildedRoseTest extends TestCase
{
    public function provideNormalItemCases()
    {
        return [
            ['Normal Item, 9, 9', new Item('Normal Item', 10, 10)],
            ['Normal Item, 0, 9', new Item('Normal Item', 1, 10)],
            ['Normal Item, -1, 8', new Item('Normal Item', 0, 10)],
            ['Normal Item, -2, 8', new Item('Normal Item', -1, 10)],
            ['Normal Item, -2, 0', new Item('Normal Item', -1, 1)],
        ];
    }

    /**
     * @dataProvider provideNormalItemCases
     */
    public function test_it_should_decrease_quality_when_it_is_normal_item(string $expectedOutput, Item $inputNormalItem): void
    {
        $items = [$inputNormalItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
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
    public function test_it_should_increase_quality_when_it_is_aged_brie(string $expectedOutput, Item $inputAgedBrieItem): void
    {
        $items = [$inputAgedBrieItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
    }

    public function provideSulfurasCases(): array
    {
        $sulfuras = 'Sulfuras, Hand of Ragnaros';

        return [
            ["$sulfuras, 10, 50", new Item($sulfuras, 10, 50)],
            ["$sulfuras, 5, 50", new Item($sulfuras, 5, 50)],
            ["$sulfuras, 0, 50", new Item($sulfuras, 0, 50)],
            ["$sulfuras, -5, 50", new Item($sulfuras, -5, 50)],
            ["$sulfuras, 10, 45", new Item($sulfuras, 10, 45)],
            ["$sulfuras, 5, 45", new Item($sulfuras, 5, 45)],
            ["$sulfuras, 0, 45", new Item($sulfuras, 0, 45)],
            ["$sulfuras, -5, 45", new Item($sulfuras, -5, 45)],
        ];
    }

    /**
     * @dataProvider provideSulfurasCases
     */
    public function test_it_should_not_decrease_quality_or_sell_in_when_it_is_sulfuras(string $expectedOutput, Item $inputSulfurasItem): void
    {
        $items = [$inputSulfurasItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
    }

    public function provideBackstageCases()
    {
        $backStage = 'Backstage passes to a TAFKAL80ETC concert';

        return
        [
            ["$backStage, 10, 31", new Item($backStage, 11, 30)],
            ["$backStage, 9, 32", new Item($backStage, 10, 30)],
            ["$backStage, 8, 32", new Item($backStage, 9, 30)],
            ["$backStage, 5, 32", new Item($backStage, 6, 30)],
            ["$backStage, 4, 33", new Item($backStage, 5, 30)],
            ["$backStage, 3, 33", new Item($backStage, 4, 30)],
            ["$backStage, 0, 33", new Item($backStage, 1, 30)],
            ["$backStage, -1, 0", new Item($backStage, 0, 30)],
            ["$backStage, -2, 0", new Item($backStage, -1, 0)],
        ];
    }

    /**
     * @dataProvider provideBackstageCases
     */
    public function test_it_should_update_quality_when_it_is_backstage_depending_on_sell_in(string $expectedOutput, Item $inputBackstageItem): void
    {
        $items = [$inputBackstageItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
    }


    public function provideConjuredCases()
    {
        return
            [
                ['Conjured Mana Cake, 0, 8',  new Item('Conjured Mana Cake', 1, 10)],
                ['Conjured Mana Cake, -1, 6', new Item('Conjured Mana Cake', 0, 10)],
                ['Conjured Mana Cake, -2, 6', new Item('Conjured Mana Cake', -1, 10)],
                ['Conjured Mana Cake, -1, 1',  new Item('Conjured Mana Cake', 0, 5)],
                ['Conjured Mana Cake, -1, 0',  new Item('Conjured Mana Cake', 0, 4)],
                ['Conjured Mana Cake, -1, 0',  new Item('Conjured Mana Cake', 0, 3)],
                ['Conjured Mana Cake, -1, 0',  new Item('Conjured Mana Cake', 0, 2)],
                ['Conjured Mana Cake, -1, 0',  new Item('Conjured Mana Cake', 0, 1)],
            ];
    }

    /**
     * @dataProvider provideConjuredCases
     */
    public function test_it_should_update_quality_when_it_is_conjured(string $expectedOutput, Item $inputConjuredItem): void
    {
        $items = [$inputConjuredItem];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();

        $this->assertSame($expectedOutput, $items[0]->__toString());
    }
}
