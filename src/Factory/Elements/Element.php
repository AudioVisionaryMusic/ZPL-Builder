<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Options;
use IMusic\ZplBuilder\Factory\Utils\Units;
use IMusic\ZplBuilder\Factory\Interfaces\ZplElementInterface;

abstract class Element implements ZplElementInterface
{
    protected string $x;
    protected string $y;

    public function x(string $x)
    {
        $this->x = $x;

        return $this;
    }

    public function y(string $y)
    {
        $this->y = $y;

        return $this;
    }

    public function covertXY(Options $options)
    {
        if (isset($this->x, $this->y)) {
            $this->x = Units::mmToDots($this->x, $options->dpi);
            $this->y = Units::mmToDots($this->y, $options->dpi);
        }

        if (method_exists($this, 'beforeRender')) {
            call_user_func([$this, 'beforeRender'], $options);
        }
    }
}
