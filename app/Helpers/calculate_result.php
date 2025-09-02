<?php

use Carbon\Carbon;

function calculateResult(float $height, float $weight, $birth_date, string $gender, $created_at)
{
    try {
        $bmi = $weight / (($height / 100) ** 2);

        $diff = Carbon::parse($created_at)->diff(Carbon::parse($birth_date));
        $age = $diff->y;
        $age_month_total = $diff->m;
        $age_month = $age_month_total - $age * 12;

        $z_score = calculateZScore($bmi, $age_month, $gender);
        $status = calculateStatus($z_score);

        return [
            'height' => $height,
            'weight' => $weight,
            'bmi' => $bmi,
            'age' => $age,
            'age_month' => $age_month,
            'age_month_total' => $age_month_total,
            'z_score' => $z_score,
            'status' => $status,
        ];
    } catch (\Exception $e) {
        throw $e;
    }
}
