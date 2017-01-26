<?php

namespace App\Components\ExceptionHandler;

/**
 * Class MainException
 */
class MainException
  extends \Exception {

    /**
     * @var array - Свойство хранящее в себе настройки отображения исключений
     */
    public $set = [];
    /**
     * @var int - режим работы. 0 и 1, 0 - продашин, 1 - разработка
     */
    public $mode;
    /**
     * @var array|object - контейнер с всеми текстами исключения
     */
    public $contExcept = [];
    /**
     * @var string - путь к файлу (без dirname(__FILE__))  кодов исключений. с учетом файла и расширения
     */
    public $pathExceptCodes = "";

    /**
     * MainException constructor.
     * @param string $mes
     * @param int $code
     * @param int $mode - режим работы. 0 и 1, 0 - продашин, 1 - разработка
     * @param string $pathExceptCodes - путь к файлу с кодами исключений с учетом файла и расширения
     * @param array $gset - глобальные настройки отображения, которые передаються извне. Первый симаол - вывод на экран,
     * Второй - вывод в лог, Третий - отправка email.   0 - нет, 1 - да, '' - не задано
     */
    public function __construct($mes = '', $code, $mode, $gset = ['', '', ''],
                                $pathExceptCodes = ROOT . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR .
                                'ExceptionCodes' . DIRECTORY_SEPARATOR . 'exceptcodes.ini') {
        parent::__construct($mes, $code);
        $this->pathExceptCodes = $pathExceptCodes;
        $this->mode = (int)$mode;
        $this->set = $this->comparingSettings($gset, $this->getSetErrCode());
        $this->contExcept = $this->getFullText();


    }

    /**Возврат  массив настроек указанных в конкретной ошибки
     * @return array
     */
    public function getSetErrCode() {
        $arr = $this->getErrCode()['set'][1];
        return explode(',', $arr);
    }

    /** Возвращает массив с указанием настройки отображение исключения
     * @return mixed
     */
    public function getErrCode() {
        return $this->getIniCodes()[$this->getCode()];
    }

    /** Сравнивает глобальный массив настроек и массив полученный из кода ошибки. Возвращает результрующий массив.
     * Глобальные настройки gset. Глобальные настройки всегда выше. Задаються отдельно. В случае если глобальные
     * настройки не заданны, тогда использовать настройки прописанные в кодах
     * @param $arr1 - глобальный массив настроек
     * @param $arr2 - настройки из кода исключения
     * @return array - финальный массив настроек
     */
    public function comparingSettings($arr1, $arr2) {
        $finset = [];
        if ($arr1[0] === '1') {
            $finset['display'] = 1;
        } elseif ($arr1[0] === '0') {
            $finset['display'] = 0;
        } else {
            $finset['display'] = (int)$arr2[0];
        }
        if ($arr1[1] === '1') {
            $finset['log'] = 1;
        } elseif ($arr1[1] === '0') {
            $finset['log'] = 0;
        } else {
            $finset['log'] = (int)$arr2[1];
        }
        if ($arr1[2] === '1') {
            $finset['email'] = 1;
        } elseif ($arr1[2] === '0') {
            $finset['email'] = 0;
        } else {
            $finset['email'] = (int)$arr2[2];
        }
        return $finset;
    }

    /**Возвращает массив распарсенног ini-файла с кодами ошибок
     * ВАЖНО!!! По умолчанию Коды исключений хранятся в папке настроек
     * @return array
     * @internal param string $path
     */
    public function getIniCodes() {
        return parse_ini_file($this->pathExceptCodes, true);
    }


    /**
     * @return mixed - возвращает текст значения "other"
     */
    public function getErrOtherText() {

        return $this->getErrCode()['other'];
    }

    /**
     * Главный метод который делает все действия согласно настроек.
     */
    public function actionExcept() {
        if ($this->set['display'] === 1) $this->showExceptDispl();
        if ($this->set['log'] === 1) $this->writeExceptLog();
        /*   if ($this->set['email'] === 1) {
               echo "Необходимо отправить исключение по e-mqil<br>";
           } else echo "Исключение запрещено отправлять по e-mail<br>";*/
    }

    /**
     * @return object объект у которого в свойствах строки взятые из ini-файла и из других мест
     */
    public function getFullText() {
        $content = [];
        $content['textExc'] = $this->getErrCode()['exctext'];                                           // ПОЛУЧАЕМ СТРОКУ С exctext из базы кодов ошибок
        $content['textExcSol'] = $this->getErrCode()['excsol'];                                         // ПОЛУЧАЕМ СТРОКУ С errsol из базы кодов ошибок
        $content['textExcCod'] = $this->getCode();                                                      // код исключения
        $content['textExcOther'] = $this->getErrCode()['other'];                                        // ПОЛУЧАЕМ СТРОКУ С other из базы кодов ошибок
        $this->mode === 1 ? $content['fileExc'] = $this->getFile() : $content['fileExc'] = '';          // ПОЛУЧАЕМ СТРОКУ С файлом где случилось исключение. ТОлько при условии келюченного режима разработчика
        $this->mode === 1 ? $content['strCodeExc'] = $this->getLine() : $content['strCodeExc'] = '';    // ПОЛУЧАЕМ СТРОКУ програмнымм кодом. ТОлько при условии келюченного режима разработчика
        return (object)$content;
    }

    /**
     * Отправляем на экран исключение со всеми данными. При этом испльзуем ранее заготовленный шаблон
     */
    public function showExceptDispl() {
        include_once 'template.php';    //подключаем шаблон
    }

    /**
     * @return false|string - возвращает подготовленную строку для записи в лог файл.
     */
    public function prepereLogLine() {
        $line = date('d.m.Y H:i:s');
        $line .= ' | ';
        $line .= $_SERVER['REMOTE_ADDR'];
        $line .= ' | ';
        $line .= $this->contExcept->textExcCod;
        $line .= ' | ';
        $line .= $this->contExcept->textExc;
        $line .= ' | ';
        $line .= $this->contExcept->fileExc;
        $line .= ' | ';
        $line .= $this->contExcept->strCodeExc;
        $line .= PHP_EOL;
        return $line;
    }

    /** Записываем в лог файл ранее созданную строку.
     *  ВАЖНО. В папке лог создается папка с названием класса выбросившего исключение
     *  array_pop(explode('\\',get_class($this))) - узнаем название класса, в случае наследование будет имя наследника
     */
    public function writeExceptLog() {

        $pathRoot = 'Log' . DIRECTORY_SEPARATOR;
        $path = 'Log' . DIRECTORY_SEPARATOR . $this->nameClass()  . DIRECTORY_SEPARATOR;
        if (!file_exists($pathRoot)) mkdir($pathRoot);  // создаем корневой каталог
        if (!file_exists($path)) mkdir($path);          // создаем в корневом каталоге папку с именем класса
        $namefile = $path . date('Y.m.d') . '.txt';
        file_put_contents($namefile, $this->prepereLogLine(), FILE_APPEND | LOCK_EX);
    }

    /**
     * @return mixed - возвращает название класса. Без неймспесам. В случае наследование, вызывает текущий клас (наследника)
     */
    protected function nameClass() {
        $arr = explode('\\', get_class($this));
        return array_pop($arr);
    }
}


/* Пояснение к настройкам в кодах ошибок и глобальные заданные извне
Глобальные настройки gset. Глобальные настройки всегда выше. Задаються отдельно.
Настройки конкретного кода ошибок - $set
Глобальные настройки gset. Глобальные настройки всегда выше. Задаються отдельно. В случае если глобальные настройки не заданны, тогда использовать настройки прописанные в кодах
Массив настроек
[
вывод  на экран. 0 - нет, 1 - да, '' - не задано
запись в лог. 0 - нет, 1 - да, '' - не задано
Отослать по почьте. 0 - нет, 1 - да, '' - не задано
]
*/