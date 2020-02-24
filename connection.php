<?php

require_once 'data_to_connect.php';

$loadfile = $_POST['upload_file']; // получаем имя загруженного файла
if(empty($loadfile)){
	 echo "Выберите пожалуйста, файл!";
	 exit;
}else if($loadfile != "pricelist.xls"){
	echo "Файл не соотстветствует входным данным! :)";
	exit;
}

	//mysqli_set_charset($link, 'utf8');

	$sql = "SELECT * FROM pList LIMIT 1";
	if($conn->query($sql)){
		$sql = "drop table pList";
		$conn->query($sql);
		echo "Существующая таблица с таким же именем (pList) успешно удалена!";
		echo "</br>";
	}

	// sql to create table
	$sql = "CREATE TABLE pList (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Name_of_product VARCHAR(300) NOT NULL,
	Cost_rub INT,
	Wholesale_cost_rub INT,
	Stock_quantity_1_pcs INT,
	Stock_quantity_2_pcs INT,
	Country_of_Origin VARCHAR(100) NOT NULL
	)";

	if ($conn->query($sql) === TRUE) {
	    echo "Новая таблица pList создана!";
		echo "</br>";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	require_once "PHPExcel/Classes/PHPExcel/IOFactory.php"; // подключаем класс для доступа к файлу

	$objPHPExcel = PHPExcel_IOFactory::load($loadfile);



	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
	{
	  $highestRow = $worksheet->getHighestRow(); // получаем количество строк
	  $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок

	  for ($row = 1; $row <= $highestRow; ++ $row) // обходим все строки
	  {
	    $cell1 = $worksheet->getCellByColumnAndRow(0, $row); //наименование товара
	    $cell2 = $worksheet->getCellByColumnAndRow(1, $row); //стоимость, руб
	    $cell3 = $worksheet->getCellByColumnAndRow(2, $row); //стоимость опт, руб
	    $cell4 = $worksheet->getCellByColumnAndRow(3, $row); //наличие на складе 1, шт.
	    $cell5 = $worksheet->getCellByColumnAndRow(4, $row); //наличие на складе 2, шт.
	    $cell6 = $worksheet->getCellByColumnAndRow(5, $row); //страна производства


	$sql = "INSERT INTO pList (`Name_of_product`,`Cost_rub`,`Wholesale_cost_rub`,`Stock_quantity_1_pcs`,`Stock_quantity_2_pcs`,`Country_of_Origin`) VALUES
	('$cell1','$cell2','$cell3','$cell4','$cell5','$cell6')";


	if ($conn->query($sql) === FALSE) {
	    echo "Ошика добавления данных. Товар: " . $cell1 ." ". $conn->error;
		echo "</br>";

	}

	  }
	}
	echo "<a href='http://localhost/brainforce/index.html'>Вернуться на главную страницу</a>";

$conn->close();

?>
