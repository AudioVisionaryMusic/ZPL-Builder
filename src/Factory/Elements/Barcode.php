<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Options;
use IMusic\ZplBuilder\Factory\Utils\Units;

class Barcode extends Element
{
    protected int $height;
    protected string $text;
    protected string $type;
    protected string $width = "0.2mm";

    public function __construct(string $text, int $height, string $type)
    {
        $this->text = $text;
        $this->type = $type;
        $this->height = $height;
    }

    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function beforeRender(Options $options)
    {
        $this->width = Units::mmToDots($this->width, $options->dpi);
    }

    public function toZpl()
    {
        return join('', [
            "^FO$this->x,$this->y",
            "^BY{$this->width},2,{$this->height}",
            "^{$this->type}",
            "^FD$this->text",
            "^FS"
        ]);
    }
}
