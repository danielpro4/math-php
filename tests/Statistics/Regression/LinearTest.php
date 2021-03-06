<?php
namespace Math\Statistics\Regression;

class LinearTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertInstanceOf('Math\Statistics\Regression\Regression', $regression);
        $this->assertInstanceOf('Math\Statistics\Regression\Linear', $regression);
    }

    public function testGetPoints()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals($points, $regression->getPoints());
    }

    public function testGetXs()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals([1,2,4,5,6], $regression->getXs());
    }

    public function testGetYs()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals([2,3,5,7,8], $regression->getYs());
    }

    /**
     * @dataProvider dataProviderForEquation
     * Equation matches pattern y = mx + b
     */
    public function testGetEquation(array $points)
    {
        $regression = new Linear($points);
        $this->assertRegExp('/^y = \d+[.]\d+x [+] \d+[.]\d+$/', $regression->getEquation());
    }

    public function dataProviderForEquation()
    {
        return [
            [ [ [0,0], [1,1], [2,2], [3,3], [4,4] ] ],
            [ [ [1,2], [2,3], [4,5], [5,7], [6,8] ] ],
            [ [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ] ],
        ];
    }

    /**
     * @dataProvider dataProviderForParameters
     */
    public function testGetParameters(array $points, $m, $b)
    {
        $regression = new Linear($points);
        $parameters = $regression->getParameters();
        $this->assertEquals($m, $parameters['m'], '', 0.0001);
        $this->assertEquals($b, $parameters['b'], '', 0.0001);
    }

    public function dataProviderForParameters()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                1.2209302325581, 0.60465116279069
            ],
            [
                [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ],
                25.326467777896, 353.16487949889
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForSampleSize
     */
    public function testGetSampleSize(array $points, $n)
    {
        $regression = new Linear($points);
        $this->assertEquals($n, $regression->getSampleSize());
    }

    public function dataProviderForSampleSize()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ], 5
            ],
            [
                [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ], 20
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForEvaluate
     */
    public function testEvaluate(array $points, $x, $y)
    {
        $regression = new Linear($points);
        $this->assertEquals($y, $regression->evaluate($x));
    }

    public function dataProviderForEvaluate()
    {
        return [
            [
                [ [0,0], [1,1], [2,2], [3,3], [4,4] ], // y = x + 0
                5, 5,
            ],
            [
                [ [0,0], [1,1], [2,2], [3,3], [4,4] ], // y = x + 0
                18, 18,
            ],
            [
                [ [0,0], [1,2], [2,4], [3,6] ], // y = 2x + 0
                4, 8,
            ],
            [
                [ [0,1], [1,3.5], [2,6] ], // y = 2.5x + 1
                5, 13.5
            ],
            [
                [ [0,2], [1,1], [2,0], [3,-1] ], // y = -x + 2
                4, -2
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForCI
     */
    public function testGetCI(array $points, $x, $p, $ci)
    {
        $regression = new Linear($points);
        $this->assertEquals($ci, $regression->getCI($x, $p), '', .0000001);
    }
    
    public function dataProviderForCI()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                2, .05, 0.651543596,
            ],
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3, .05, 0.518513005,
            ],
            [
               [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3, .1, 0.383431307,
            ],
        ];
    }
}
