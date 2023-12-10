<?php

declare(strict_types=1);

function validate($strCedula): void
{
    if (null === $strCedula || empty($strCedula)) { //compruebo si que el numero enviado es vacio o null
        echo 'Por Favor Ingrese la Cedula';
    } else { //caso contrario sigo el proceso
        if (is_numeric($strCedula)) {
            $total_caracteres = mb_strlen($strCedula); // se suma el total de caracteres
            if (10 === $total_caracteres) { //compruebo que tenga 10 digitos la cedula
                $nro_region = mb_substr($strCedula, 0, 2); //extraigo los dos primeros caracteres de izq a der
                if ($nro_region >= 1 && $nro_region <= 24) { // compruebo a que region pertenece esta cedula//
                    $ult_digito = mb_substr($strCedula, -1, 1); //extraigo el ultimo digito de la cedula
                    //extraigo los valores pares//
                    $valor2 = mb_substr($strCedula, 1, 1);
                    $valor4 = mb_substr($strCedula, 3, 1);
                    $valor6 = mb_substr($strCedula, 5, 1);
                    $valor8 = mb_substr($strCedula, 7, 1);
                    $suma_pares = ($valor2 + $valor4 + $valor6 + $valor8);
                    //extraigo los valores impares//
                    $valor1 = mb_substr($strCedula, 0, 1);
                    $valor1 = ($valor1 * 2);
                    if ($valor1 > 9) {
                        $valor1 = ($valor1 - 9);
                    }

                    $valor3 = mb_substr($strCedula, 2, 1);
                    $valor3 = ($valor3 * 2);
                    if ($valor3 > 9) {
                        $valor3 = ($valor3 - 9);
                    }

                    $valor5 = mb_substr($strCedula, 4, 1);
                    $valor5 = ($valor5 * 2);
                    if ($valor5 > 9) {
                        $valor5 = ($valor5 - 9);
                    }

                    $valor7 = mb_substr($strCedula, 6, 1);
                    $valor7 = ($valor7 * 2);
                    if ($valor7 > 9) {
                        $valor7 = ($valor7 - 9);
                    }

                    $valor9 = mb_substr($strCedula, 8, 1);
                    $valor9 = ($valor9 * 2);
                    if ($valor9 > 9) {
                        $valor9 = ($valor9 - 9);
                    }


                    $suma_impares = ($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
                    $suma = ($suma_pares + $suma_impares);
                    $dis = mb_substr($suma, 0, 1); //extraigo el primer numero de la suma
                    $dis = (($dis + 1) * 10); //luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
                    $digito = ($dis - $suma);
                    if (10 === $digito) {
                        $digito = '0';
                    }
                    //si la suma nos resulta 10, el decimo digito es cero
                    if ($digito === $ult_digito) { //comparo los digitos final y ultimo
                        echo 'Cedula Correcta';
                    } else {
                        echo 'Cedula Incorrecta';
                    }
                } else {
                    echo 'Este Nro de Cedula no corresponde a ninguna provincia del ecuador';
                }
            } else {
                echo 'Es un Numero y tiene solo' . $total_caracteres;
            }
        } else {
            echo 'Esta Cedula no corresponde a un Nro de Cedula de Ecuador';
        }
    }
}
