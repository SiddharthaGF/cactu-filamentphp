<?php

declare(strict_types=1);

namespace App\Filament\Validations;

class DniOrRucValidator
{
    public static function validate(string $dni): bool
    {
        try {
            if ($dni === null || empty($dni)) {
                return false;
            } else {
                if (is_numeric($dni)) {

                    $len = strlen($dni);
                    if ($len === 10) {
                        $region = (int) substr($dni, 0, 2);

                        if ($region >= 1 && $region <= 24) {
                            $last = (int) mb_substr($dni, -1, 1);

                            $value2 = (int) mb_substr($dni, 1, 1);
                            $value4 = (int) mb_substr($dni, 3, 1);
                            $value6 = (int) mb_substr($dni, 5, 1);
                            $value8 = (int) mb_substr($dni, 7, 1);
                            $pairSum = ($value2 + $value4 + $value6 + $value8);

                            $value1 = (int) mb_substr($dni, 0, 1);
                            $value1 = ($value1 * 2);

                            if ($value1 > 9) {
                                $value1 = ($value1 - 9);
                            }

                            $value3 = (int) mb_substr($dni, 2, 1);
                            $value3 = ($value3 * 2);
                            if ($value3 > 9) {
                                $value3 = ($value3 - 9);
                            }

                            $value5 = (int) mb_substr($dni, 4, 1);
                            $value5 = ($value5 * 2);
                            if ($value5 > 9) {
                                $value5 = ($value5 - 9);
                            }

                            $value7 = (int) mb_substr($dni, 6, 1);
                            $value7 = ($value7 * 2);
                            if ($value7 > 9) {
                                $value7 = ($value7 - 9);
                            }

                            $value9 = (int) mb_substr($dni, 8, 1);
                            $value9 = ($value9 * 2);
                            if ($value9 > 9) {
                                $value9 = ($value9 - 9);
                            }

                            $oddSum = ($value1 + $value3 + $value5 + $value7 + $value9);
                            $sum = ($pairSum + $oddSum);
                            $dis = (int) mb_substr((string) $sum, 0, 1);

                            $dis = (($dis + 1) * 10);

                            $current = ($dis - $sum);

                            if ($current == 10) {
                                $current = 0;
                            }



                            if ($current == $last) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());

            return false;
        }
    }
}
