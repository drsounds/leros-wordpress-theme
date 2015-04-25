<?php
/** 
 * Code based on http://serennu.com/colour/rgbtohsl.php
 * 
 */

// Function to convert hue to RGB, called from above

function serennu_hue_2_rgb($v1,$v2,$vh)
{
    if ($vh < 0)
    {
            $vh += 1;
    };

    if ($vh > 1)
    {
            $vh -= 1;
    };

    if ((6 * $vh) < 1)
    {
            return ($v1 + ($v2 - $v1) * 6 * $vh);
    };

    if ((2 * $vh) < 1)
    {
            return ($v2);
    };

    if ((3 * $vh) < 2)
    {
            return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
    };

    return ($v1);
};

function serennu_calculate_complementary_colour ($hexcode) {
    $redhex  = substr($hexcode,0,2);
    $greenhex = substr($hexcode,2,2);
    $bluehex = substr($hexcode,4,2);

    $var_r = (hexdec($redhex)) / 255;
    $var_g = (hexdec($greenhex)) / 255;
    $var_b = (hexdec($bluehex)) / 255;

    // Input is $var_r, $var_g and $var_b from above
    // Output is HSL equivalent as $h, $s and $l — these are again expressed as fractions of 1, like the input values

    $var_min = min($var_r,$var_g,$var_b);
    $var_max = max($var_r,$var_g,$var_b);
    $del_max = $var_max - $var_min;

    $l = ($var_max + $var_min) / 2;

    if ($del_max == 0)
    {
            $h = 0;
            $s = 0;
    }
    else
    {
            if ($l < 0.5)
            {
                    $s = $del_max / ($var_max + $var_min);
            }
            else
            {
                    $s = $del_max / (2 - $var_max - $var_min);
            };

            $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
            $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
            $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

            if ($var_r == $var_max)
            {
                    $h = $del_b - $del_g;
            }
            elseif ($var_g == $var_max)
            {
                    $h = (1 / 3) + $del_r - $del_b;
            }
            elseif ($var_b == $var_max)
            {
                    $h = (2 / 3) + $del_g - $del_r;
            };

            if ($h < 0)
            {
                    $h += 1;
            };

            if ($h > 1)
            {
                    $h -= 1;
            };
    };

    // Calculate the opposite hue, $h2

    $h2 = $h + 0.5;

    if ($h2 > 1)
    {
            $h2 -= 1;
    };

    // Input is HSL value of complementary colour, held in $h2, $s, $l as fractions of 1
    // Output is RGB in normal 255 255 255 format, held in $r, $g, $b
    // Hue is converted using function hue_2_rgb, shown at the end of this code

    if ($s == 0)
    {
        $r = $l * 255;
        $g = $l * 255;
        $b = $l * 255;
    }
    else
    {
        if ($l < 0.5)
        {
                $var_2 = $l * (1 + $s);
        }
        else
        {
                $var_2 = ($l + $s) - ($s * $l);
        };

        $var_1 = 2 * $l - $var_2;
        $r = 255 * serennu_hue_2_rgb($var_1,$var_2,$h2 + (1 / 3));
        $g = 255 * serennu_hue_2_rgb($var_1,$var_2,$h2);
        $b = 255 * serennu_hue_2_rgb($var_1,$var_2,$h2 - (1 / 3));
    };



    $rhex = sprintf("%02X",round($r));
    $ghex = sprintf("%02X",round($g));
    $bhex = sprintf("%02X",round($b));

    $rgbhex = $rhex.$ghex.$bhex;
    return $rgbhex;
}
