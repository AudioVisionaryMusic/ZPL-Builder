<?php

namespace IMusic\ZplBuilder\Factory\Elements;

class QRCode extends Element
{
    protected string $text;
    protected string $magnification;

    public function __construct(string $text, string $magnification)
    {
        $this->text = $text;
        $this->magnification = $magnification;
    }

    public function toZpl()
    {
        return join('', [
            "^FO$this->x,$this->y",
            "^BQN,2,$this->magnification",
            "^FD$this->text",
            "^FS"
        ]);
    }
}
