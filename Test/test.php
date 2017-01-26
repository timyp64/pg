<?php
/**04.01.2017 14:46 */
namespace Test;

class Test{

    static public function Test() {
        $uri = "account/user/23-4_/cont1/-/23";
        $routPregPattern = "account\/user\/([a-z0-9-_]+)\/cont1\/([a-z0-9-_]+)\/([a-z0-9_]+)";
        // после нахождения соответствия введеного URL и $newUrlPatt вычленяем параметры из введеной строки
        preg_match_all("~".$routPregPattern."~", $uri ,$m);
        // делаем один массив из параметров
        var_dump($m);
        array_shift($m);
        for($i = 0; $i < count($m) ; $i++ ){
            $param[] =  $m[$i][0] ;
            echo "<br>";
            echo "Значение параметра: ".$param[$i];
        }
        echo "<br>";
        //call_user_func_array();


//               echo "<br>";
//               echo "Значение параметра: ".$param[0];
//               echo "<br>";
//               echo "Значение параметра: ".$param[1];

          /*       //echo  preg_replace('/%(.+)%/U',"" ,$routPregPattern);
              //preg_match_all('/%(.+)%/U', $routPregPattern, $matches);
               //echo $matches[0][0];
              // print_r($matches);

       */
        $url = "account/user/444";
        $urlPregPattern = "account/user/([0-9]+)";




        $uri = "user/id.value=233454";


        //$uri = "user/234";
        if (preg_match("~^user/(?P<nameParametr>[a-z]+)\.value=(?P<valueParamer>[0-9]+)$~", $uri,$m)) {
            //var_dump($m);
            //echo "<br>";
            //print_r($m);
            // В СТРОКЕ НЕОБХОДИМО НАЙТИ ПАРАМЕТРЫ
            // название параметра будет иметь вот такие ограничители {[pn= ]}
            // ищем в строке {[pn= ]}
            //echo $m['nameParametr'];echo "<br>";
            //echo $m['valueParamer'];
            //if(is_numeric($m['nameParametr'])) echo "Это число";

        };






        $contr = "UserController";
        $action = "actionIndex";
        $nameParametr = "id";
        $valueParamer = "234";

        echo "<br><br><i style='margin-left: 30px'>Должно получится так вот:</i><br>";
        echo "<b>Контроллер:</b> " . $contr;
        echo "<br><b>Экшн:</b> " . $action;
        echo "<br><b>Название паратетра:</b> " . $nameParametr;
        echo "<br><b>Значение параметра:</b> " . $valueParamer;
    }

    static public function Test2() {
        $uri = "account/user/234/cont1/cont2/wm";
       $routPregPattern = "account/user/%id%([0-9]+)/cont1/cont2/%type%([a-z]+)";
        preg_match_all('/%(.+)%/U', $routPregPattern, $matches);
        // записываем в массив названия параметров проганяя его через цикл
        for($i = 0; $i < count($matches) ; $i++ ){
            $param[] =  $matches[1][$i] ;
        }

             echo "<br>";
             echo "То что будет записано в роутах: ".$routPregPattern;
             echo "<br>";
             echo "Название параметра: ". $param[0];
             echo "<br>";
             echo "Название параметра: ". $param[1];
             // убираем из строки взятой из массива роутов все что находится между %%.
             $newUrlPatt = preg_replace('/%(.+)%/U',"" ,$routPregPattern);

            echo "<br>";
             echo "То что:".$newUrlPatt;
             echo "<br>";
             // после нахождения соответствия введеного URL и $newUrlPatt вычленяем параметры из введеной строки
             preg_match_all("~".$newUrlPatt."~", $uri ,$m);
          // делаем один массив из параметров
             /*
             echo "<br>";
             echo "Значение параметра ". $matches[1][0]." = ".$m[1][0];
             echo "<br>";
             echo "Значение параметра ". $matches[1][1]." = ".$m[2][0];

             //echo  preg_replace('/%(.+)%/U',"" ,$routPregPattern);
            //preg_match_all('/%(.+)%/U', $routPregPattern, $matches);
             //echo $matches[0][0];
            // print_r($matches);

     */
       $url = "account/user/444";
       $urlPregPattern = "account/user/([0-9]+)";




        $uri = "user/id.value=233454";


        //$uri = "user/234";
        if (preg_match("~^user/(?P<nameParametr>[a-z]+)\.value=(?P<valueParamer>[0-9]+)$~", $uri,$m)) {
            //var_dump($m);
            //echo "<br>";
            //print_r($m);
            // В СТРОКЕ НЕОБХОДИМО НАЙТИ ПАРАМЕТРЫ
            // название параметра будет иметь вот такие ограничители {[pn= ]}
            // ищем в строке {[pn= ]}
            //echo $m['nameParametr'];echo "<br>";
            //echo $m['valueParamer'];
            //if(is_numeric($m['nameParametr'])) echo "Это число";

        };






        $contr = "UserController";
        $action = "actionIndex";
        $nameParametr = "id";
        $valueParamer = "234";

        echo "<br><br><i style='margin-left: 30px'>Должно получится так вот:</i><br>";
        echo "<b>Контроллер:</b> " . $contr;
        echo "<br><b>Экшн:</b> " . $action;
        echo "<br><b>Название паратетра:</b> " . $nameParametr;
        echo "<br><b>Значение параметра:</b> " . $valueParamer;
    }
}