<?php

namespace IMusic\ZplBuilder\Tests\Unit;

use IMusic\ZplBuilder\Factory\Label;
use IMusic\ZplBuilder\Tests\Unit\TestCase;
use IMusic\ZplBuilder\Factory\Elements\Text;
use IMusic\ZplBuilder\Factory\Elements\Barcode;
use IMusic\ZplBuilder\Factory\Helpers\FontSize;
use IMusic\ZplBuilder\Factory\Helpers\BarcodeSize;
use IMusic\ZplBuilder\Factory\Helpers\BarcodeType;
use IMusic\ZplBuilder\Factory\Helpers\DPI;
use IMusic\ZplBuilder\Factory\Helpers\FontType;
use IMusic\ZplBuilder\Factory\Helpers\PrintMode;
use IMusic\ZplBuilder\Factory\Options;

class ZplTextTest extends TestCase
{

    public function testCanGenerateRegularText()
    {
        $options = new Options(
            DPI::DPI_203,
            FontType::ZERO,
            FontSize::SIZE_35,
            PrintMode::TEAR_OFF
        );

        $label = new Label("80mm", "50mm", $options);

        $text = (new Text('$supplierItemId$', FontSize::SIZE_55))
            ->bold()
            ->width('50mm')
            ->x("25mm")
            ->y("2mm");
        $label->addElement($text);

        $barcodeContent = '$itemId$';
        $barcode = (new Barcode(
            $barcodeContent,
            BarcodeSize::SIZE_65,
            BarcodeType::CODE_128
        ))
        ->width('0.4mm')
        ->x("5mm")
        ->y("9mm");

        $label->addElement($barcode);

        $label->addElement(
            (new Text('$identifier$'))
                ->width('75mm')
                ->x("1mm")
                ->y("22mm")
        );
        $label->addElement(
            (new Text('$artist$'))
            ->width('75mm')
            ->lines(5)
            ->x("1mm")
            ->y("27mm")
        );

        $zpl = $label->toZpl();

        \file_put_contents('zpl.zpl', str_replace('^', "\n^", $zpl));

        $this->assertStringContainsString('^XA', $zpl);
        $this->assertStringContainsString('^XZ', $zpl);
    }
}
