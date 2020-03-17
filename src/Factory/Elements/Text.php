<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Options;
use IMusic\ZplBuilder\Factory\Utils\Units;

class Text extends Element
{
    protected string $text;
    protected bool $bold = false;

    protected string $alignment = 'L';
    protected string $width = "25mm";
    protected int $lines = 2;
    protected ?int $fontSize;
    protected ?string $fontType;

    public function __construct(string $text, ?int $fontSize = null, ?string $fontType = null)
    {
        $this->text = $text;
        $this->fontSize = $fontSize;
        $this->fontType = $fontType;
    }

    public function bold(bool $bold = true)
    {
        $this->bold = $bold;

        return $this;
    }

    public function align(string $alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function width(string $width)
    {
        $this->width = $width;

        return $this;
    }

    public function lines(int $lines)
    {
        $this->lines = $lines;

        return $this;
    }

    public function beforeRender(Options $options)
    {
        if ($this->fontSize === null) {
            $this->fontSize = $options->fontSize;
        }

        if ($this->fontType === null) {
            $this->fontType = $options->font;
        }

        $this->width = Units::mmToDots($this->width, $options->dpi);
    }

    public function toZpl()
    {
        if ($this->bold) {
            return $this->toBoldZpl();
        }

        return join('', [
            "^A{$this->fontType},,{$this->fontSize}",
            "^FO$this->x,$this->y",
            "^FH",
            "^FB{$this->width},{$this->lines},0,{$this->alignment}",
            "^FD$this->text",
            "^FS"
        ]);
    }

    protected function toBoldZpl()
    {
        $this->bold = false;

        $zpl = $this->toZpl();

        $this->x -= 1;
        $zpl .= $this->toZpl();

        $this->x += 1;
        $this->y -= 1;
        $zpl .= $this->toZpl();

        return $zpl;
    }
}
