<?php

namespace IMusic\ZplBuilder\Factory;

use IMusic\ZplBuilder\Factory\Utils\Units;
use IMusic\ZplBuilder\Factory\Helpers\DPI;
use IMusic\ZplBuilder\Factory\Elements\Element;
use IMusic\ZplBuilder\Factory\Elements\PageEnd;
use IMusic\ZplBuilder\Factory\Helpers\FontSize;
use IMusic\ZplBuilder\Factory\Helpers\FontType;
use IMusic\ZplBuilder\Factory\Helpers\PrintMode;
use IMusic\ZplBuilder\Factory\Elements\PageStart;
use IMusic\ZplBuilder\Factory\Interfaces\ZplElementInterface;

class Label implements ZplElementInterface
{
    protected float $width;
    protected float $height;
    protected Options $options;

    protected array $elements = [];

    public function __construct(string $width, string $height, ?Options $options = null)
    {
        $this->options = $options ?: new Options(
            DPI::DPI_300,
            FontType::AC,
            FontSize::SIZE_15,
            PrintMode::TEAR_OFF
        );

        $this->width = Units::mmToDots($width, $this->options->dpi);
        $this->height = Units::mmToDots($height, $this->options->dpi);

        $page = new PageStart($this->width, $this->height);
        $this->addElement($page);
    }

    public function addElement(Element $component)
    {
        $this->elements[] = $component;
        $component->covertXY($this->options);

        return $this;
    }

    public function toZpl()
    {
        $this->addElement(new PageEnd());

        $str = '';
        foreach ($this->elements as $component) {
            $str .= $component->toZpl();
        }

        return $str;
    }
}
