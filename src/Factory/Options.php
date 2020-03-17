<?php

namespace IMusic\ZplBuilder\Factory;

class Options
{
    public $dpi;
    public $font;
    public $fontSize;
    public $printMode;

    public function __construct(int $dpi, string $font, int $fontSize, string $printMode)
    {
        $this->dpi = $dpi;
        $this->font = $font;
        $this->fontSize = $fontSize;
        $this->printMode = $printMode;
    }
}
