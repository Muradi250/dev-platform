<?php

namespace App\Blocks\Helpers;


class DividerShapes
{


    public static function render(
        string $shape,
        string $color = '#e5e7eb'
    ): string {


        return match($shape) {


            'wave' =>
                self::wave($color),


            'curve' =>
                self::curve($color),


            'triangle' =>
                self::triangle($color),


            'slant' =>
                self::slant($color),


            'mountain' =>
                self::mountain($color),


            'zigzag' =>
                self::zigzag($color),


            'steps' =>
                self::steps($color),


            'arrow' =>
                self::arrow($color),


            'circle' =>
                self::circle($color),


            'cloud' =>
                self::cloud($color),


            'blob' =>
                self::blob($color),


            'dots' =>
                self::dots($color),


            default => '',


        };


    }





    private static function wave($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 40C300 120 900 0 1200 80V120H0Z"/>

</svg>

SVG;

    }





    private static function curve($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 80Q600 0 1200 80V120H0Z"/>

</svg>

SVG;

    }





    private static function triangle($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 120L600 0L1200 120Z"/>

</svg>

SVG;

    }





    private static function slant($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 0L1200 100V120H0Z"/>

</svg>

SVG;

    }





    private static function mountain($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 120L200 40L400 100L700 20L1000 90L1200 30V120Z"/>

</svg>

SVG;

    }





    private static function zigzag($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 80L100 20L200 80L300 20L400 80L500 20L600 80L700 20L800 80L900 20L1000 80L1100 20L1200 80V120H0Z"/>

</svg>

SVG;

    }





    private static function steps($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 120V80H200V60H400V40H600V20H800V0H1200V120Z"/>

</svg>

SVG;

    }





    private static function arrow($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 0H500L600 120L700 0H1200V120H0Z"/>

</svg>

SVG;

    }





    private static function circle($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 120Q300 0 600 120Q900 0 1200 120V120H0Z"/>

</svg>

SVG;

    }





    private static function cloud($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 80C150 20 250 100 400 50C550 0 650 100 800 50C950 0 1050 80 1200 40V120H0Z"/>

</svg>

SVG;

    }





    private static function blob($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<path fill="{$color}"
d="M0 70C200 20 400 120 600 60C800 0 1000 100 1200 40V120H0Z"/>

</svg>

SVG;

    }





    private static function dots($color): string
    {

        return <<<SVG

<svg viewBox="0 0 1200 120"
xmlns="http://www.w3.org/2000/svg">

<circle cx="200" cy="60" r="8" fill="{$color}"/>
<circle cx="400" cy="60" r="8" fill="{$color}"/>
<circle cx="600" cy="60" r="8" fill="{$color}"/>
<circle cx="800" cy="60" r="8" fill="{$color}"/>
<circle cx="1000" cy="60" r="8" fill="{$color}"/>

</svg>

SVG;

    }


}