<?php

if(isset($_POST['ename']))
{
    /*--------------------------mysql------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = 'select ename from employee';
    echo "chenahi";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    //$stmt->bind_param('ss',$_POST['ename'],$_POST['ename']);
    $stmt->execute();
    $stmt->store_result();
    /*--------------------------mysql------------------*/
    if($stmt->num_rows > 0)
    {
        $stmt->bind_result($ename);
        while($stmt->fetch())
        {
            printf ($ename);
        }
    }
    else
    {
        echo "请输入职工姓名或者科室名";
    }

    $stmt->close();
    $db->close();
}
?>
