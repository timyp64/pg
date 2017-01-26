<?php
/** 11.01.2017 */
/**
 * Массив маршрутов
 */
return [
  '' => 'index/index',
  'account' => 'account/index',
  'account/fin' => 'account/fin',
  'account/fin/finop' => 'account/finop',
  'account/user' => 'account/user',
  'account/user/([a-z0-9-_]+)' => 'account/user',
  'account/user/([a-z0-9-_]+)/([a-z0-9-_]+)/([a-z0-9-_]+)' => 'account/user', // удалить ТЕСТ

];

