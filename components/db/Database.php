<?php

class Database
{
    private $_driver;
    private $_host;
    private $_db_name;
    private $_db_user;
    private $_db_password;
    private $_charset;
    private $_options;

    public function dbConnect()
    {
        $this->_driver = 'mysql'; // тип базы данных, с которой мы будем работать
        $this->_host = '127.0.0.1'; // альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
        $this->_db_name = 'blog'; // имя базы данных
        $this->_db_user = 'root'; // имя пользователя для базы данных
        $this->_db_password = ''; // пароль пользователя
        $this->_charset = 'utf8'; // кодировка по умолчанию
        $this->_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений

        $dsn = "$this->_driver:host=$this->_host;dbname=$this->_db_name;charset=$this->_charset";

        $pdo = new PDO(
            $dsn,
            $this->_db_user,
            $this->_db_password,
            $this->_options
        );

        return $pdo;
    }
}