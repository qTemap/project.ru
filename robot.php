<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Document</title>
</head>
<body>

	<div class="name">АНАЛИЗ ФАЙЛА robots.txt</div>
	<div class="search">	
		<form action="" method="post">
		Введите url: 
			<input type="text" name="dir" class="url" value="<?php echo $_POST['dir']; ?>">
			<input type="submit" name="ok" value="Провести тестрование">
		</form>
	</div>
	
	<div class="table">
		<?php if (isset($_POST['ok'])): ?>
		<table>

				<tr><td>№</td><td>Название проверки</td><td colspan="2">Статус</td><td>Текущее состояние</td></tr>

				<tr><td colspan="5"> <br></td></tr>		 	

		<?php

			//построение правильного url 
			$url = array();
	     	$url = parse_url($_POST['dir']);
	     	if ($url['scheme'] == "https" || $$url['scheme'] == "") {
	     		$url['scheme'] = "http";
	     	}
	     	$ret = sprintf("%s://%s", $url["scheme"], $url["host"]);

	     	//нахождение файла robots.txt
			$work_dir = $ret;
			$name = "$work_dir".'/robots.txt';
			$robots = file("$work_dir/robots.txt",FILE_IGNORE_NEW_LINES);
			$robots_text = array();

			//существует ли файл robots.txt
			if (!empty($robots)): ?>
				<tr>
			 		<td rowspan="2" width="15">1</td>	
			 		<td rowspan="2" width="350">Проверка наличия файла robots.txt</td>	
			 		<td rowspan="2" width="70" style="background-color:green;">Ок</td>		 		
			 		<td width="100">Состояние</td>
			 		<td width="400">Файл robots.txt присутствует</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>
			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
				<tr>
				 	<td rowspan="2">1</td>	
				 	<td rowspan="2">Проверка наличия файла robots.txt</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>Файл robots.txt отсутствует</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Создать файл robots.txt и разместить его на сайте.</td>
			 		</tr>
			 	</tr>
			<?php endif;


			//перебор всех данных в файле robots.txt
			foreach ($robots as $key=>$val) {

				//разбиение данных на элементы ключ : значение
				$str = explode(": ",$val);
				$robots_text[$key]= $str[0].": ".urldecode($str[1])."<br/>";

				//проверка на наличие Host и его количество
				if ($str[0] == "Host") {
					$host = $str[0];
					$host_val = urldecode($str[1]);    
					$count = count($host_val);         		             	
				}

				//проверка наличие sitemap
				if ($str[0] == "Sitemap") {
					$sitemap = $str[0];
				}
			}

			if (!empty($host)): ?>
				<tr><td colspan="5"> <br></td></tr>

			 	<tr>
				 	<td rowspan="2">6</td>	
				 	<td rowspan="2">Проверка указания директивы Host</td>	
			 		<td rowspan="2" style="background-color:green;">Ок</td>		 		
			 		<td>Состояние</td>
			 		<td>Директива Host указана</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>
			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
					<tr>
				 	<td rowspan="2">6</td>	
				 	<td rowspan="2">Проверка указания директивы Host</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>В файле robots.txt не указана директива Host</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.</td>
			 		</tr>
			 	</tr>

			<?php endif;


			if (!empty($host) && !empty($host_val) && $count == 1): ?>
				<tr><td colspan="5"> <br></td></tr>

			 	<tr>
				 	<td rowspan="2">8</td>	
				 	<td rowspan="2">Проверка количества директив Host, прописанных в файле</td>	
			 		<td rowspan="2" style="background-color:green;">Ок</td>		 		
			 		<td>Состояние</td>
			 		<td>В файле прописана 1 директива Host</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>
			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
				<tr>
				 	<td rowspan="2">8</td>	
				 	<td rowspan="2">Проверка количества директив Host, прописанных в файле</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>В файле прописано несколько директив Host</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта</td>
			 		</tr>
			 	</tr>
			<?php endif; 

			//вычисление веса файла robots.txt
			$fh = fopen("$name", "r");
			while(($str = fread($fh, 1024)) != null) $fsize += strlen($str);
			if($fsize <= 32768 && $fsize != 0): ?>
				<tr><td colspan="5"> <br></td></tr>

			 	<tr>
				 	<td rowspan="2">10</td>	
				 	<td rowspan="2">Проверка размера файла robots.txt</td>	
			 		<td rowspan="2" style="background-color:green;">Ок</td>		 		
			 		<td>Состояние</td>
			 		<td>Размер файла robots.txt составляет <?php echo $fsize ?>, что находится в пределах допустимой нормы</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>
			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
				<tr>
			 	<td rowspan="2">10</td>	
			 	<td rowspan="2">Проверка размера файла robots.txt</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>Размера файла robots.txt составляет <?php echo $fsize ?>, что превышает допустимую норму</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб</td>
			 		</tr>
			 	</tr>
			<?php endif;
			


			if (!empty($sitemap)): ?>
					<tr><td colspan="5"> <br></td></tr>

			 	<tr>
				 	<td rowspan="2">11</td>	
				 	<td rowspan="2">Проверка указания директивы Sitemap</td>	
			 		<td rowspan="2" style="background-color:green;">Ок</td>		 		
			 		<td>Состояние</td>
			 		<td>Директива Sitemap указана</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>
			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
					<tr>
				 	<td rowspan="2">11</td>	
				 	<td rowspan="2">Проверка указания директивы Sitemap</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>В файле robots.txt не указана директива Sitemap</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Добавить в файл robots.txt директиву Sitemap</td>
			 		</tr>
			 	</tr>
			<?php endif;

			//проверка и вывод ответа сервера для файла robots.txt
			$arr = array();
			$arr = get_headers($name);

			if(stristr($arr[0], '200') == true): ?>
				<tr><td colspan="5"> <br></td></tr>

			 	<tr>
				 	<td rowspan="2">12</td>	
				 	<td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>	
			 		<td rowspan="2" style="background-color:green;">Ок</td>		 		
			 		<td>Состояние</td>
			 		<td>Файл robots.txt отдаёт код ответа сервера 200</td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Доработки не требуются</td>
			 		</tr>
			 	</tr>

			<?php else: ?>
				<tr><td colspan="5"> <br></td></tr>
					<tr>
				 	<td rowspan="2">12</td>	
				 	<td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>	
			 		<td rowspan="2" style="background-color:red;">Ошибка</td>		 		
			 		<td>Состояние</td>
			 		<td>При обращении к файлу robots.txt сервер возвращает код ответа <?php echo $arr[0]; ?></td>
			 		<tr>
				 		<td>Рекомендации</td>
				 		<td>Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу sitemap.xml сервер возвращает код ответа 200</td>
			 		</tr>
			 	</tr>

			<?php endif;

			endif; ?>	 	

			 	
			 </table>
		 </div>

</body>
</html>