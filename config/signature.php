<?php

declare(strict_types=1);

return [
    "dot-size" => (int)env("SIGNATURE_DOT_SIZE"),
    "line-min-width" => (float)env("SIGNATURE_LINE_MIN_WIDTH"),
    "line-max-width" => (float)env("SIGNATURE_LINE_MAX_WIDTH"),
    "throttle" => (int)env("SIGNATURE_THROTTLE"),
    "min-distance" => (int)env("SIGNATURE_MIN_DISTANCE"),
    "velocity-filter-weight" => (float)env("SIGNATURE_VELOCITY_FILTER_WEIGHT"),
    "hex-pen-color" => env("SIGNATURE_HEX_PEN_COLOR"),
    "hex-pen-color-on-dark" => env("SIGNATURE_HEX_DARK_PEN_COLOR") ?? (string)env("SIGNATURE_HEX_PEN_COLOR"),
];
