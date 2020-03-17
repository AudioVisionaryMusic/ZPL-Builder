<?php

namespace IMusic\ZplBuilder\Factory\Utils;

use IMusic\ZplBuilder\Factory\Helpers\DPI;

class Units
{
    public static function mmToDots(string $mm, float $dpi): float
    {
        $mm = (float) \str_replace('mm', '', $mm);

        switch ($dpi) {
            case DPI::DPI_300:
                return $mm * 11.8; // 11.8 dots / mm
            case DPI::DPI_203:
                return $mm * 8; // 8 dots / mm
            default:
                return $mm * ($dpi / (203 / 8));
        }
    }
}
