<?php
namespace Math\Probability\Distribution\Continuous;

use Math\Functions\Special;

/**
 * F-distribution
 * https://en.wikipedia.org/wiki/F-distribution
 */
class F extends Continuous
{
    /**
     * Probability density function
     *
     *      __________________
     *     / (d₁ x)ᵈ¹ d₂ᵈ²
     *    /  ----------------
     *   √   (d₁ x + d₂)ᵈ¹⁺ᵈ²
     *   ---------------------
     *           / d₁  d₂ \
     *      x B |  --, --  |
     *           \ 2   2  /
     *
     * @param number $x  percentile ≥ 0
     * @param int    $d₁ degree of freedom v1 > 0
     * @param int    $d₂ degree of freedom v2 > 0
     *
     * @todo how to handle x = 0
     *
     * @return number probability
     */
    public static function PDF($x, int $d₁, int $d₂)
    {
        // Numerator
        $⟮d₁x⟯ᵈ¹d₂ᵈ²                = ($d₁ * $x)**$d₁ * $d₂**$d₂;
        $⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ²             = ($d₁ * $x + $d₂)**($d₁ + $d₂);
        $√⟮d₁x⟯ᵈ¹d₂ᵈ²／⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ² = sqrt($⟮d₁x⟯ᵈ¹d₂ᵈ² / $⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ²);

        // Denominator
        $xB⟮d₁／2、d₂／2⟯ = $x * Special::beta($d₁ / 2, $d₂ / 2);

        return $√⟮d₁x⟯ᵈ¹d₂ᵈ²／⟮d₁x＋d₂⟯ᵈ¹⁺ᵈ² / $xB⟮d₁／2、d₂／2⟯;
    }

    /**
     * Cumulative distribution function
     *
     *          / d₁  d₂ \
     *  I      |  --, --  |
     *   ᵈ¹ˣ    \ 2   2  /
     *   ------
     *   ᵈ¹ˣ⁺ᵈ²
     *
     * Where I is the regularized incomplete beta function.
     *
     * @param number $x  percentile ≥ 0
     * @param int    $d₁ degree of freedom v1 > 0
     * @param int    $d₂ degree of freedom v2 > 0
     *
     * @return number
     */
    public static function CDF($x, int $d₁, int $d₂)
    {
        $ᵈ¹ˣ／d₁x＋d₂ = ($d₁ * $x) / ($d₁ * $x + $d₂);

        return Special::regularizedIncompleteBeta($ᵈ¹ˣ／d₁x＋d₂, $d₁/2, $d₂/2);
    }
}
