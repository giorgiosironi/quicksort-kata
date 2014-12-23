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
                $this->assertIsOrdered($result);
            });
    }

    private function assertIsOrdered(array $list)
    {
        for ($i = 0; $i < count($list) - 1; $i++) {
            $this->assertLessThanOrEqual($list[$i], $list[$i+1], var_export($list, true));
        }
    }
}

function quicksort(array $input)
{
    return [];
}
