<?php
function calculateStatus(float $z_score)
{
    if ($z_score <= -3) {
        return "emaciated";
    } else if ($z_score <= -2) {
        return "thinnes";
    } else if ($z_score <= 1) {
        return "normal";
    } else if ($z_score <= 2) {
        return "overweight";
    } else {
        return "obese";
    }
}
