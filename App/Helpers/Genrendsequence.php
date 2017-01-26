<?php
/** 02.01.2017 */

namespace App\Helpers;

class Genrendsequence {
    /**
     * @return string генерирует закодированную определенным образом строку, которую в итоге можно будет разкодировать.
     * ключ к раскодировки изложен внизу скрипта
     */
    static public function CoderInt() {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n4 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n3 =  ($n6 + $n7)%10;
        $n5 =  ($n1 + $n2)%10;
        $n9 =  ($n8 + $n4)%10;
        return $n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9;
    }

    /**
     * @param $str - передается строка или набор цифр, потом она преобразуется в строку для работы
     * @return bool - true - переданное число закодированно с помощью алгоритма CoderInt(), false - нет
     */
    static public function DecoderInt($str){
        $str = (string)$str;
        if(($str[0]+$str[1])%10 == $str[4]) {
            if(($str[5]+$str[6])%10 == $str[2]){
                if (($str[7]+$str[3])%10 == $str[8]){
                    return true;
                }else return false;
            }
        }
    }
}

/**
 * ГЕНЕРИРУЕТ И ПРОВЕРЯЕТ НА ИСТИННОСТЬ ЗАДАННУЮ ПОСЛЕДОВАТЕЛЬНОСТЬ ЧИСЕЛ
 * 1+2 получается 5 число, если сумма больше 10 берется второе число
 * 6+7 получается 3 число, если сумма больше 10 берется второе число
 * 8+4 получается 9 число, если сумма больше 10 берется второе число
 */