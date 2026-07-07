<?php

namespace App\Services;

use App\Models\Balita;

class NutritionService
{
    /**
     * Calculate WHO Z-Score for Weight-for-Age (WFA)
     * This is a simplified estimation model since full LMS tables are quite large.
     * In a production app, this would query a real WHO LMS lookup table in the DB.
     *
     * @param Balita $balita
     * @param float $weightInKg
     * @return array ['z_score' => float, 'status' => string (normal, kurang, buruk, lebih)]
     */
    public static function calculateWFA(Balita $balita, float $weightInKg): array
    {
        $ageMonths = $balita->umur_bulan;
        $gender = $balita->jenis_kelamin; // 'L' or 'P'

        // Simplified Median Weight formula by age (rough estimation for testing)
        // Normal WHO median for boys: ~3.3kg + 0.6kg * months (up to 12), etc.
        // For demonstration, we'll use a very basic heuristic:
        $medianWeight = 3.3 + (0.5 * $ageMonths);
        if ($gender === 'P') {
            $medianWeight = 3.2 + (0.45 * $ageMonths);
        }

        // Standard deviation approximation (rough guess: ~10% of median is 1 SD)
        $standardDeviation = $medianWeight * 0.12;

        // Calculate Z-Score
        $zScore = ($weightInKg - $medianWeight) / $standardDeviation;

        // Check WHO classifications for Weight-for-Age
        // < -3 SD : Gizi Buruk (Severely underweight)
        // -3 to < -2 SD : Gizi Kurang (Underweight)
        // -2 to +1 SD : Normal (Normal weight)
        // > +1 SD : Risiko Gizi Lebih (Risk of overweight)
        
        $status = 'normal';
        
        if ($zScore < -3.0) {
            $status = 'buruk';
        } elseif ($zScore < -2.0) {
            $status = 'kurang';
        } elseif ($zScore > 2.0) {
            $status = 'lebih'; // simplified overlap
        }

        return [
            'z_score' => round($zScore, 2),
            'status' => $status,
            'median_expected' => round($medianWeight, 2),
        ];
    }
}
