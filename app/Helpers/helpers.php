<?php
// ¡¡¡ IMPORTANTE !!!
// Ejecutar composer dump-autoload despues de cada modificación

if (!function_exists('validarCUPS')) {
    /**
     * Valida un número CUPS (Código Único de Punto de Suministro) español.
     *
     * @param string $cups El número CUPS a validar.
     * @return bool Devuelve true si el número CUPS es válido, false en caso contrario.
     */
    function validarCUPS($cups)
    {
        // Lista de letras usadas para el cálculo de los dígitos de control
        $lista_de_letras = 'TRWAGMYFPDXBNJZSQVHLCKE';

        // Verificar la longitud del CUPS, debe ser entre 20 y 22 caracteres
        if (strlen($cups) < 20 || strlen($cups) > 22) {
            return false; // Longitud incorrecta
        }

        // Extraer la parte numérica del CUPS, del carácter 3 al 18 (16 caracteres)
        $sParteNumerica = substr($cups, 2, 16);
        if (!ctype_digit($sParteNumerica)) {
            return false; // Parte no numérica
        }

        // Convertir la parte numérica a un número entero
        $iNumero = (int)$sParteNumerica;

        // Calcular el resto de la división del número entre 529
        $iResto = $iNumero % 529;

        // Calcular los dígitos de control esperados usando la lista de letras
        $controlEsperado = $lista_de_letras[(int)floor($iResto / 23)] . $lista_de_letras[$iResto % 23];


        // Extraer los dígitos de control del CUPS (últimos 2 caracteres)
        $dc = substr($cups, 18, 2);

        // Comparar los dígitos de control extraídos con los calculados
        return strtoupper($dc) === $controlEsperado;
    }
}


if (!function_exists('validarIBAN')) {
    /**
     * Valida un IBAN.
     *
     * @param string $iban El IBAN a validar.
     * @return bool Devuelve true si el IBAN es valido, false si no lo es.
     */
    function validarIBAN($iban)
    {
        if (strlen($iban) < 5) return false;
        $iban = strtolower(str_replace(' ', '', $iban));
        $Countries = array('al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
        $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

        if (array_key_exists(substr($iban, 0, 2), $Countries) && strlen($iban) == $Countries[substr($iban, 0, 2)]) {

            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray as $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    if (!isset($Chars[$MovedCharArray[$key]])) return false;
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return true;
            }
        }
        return false;
    }

    if (!function_exists('responsiveColumns')) {
        function responsiveColumns($default, $lg = null, $md = null, $sm = null, $xs = null): array
        {
            return [
                'default' => $default,
                'lg' => $lg ?? $default,
                'md' => $md ?? $default,
                'sm' => $sm ?? $default,
                'xs' => $xs ?? $default,
            ];
        }
    }
    
    if (!function_exists('responsiveColumnSpan')) {
        function responsiveColumnSpan($default, $lg = null, $md = null, $sm = null, $xs = null): array
        {
            return [
                'default' => $default,
                'lg' => $lg ?? $default,
                'md' => $md ?? $default,
                'sm' => $sm ?? $default,
                'xs' => $xs ?? $default,
            ];
        }
    }    
}