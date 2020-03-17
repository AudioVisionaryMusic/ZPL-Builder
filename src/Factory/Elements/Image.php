<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Helpers\ImageParser;

class Image extends Element
{
    protected string $data;
    protected ImageParser $image;
    protected string $ascii;
    protected int $scale;

    public function __construct(string $data, float $scale = 1)
    {
        $this->data = preg_replace('/^data:image\/[^;]+;base64,/', '', $data);
        $this->scale = $scale;
    }

    public function bytesPerRow(): int
    {
        return (int) ceil($this->image->width() / 8);
    }

    public function height()
    {
        return $this->image->height();
    }

    public function byteCount()
    {
        return $this->bytesPerRow() * $this->height();
    }

    public function toZpl()
    {
        $this->image = new ImageParser($this->data, $this->scale);

        $height = $this->image->height();

        return join('', [
            "^FO$this->x,$height",
            "^GFA,{$this->byteCount()},{$this->byteCount()},{$this->bytesPerRow()},{$this->toAscii()}"
        ]);
    }

    public function toAscii(): string
    {
        return $this->ascii ?: $this->ascii = $this->encode();
    }

    /**
     * Encode the image in ASCII hexadecimal by looping over every pixel.
     *
     * @return string
     */
    protected function encode(): string
    {
        $bitmap = null;
        $lastRow = null;
        for ($y = 0; $y < $this->image->height(); $y++) {
            $bits = null;

            for ($x = 0; $x < $this->image->width(); $x++) {
                $bits .= $this->image->getBitAt($x, $y);
            }
            $bytes = str_split($bits, 8);
            $bytes[] = str_pad(array_pop($bytes), 8, '0');
            $row = null;
            foreach ($bytes as $byte) {
                $row .= sprintf('%02X', bindec($byte));
            }
            $bitmap .= $this->compress($row, $lastRow);
            $lastRow = $row;
        }
        return $bitmap;
    }

    /**
     * Compress a row of ASCII hexadecimal data.
     *
     * @param string $row
     * @param string $lastRow
     * @return string
     */
    protected function compress(string $row, ?string $lastRow): string
    {
        if ($row === $lastRow) {
            return ':';
        }

        $row = $this->compressTrailingZerosOrOnes($row);
        $row = $this->compressRepeatingCharacters($row);
        return $row;
    }

    /**
     * Replace trailing zeros or ones with a comma (,) or exclamation (!) respectively.
     *
     * @param string $row
     * @return string
     */
    protected function compressTrailingZerosOrOnes(string $row): string
    {
        return preg_replace(['/0+$/', '/F+$/'], [',', '!'], $row);
    }
    /**
     * Compress characters which repeat.
     *
     * @param string $row
     * @return string
     */
    protected function compressRepeatingCharacters(string $row): string
    {
        $callback = function ($matches) {
            $original = $matches[0];
            $repeat = strlen($original);
            $count = null;
            if ($repeat > 400) {
                $count .= str_repeat('z', floor($repeat / 400));
                $repeat %= 400;
            }
            if ($repeat > 19) {
                $count .= chr(ord('f') + floor($repeat / 20));
                $repeat %= 20;
            }
            if ($repeat > 0) {
                $count .= chr(ord('F') + $repeat);
            }
            return $count . substr($original, 1, 1);
        };
        return preg_replace_callback('/(.)(\1{2,})/', $callback, $row);
    }
}
