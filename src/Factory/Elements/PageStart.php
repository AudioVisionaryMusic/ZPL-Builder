<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Options;

class PageStart extends Element
{
    protected float $width;
    protected float $height;
    protected string $font;
    protected string $printMode;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function beforeRender(Options $options)
    {
        $this->font = $options->font;
        $this->printMode = $options->printMode;
    }

    public function toZpl()
    {
        // Start
        return join('', [
            '^XA',
            '^LH0,0', // Label Home: top left
            '^FWN,0', // Field Orientation: Normal, left
            '^PON', // Print Orientation: Normal, left
            '^CI28', // UTF-8 Charset
            "^CF{$this->font}", // Default Font
            '^PR12,12,12', // Print Rate
            "^MM{$this->printMode}", // Print mode
            "^PW$this->width", // Page Width - in dots
            "^LL$this->height" // Page height - in dots
        ]);
    }
}
