<?php
function insertemp()
{//从txt中的数据写入到MySQL
    $users = fopen("epost.txt","r");
    $earray= array();
    /*--------------------mysql---------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = "insert into employee values(null,null,?,?,null,?)";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('sss',$e,$c,$kj);
    $line = fgets($users);
    /*--------------------mysql---------------------*/
    while($line = fgets($users,4096))
    {
        list($e,$c,$kn,$kj) = explode("|",$line);
        $stmt->execute();
        printf("%s <br \>",$e);
    }
    fclose($users);
    $stmt->close();
    $db->close();
}
function insertKeshi()
{
    $users = fopen("epost.txt","r");
    $earray= array();
    /*--------------------mysql---------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = "insert into keshi values(null,?,'市人社局',null,?)";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss',$kn,$kj);
    $line = fgets($users);

    /*--------------------mysql---------------------*/
    $stmp = 'null';
    $count = 0;
    while($line = fgets($users,4096))
    {
        list($e,$c,$kn,$kj) = explode("|",$line);
        if($kn == $stmp)
        {
            continue;
        }
        else
        {
            $stmt->execute();
            echo $kn."_"."$kj"."<br \>";
            $stmp = $kn;
            $count++;
        }
    }
    echo $count;
    fclose($users);
    $stmt->close();
    $db->close();
} 
function empBindKeshi()
{
    #修改employee表中kno为职员所在科室
    $users = fopen("epost.txt","r");
    $earray= array();
    /*--------------------mysql---------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = "call etk(?,?)";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss',$e,$kn);
    $line = fgets($users);
    /*--------------------mysql---------------------*/
    $stmp = 'null';
    $count = 0;
    while($line = fgets($users,4096))
    {
        list($e,$c,$kn,$kj) = explode("|",$line);
        $stmt->execute();
    }
    echo $count;
    fclose($users);
    $stmt->close();
    $db->close();
}
function keshiBindLeader()
{
    $users = fopen("epost.txt","r");
    $earray= array();
    /*--------------------mysql---------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = "call kbe(?,?)";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss',$kn,$e);
    $line = fgets($users);

    /*--------------------mysql---------------------*/
    $stmp = 'null';
    $count = 0;
    while($line = fgets($users,4096))
    {
        list($e,$c,$kn,$kj) = explode("|",$line);
        #$stmt->execute();
        if($kn == $stmp)#判断是否为科长第一次出现的必然是科长
        {
            continue;
        }
        else
        {
            $stmt->execute();
            echo $kn."_"."$e"."<br \>";
            $stmp = $kn;
            $count++;
        }
    }
    echo $count;
    fclose($users);
    $stmt->close();
    $db->close();
}
insertemp();
insertKeshi();
empBindKeshi();
keshiBindLeader();
?>
