<?php
function createTable($host,$username,$password,$db_name)
{

    $con = mysql_connect($host,$username,$password);
    if (!$con) {
        echo "chenhai";
        die('could not connect:' . mysql_error());
    }

    mysql_query("set names utf8;");

    mysql_select_db($db_name,$con);

    $sqlstr = "DROP TABLE IF EXISTS department";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    echo "1";
    $sqlstr = "CREATE TABLE department (
        dpname VARCHAR(40) PRIMARY KEY,
        admin VARCHAR(40) NOT NULL,
        pwd VARCHAR(40) NOT NULL
    )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    $sqlstr = "DROP TABLE IF EXISTS keshi";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    $sqlstr = "CREATE TABLE keshi (
        kno INT AUTO_INCREMENT PRIMARY KEY,
        kname varchar(80) not null unique,
        depname varchar(40) not null,
        eno INT,
        callno CHAR(12) NOT NULL,
        foreign key (depname) references department(dpname)
        on delete cascade
        on update cascade
    )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
    echo "3";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    $sqlstr = "DROP TABLE IF EXISTS employee";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    $sqlstr = "CREATE TABLE employee (
        eno INT AUTO_INCREMENT PRIMARY KEY,
        kno int,
        ename VARCHAR(20) NOT NULL,
        phone VARCHAR(14),
        idcard VARCHAR(18),
        callno CHAR(12) NOT NULL,
        FOREIGN KEY (kno)
        REFERENCES keshi (kno)
        on delete cascade
        on update cascade
    )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    $sqlstr = "DROP VIEW IF EXISTS epk";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    $sqlstr = "CREATE ALGORITHM = UNDEFINED 
        DEFINER = `root`@`localhost` 
        SQL SECURITY DEFINER
        VIEW `epk` AS
        SELECT 
        `employee`.`ename` AS `ename`,
        `employee`.`phone` AS `phone`,
        `keshi`.`kname` AS `kname`,
        `employee`.`callno` AS `callno`
        FROM
        (`employee`
        JOIN `keshi`)
        WHERE
        (`employee`.`kno` = `keshi`.`kno`);";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    $sqlstr = "DROP PROCEDURE IF EXISTS kbe";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    $sqlstr = "CREATE DEFINER=`root`@`localhost` PROCEDURE `kbe`(keshi char(80),kezhang char(30)) 
    BEGIN
    declare kid int;
    declare eid int;
    select kno into kid from keshi where kname=keshi;
    update employee set kno=kid where ename=kezhang; 
    select eno into eid from employee where ename=kezhang; 
    UPDATE keshi SET eno = eid WHERE kname = keshi;
    END";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    $sqlstr = "DROP PROCEDURE IF EXISTS etk";
    mysql_query($sqlstr,$con);//如果表存在直接删除
    $sqlstr = "CREATE DEFINER=`root`@`localhost` PROCEDURE `etk`(ena char(30),kna char(80)) 
    BEGIN 
    declare en int;
    declare kn int; 
    select kno into kn from keshi where kname=kna;
    update employee set kno=kn where ename=ena;
    END";
    if (false == mysql_query($sqlstr,$con)) {
        alert("error");
        return ;
    }

    mysql_close($con);
}
createTable("localhost","root","123123","epost"); 
?>
