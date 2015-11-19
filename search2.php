<html>
<head>
<style type="text/css" >
@import "./table.css"
</style>
</head>

<?php
if(isset($_POST['phoneno']))
{
    /*--------------------------mysql------------------*/
    $db = new mysqli('localhost','root','123123','epost');
    $query = 'select * from epk where phone regexp ? or callno regexp ? ';
    #$query = 'select * from epk where zuoji=? ';
    echo $_POST['phoneno'];
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss',$_POST['phoneno'],$_POST['phoneno']);
    #$stmt->bind_param('s',$_POST['phoneno']);
    $stmt->execute();
    $stmt->store_result();
    /*--------------------------mysql------------------*/
    if($stmt->num_rows > 0)
    {
	$stmt->bind_result($ename,$cellphone,$keshi,$zuoji);
	echo '<table border="1">';
	echo '<tr> <td class="title">姓名</td><td class="title">手机</td><td class="title">科室</td><td class="title">座机号</td> </tr>';
	while($stmt->fetch())
	{
	    printf ('<tr> <td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',$ename,$cellphone,$keshi,$zuoji);
	}
	echo '</table>';
    }
    else
    {
	echo "没有记录";
    }

    $stmt->close();
    $db->close();
}
else{
    echo $_POST['phoneno'];
    echo "参数为空";
}
?>
</html>
