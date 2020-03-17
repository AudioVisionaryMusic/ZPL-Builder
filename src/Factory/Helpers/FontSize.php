<?php

namespace IMusic\ZplBuilder\Factory\Helpers;

class FontSize
{
    public const SIZE_1 = 1;
    public const SIZE_2 = 2;
    public const SIZE_3 = 3;
    public const SIZE_4 = 4;
    public const SIZE_5 = 5;
    public const SIZE_6 = 6;
    public const SIZE_7 = 7;
    public const SIZE_8 = 8;
    public const SIZE_9 = 9;
    public const SIZE_10 = 10;
    public const SIZE_11 = 11;
    public const SIZE_12 = 12;
    public const SIZE_13 = 13;
    public const SIZE_14 = 14;
    public const SIZE_15 = 15;
    public const SIZE_16 = 16;
    public const SIZE_17 = 17;
    public const SIZE_18 = 18;
    public const SIZE_19 = 19;
    public const SIZE_20 = 20;
    public const SIZE_21 = 21;
    public const SIZE_22 = 22;
    public const SIZE_23 = 23;
    public const SIZE_24 = 24;
    public const SIZE_25 = 25;
    public const SIZE_26 = 26;
    public const SIZE_27 = 27;
    public const SIZE_28 = 28;
    public const SIZE_29 = 29;
    public const SIZE_30 = 30;
    public const SIZE_31 = 31;
    public const SIZE_32 = 32;
    public const SIZE_33 = 33;
    public const SIZE_34 = 34;
    public const SIZE_35 = 35;
    public const SIZE_40 = 40;
    public const SIZE_45 = 45;
    public const SIZE_50 = 50;
    public const SIZE_55 = 55;
    public const SIZE_60 = 60;

    public static function closest(int $size)
    {
        if ($size < 1) {
            return self::SIZE_1;
        }

        if ($size > 35) {
            return self::SIZE_35;
        }

        return \constant("self::SIZE_$size");
    }
}
