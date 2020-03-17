<?php

namespace IMusic\ZplBuilder\Tests\Unit;

use IMusic\ZplBuilder\Factory\Label;
use IMusic\ZplBuilder\Tests\Unit\TestCase;
use IMusic\ZplBuilder\Factory\Elements\Text;
use IMusic\ZplBuilder\Factory\Elements\Barcode;
use IMusic\ZplBuilder\Factory\Helpers\FontSize;
use IMusic\ZplBuilder\Factory\Helpers\BarcodeSize;
use IMusic\ZplBuilder\Factory\Helpers\BarcodeType;

class ZplTextTest extends TestCase
{

    public function testCanGenerateRegularText()
    {
        $label = new Label("30m", "21mm");

        $text = (new Text("BX000371", FontSize::SIZE_30))
            ->bold()
            ->x("4mm")
            ->y("1mm");
        $label->addElement($text);

        $barcodeContent = '9788797115800';
        $barcode = (new Barcode(
            $barcodeContent,
            BarcodeSize::SIZE_42,
            BarcodeType::CODE_128
        ))
        ->x("0mm")
        ->y("5mm");

        $label->addElement($barcode);

        $label->addElement(
            (new Text("Lager 140219", FontSize::SIZE_8))->x("1mm")->y("12mm")
        );
        $label->addElement(
            (new Text("TV2 | Live i digterne", FontSize::SIZE_8))
            ->width('28mm')
            ->lines(4)
            ->x("1mm")
            ->y("15mm")
        );

        $zpl = $label->toZpl();

        $this->assertStringContainsString('^FDBX000371^FS^AAC,,30^FO46.2,11.8^FH^FB295,2,0,L^FDBX000371^FS^AAC,,30^FO47.2,10.8^FH^FB295,2,0,L^FDBX000371^FS^FO0,59^BY2.36,2,42^BC^FD9788797115800^FS', $zpl);
        $this->assertStringContainsString('^BY2.36,2,42^BC^FD9788797115800^FS', $zpl);
        $this->assertStringContainsString('^AAC,,8^FO11.8,141.6^FH^FB295,2,0,L^FDLager 140219^FS', $zpl);
        $this->assertStringContainsString('^AAC,,8^FO11.8,177^FH^FB330.4,4,0,L^FDTV2 | Live i digterne^FS', $zpl);
    }
}
