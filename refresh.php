<?php
	require_once 'data_to_connect.php';

	$cout1=0;
	$cout2=0;
	$avgRoz=0;
	$avgOpt=0;
	$cont=0;

	$sel1 = $_POST['fsel1'];
	$ott = $_POST['fott'];
	$doo = $_POST['fdoo'];
	$sel2 = $_POST['fsel2'];
	$cout = $_POST['fcout'];

	//-1 OR 1=1 injection
	//alternative PDO
	//$id = (int) $_GET['id'];
	if ((!is_numeric($_POST['fott']))||(!is_numeric($_POST['fdoo']))||(!is_numeric($_POST['fcout']))) {
		echo "</br>Проверьте корректность заполнения полей!"; exit;
	}else if($ott<0||$doo<0||$cout<0){
		echo "</br>Числа должны быть больше нуля!";
			exit;
	}else if($ott > $doo){
		echo "</br>Значение розничной цены больше оптовой!";
		exit;
	}

	//max
	$sql = "select max(Cost_rub) from pList";
	$result = $conn->query($sql);
	$maxCost = mysqli_fetch_row($result)[0];

	$sql = "select min(Wholesale_cost_rub) from pList";
	$result = $conn->query($sql);
	$minCost = mysqli_fetch_row($result)[0];

	if($sel1 == 1){
		if($sel2==1){
			$sql = "SELECT * FROM pList WHERE (Cost_rub BETWEEN $ott AND $doo) and (Stock_quantity_1_pcs>$cout OR Stock_quantity_2_pcs>$cout)";
		}else{
			$sql = "SELECT * FROM pList WHERE (Cost_rub BETWEEN $ott AND $doo) and (Stock_quantity_1_pcs<$cout OR Stock_quantity_2_pcs<$cout)";
		}	} else {
			if($sel2==1){
				$sql = "SELECT * FROM pList WHERE (Wholesale_cost_rub BETWEEN $ott AND $doo) and (Stock_quantity_1_pcs>$cout OR Stock_quantity_2_pcs>$cout)";
			}else{
				$sql = "SELECT * FROM pList WHERE (Wholesale_cost_rub BETWEEN $ott AND $doo) and (Stock_quantity_1_pcs<$cout OR Stock_quantity_2_pcs<$cout)";
			}
	}


	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

	    echo "<table border='1'><tr><th>id</th><th>Наименование товара</th><th>Стоимость, руб.</th><th>Стоимость опт, руб.</th><th>Наличие на складе 1, шт.</th><th>Наличие на складе 2, шт.</th><th>Страна производства</th><th>Примечание</th></tr>";

	while($row = $result->fetch_assoc()) {
	$i=0; $k=false;

            foreach($row as $key => $column) {

		if($key == 'Cost_rub' && $column == $maxCost){
			echo("<td style='background:red;'>".$row["Cost_rub"]."</td>");
		}else if($key == 'Wholesale_cost_rub' && $column == $minCost){
			echo("<td style='background:green;'>".$row["Wholesale_cost_rub"]."</td>");

		}else if(($key == 'Stock_quantity_1_pcs'||$key == 'Stock_quantity_2_pcs') && $column < 20){
			echo "<td>$column</td>";
			$k=true;
			}else{
			echo("<td>$column</td>");
			}
		}
	if($i%7==0){
		if($k){
			echo "<td style='color:blue;'>Осталось мало!! Срочно докупите!!!</td>";
		}else{echo "<td></td>";}
	}
	$i++;

	$cout1+=$row["Stock_quantity_1_pcs"];
	$cout2+=$row["Stock_quantity_2_pcs"];
	$cont+=1;
	$avgRoz+=$row["Cost_rub"];
	$avgOpt+=$row["Wholesale_cost_rub"];


		echo("</tr>");
	    }
	    echo "</table>";
	} else {
	    echo "Не один товар не соответствует критериям отбора!</br>";
	}
	echo "Общее количество товаров на складе 1: " . $cout1; echo "</br>";
	echo "Общее количество товаров на складе 2: " .$cout2;	echo "</br>";

	if($cont!=NULL){
		echo "Средняя стоимость розничной цены товара: " . round(($avgRoz/$cont),2) . " при максимальное в бд ";
	}

	//avg
	$sql="select AVG(Cost_rub) from pList";
	$res = $conn->query($sql);
 	if($conn->query($sql)){
		while($row=$res->fetch_assoc()){

		print_r($row);
		//var_dump($row);
	}
	}else {
	    echo "Среднее по столбцу Cost_rub не найдено! " . $conn->error;
	}
	echo "</br>";
if($cont!=NULL){
	echo "Средняя стоимость оптовой цены товара: " . round(($avgOpt/$cont),2);  echo "</br>";
}
	/*or
	q1
	$sql = "SELECT SUM(Wholesale_cost_rub) FROM pList";
	q2
	$sql = "select count(*) from pList";
	echo $result=q1\q2;
	*/
		echo "<a href='http://localhost/brainforce/index.html'>Вернуться на главную страницу</a>";
	$conn->close();

?>
