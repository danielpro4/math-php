<?php
namespace Math\Probability\Distribution\Continuous;

use Math\Functions\Special;

/**
 * Student's t-distribution
 * https://en.wikipedia.org/wiki/Student%27s_t-distribution
 */
class StudentT extends Continuous
{
    /**
     * Probability density function
     *
     *     / ν + 1 \
     *  Γ |  -----  |
     *     \   2   /    /    x² \ ⁻⁽ᵛ⁺¹⁾/²
     *  -------------  | 1 + --  |
     *   __    / ν \    \    ν  /
     *  √νπ Γ |  -  |
     *         \ 2 /
     *
     *
     * @param number $x percentile
     * @param int    $ν degrees of freedom > 0
     */
    public static function PDF($x, int $ν)
    {
        if ($ν <= 0) {
            throw new \Exception('Degrees of freedom must be > 0');
        }

        $π = \M_PI;

        // Numerator
        $Γ⟮⟮ν＋1⟯∕2⟯ = Special::gamma(($ν + 1) / 2);
        $⟮1＋x²∕ν⟯ = 1 + ($x**2 / $ν);
        $−⟮ν＋1⟯∕2 = -($ν + 1) / 2;

        // Denominator
        $√⟮νπ⟯  = sqrt($ν * $π);
        $Γ⟮ν∕2⟯ = Special::gamma($ν / 2);
        
        return ($Γ⟮⟮ν＋1⟯∕2⟯ * $⟮1＋x²∕ν⟯**$−⟮ν＋1⟯∕2) / ($√⟮νπ⟯ * $Γ⟮ν∕2⟯);
    }
    
    /**
     * Cumulative distribution function
     * Calculate the cumulative t value up to a point, left tail.
     *
     * @param number $t t score
     * @param int    $ν degrees of freedom > 0
     */
    public static function CDF($t, int $ν)
    {
        if ($ν <= 0) {
            throw new \Exception('Degrees of freedom must be > 0');
        }

        if ($t == 0) {
            return .5;
        }

        $x = $ν / ($t**2 + $ν);
        $a = $ν / 2;
        $b = .5;
        return 1 - .5 * Special::regularizedIncompleteBeta($x, $a, $b);
    }


  /****************************************************************************
   * Find t such that the area greater than t and the area beneath -t is $p
   */
    public static function inverse2Tails($p, $ν)
    {
        return self::inverse(1 - $p / 2, $ν);
    }
}
