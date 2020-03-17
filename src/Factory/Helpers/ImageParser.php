<?php

namespace IMusic\ZplBuilder\Factory\Helpers;

class ImageParser
{
    /**
     * The GD image resource.
     *
     * @var resource
     */
    protected $image;

    public function __construct(string $data, float $scale)
    {
        $data = \base64_decode($data);
        $image = \imagecreatefromstring($data);

        if (!$image) {
            throw new \InvalidArgumentException('Could not read image');
        }

        if (!imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }

        imagefilter($image, IMG_FILTER_GRAYSCALE);
        $image = \imagescale($image, \imagesx($image) * $scale);

        $this->image = $image;
    }

    /**
     * Destroy the instance.
     */
    public function __destruct()
    {
        imagedestroy($this->image);
    }

    public function width(): int
    {
        return imagesx($this->image);
    }

    public function height(): int
    {
        return imagesy($this->image);
    }

    public function getBitAt(int $x, int $y): int
    {
        $color = \imagecolorat($this->image, $x, $y);
        $transparency = ($color >> 24) & 0x7F;

        if ($transparency > 20) {
            return 0;
        }

        return ($color & 0xFF) < 127 ? 1 : 0;
    }
}
