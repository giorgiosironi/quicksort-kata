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
    $pickAllThat = function(callable $condition) use ($input) {
        return array_values(array_filter($input, $condition));
    };
    $pivotIndex = (int) floor(count($input) / 2);
    $pivot = $input[$pivotIndex];
    $leftPartition = $pickAllThat(function($number) use ($pivot) {
        return $number < $pivot;
    });
    $middlePartition = $pickAllThat(function($number) use ($pivot) {
        return $number == $pivot;
    });
    $rightPartition = $pickAllThat(function($number) use ($pivot) {
        return $number > $pivot;
    });
    return array_values(array_merge(
        quicksort($leftPartition),
        $middlePartition,
        quicksort($rightPartition)
    ));
}
