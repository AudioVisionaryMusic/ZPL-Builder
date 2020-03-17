<?php

namespace IMusic\ZplBuilder\Factory\Elements;

use IMusic\ZplBuilder\Factory\Elements\Element;

class PageEnd extends Element
{
    public function toZpl()
    {
        return '^XZ';
    }
}
