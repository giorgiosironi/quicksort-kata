<?php
use Eris\Generator;
use Eris\TestTrait;

class QuicksortTest extends \PHPUnit_Framework_TestCase
{
    use TestTrait;

    public function testSortsAnIntegerList()
    {
        $this
            ->forAll([
                Generator\seq(Generator\int(-100, 100), Generator\nat(50))
            ])
            ->then(function($list) {
                $result = quicksort($list);
                $this->assertIsOrdered($result, $list);
            });
    }

    public function testLengthIsNotModified()
    {
        $this
            ->forAll([
                Generator\seq(Generator\int(-100, 100), Generator\nat(50))
            ])
            ->then(function($list) {
                $result = quicksort($list);
                $this->assertEquals(count($list), count($result), var_export($list, true));
            });
    }

    private function assertIsOrdered(array $list, array $input)
    {
        for ($i = 0; $i < count($list) - 1; $i++) {
            $this->assertTrue($list[$i] <= $list[$i+1], var_export($list, true) . " from input " . var_export($input, true));
        }
    }
}

function quicksort(array $input)
{
    if ($input == []) {
        return [];
    }
    $pivotIndex = (int) floor(count($input) / 2);
    $pivot = $input[$pivotIndex];
    $leftPartition = array_values(array_filter($input, function($number) use ($pivot) {
        return $number < $pivot;
    }));
    $rightPartition = array_values(array_filter($input, function($number) use ($pivot) {
        return $number > $pivot;
    }));
    return array_values(array_merge(
        quicksort($leftPartition),
        [$pivot],
        quicksort($rightPartition)
    ));
}
