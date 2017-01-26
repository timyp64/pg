<div style="background-color:#FF8673; padding: 5px 0 5px 20px">
    <p>В процессе выполнения программы возникла ошибка <?= $this->contExcept->textExcCod ?>: <span
                style="font-weight: bold"><?= $this->contExcept->textExc ?></span></p>
    <p>Для устранения ошибки рекомендуеться: <span style="font-weight: bold"><?= $this->contExcept->textExcSol ?></span>
    </p>
    <?php if ($this->contExcept->textExcOther !== '') {
        echo "<p>Дополнительная информация: <span style=\"font-weight: bold\">" . $this->contExcept->textExcSol . "</span></p>";
    }
    if ($this->contExcept->fileExc !== '') {
        echo "<p>Файл в котором возникла ошибка: <span style=\"font-weight: bold\">" . $this->contExcept->fileExc . "</span></p>";
    }
    if ($this->contExcept->strCodeExc !== '') {
        echo "<p>Строка кода в котором возникла ошибка: <span style=\"font-weight: bold\">" . $this->contExcept->strCodeExc . "</span></p>";
    } ?>
</div>

