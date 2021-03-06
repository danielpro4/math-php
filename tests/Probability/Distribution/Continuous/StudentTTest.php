<?php
namespace Math\Probability\Distribution\Continuous;

class StudentTTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderForPDF
     */
    public function testPDF($t, $ν, $pdf)
    {
        $this->assertEquals($pdf, StudentT::PDF($t, $ν), '', 0.00001);
    }

    public function dataProviderForPDF()
    {
        return [
            [-5, 2, 0.007127781101],
            [-3.9, 2, 0.01400646997],
            [-1.1, 2, 0.1738771253],
            [-0.1, 2, 0.3509182168],
            [0, 2, 0.353553391],
            [0.1, 2, 0.3509182168],
            [2.9, 2, 0.02977308969],
            [5, 2, 0.007127781101],

            [-5, 6, 0.001220840981],
            [-1.4, 6, 0.1423079919],
            [0, 6, 0.382732772],
            [1, 6, 0.223142291],
            [2.9, 6, 0.0178279372],
            [5, 6, 0.001220840981],


        ];
    }

    public function testPDFExceptionDegreesOfFreedomLessThanZero()
    {
        $this->setExpectedException('\Exception');
        StudentT::PDF(5, -1);
    }

    /**
     * @dataProvider dataProviderForCDF
     */
    public function testCDF($t, $ν, $cdf)
    {
        $this->assertEquals($cdf, StudentT::CDF($t, $ν), '', 0.00001);
    }

    public function dataProviderForCDF()
    {
        return [
            [0, 2, 0.5],
            [0.1, 2, 0.5352672808],
            [2.9, 2, 0.9494099023],
            [5, 2, 0.9811252243],

            [0, 6, 0.5],
            [1, 6, 0.8220411581],
            [3.9, 6, 0.9960080137],
            [5, 6, 0.9987738291],

        ];
    }

    public function testCDFExceptionDegreesOfFreedomLessThanZero()
    {
        $this->setExpectedException('\Exception');
        StudentT::CDF(5, -1);
    }
}
