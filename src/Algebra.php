<?php
namespace Math;

class Algebra
{
    /**
     * Greatest common divisor - recursive Euclid's algorithm
     * The largest positive integer that divides the numbers without a remainder.
     * For example, the GCD of 8 and 12 is 4.
     * https://en.wikipedia.org/wiki/Greatest_common_divisor
     *
     * gcd(a, 0) = a
     * gcd(a, b) = gcd(b, a mod b)
     *
     * @param  int $a
     * @param  int $b
     *
     * @return int
     */
    public static function gcd(int $a, int $b): int
    {
        // Base cases
        if ($a == 0) {
            return $b;
        }
        if ($b == 0) {
            return $a;
        }

        // Recursive case
        return Algebra::gcd($b, $a % $b);
    }

    /**
     * Least common multiple
     * The smallest positive integer that is divisible by both a and b.
     * For example, the LCM of 5 and 2 is 10.
     * https://en.wikipedia.org/wiki/Least_common_multiple
     *
     *              |a ⋅ b|
     * lcm(a, b) = ---------
     *             gcd(a, b)
     *
     * @param  int $a
     * @param  int $b
     *
     * @return int
     */
    public static function lcm(int $a, int $b): int
    {
        // Special case
        if ($a === 0 || $b === 0) {
            return 0;
        }

        return abs($a * $b) / Algebra::gcd($a, $b);
    }

    /**
     * Get factors of an integer
     * The decomposition of a composite number into a product of smaller integers.
     * https://en.wikipedia.org/wiki/Integer_factorization
     *
     * Method:
     *  Iterate from 1 to √x
     *  If x mod i = 0, it is a factor
     *  Furthermore, x/i is a factor
     *
     * @param  int $x
     * @return array of factors
     */
    public static function factors(int $x): array
    {
        // 0 has infinite factors
        if ($x === 0) {
            return [\INF];
        }

        $x  = abs($x);
        $√x = floor(sqrt($x));

        $factors = [];
        for ($i = 1; $i <= $√x; $i++) {
            if ($x % $i === 0) {
                $factors[] = $i;
                if ($i !== $√x) {
                    $factors[] = $x / $i;
                }
            }
        }
        sort($factors);
        return $factors;
    }
}
