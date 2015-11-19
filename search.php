<html>
<head>
    
<style type="text/css" >
@import "./table.css"
</style>
<title>:> 查询结果 </title>
</head>

<body>

<div>

   <a href="./index.php">
   重新查询
   </a>
<?php
if(isset($_POST['ename']))
{
    /*--------------------------mysql------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = 'select * from epk where ename regexp ? or kname regexp ?';
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss',$_POST['ename'],$_POST['ename']);
    $stmt->execute();
    $stmt->store_result();
    /*--------------------------mysql------------------*/
    if($stmt->num_rows > 0)
    {
        $stmt->bind_result($ename,$cellphone,$keshi,$zuoji);
        echo '<table>';
        echo '<tr> <td class="title">姓名</td><td class="title">手机</td><td class="title">科室</td><td class="title">座机号</td> </tr>';
        while($stmt->fetch())
        {
            printf ('<tr> <td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',$ename,$cellphone,$keshi,$zuoji);
        }
        echo '</table>';
    }
    else
    {
        echo "请输入职工姓名或者科室名";
    }

    $stmt->close();
    $db->close();
}
?>
</body>

</div>
</html>
