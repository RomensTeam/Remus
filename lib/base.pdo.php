<?php
/**
 * Класс для доступа к базе данных через PDO
 *
 * @author Romens
 * @todo SELECT - выборку из базы данных; 
 * @todo INSERT - вставку в базу данных; 
 * @todo DELETE - удаление из базы данных;
 * @todo CHECK  - проверка занчений из базы данных;
 */

class PDO {
    private $pdo;
    private $link;
    private $host;
    private $login;
    private $pass;
    private $base;
    public  $error = FALSE;
    public  $insert_id;
    
    
}

?>
