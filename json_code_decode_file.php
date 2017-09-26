<pre style="font-size: 10px;">
	<?php
		$arr = [
			'Simple link',

			'Dropdown' => ['Toyota' => ['href' => '//www.toyota.com'],
				'Nissan' => ['href' => '//www.nissan.com'],
				'Wolksvagen' => ['href' => '//www.wolksvagen.com'],
				'Honda' => ['href' => '//www.honda.com'],
				'Audi' => ['href' => '//www.audi.com']
			],

			'Multi dropdown' => [
				'Nissan Leaf' => [
					'href' => '//www.nissan.com'
				],
				'Toyota Camry' => [
					'href' => '//www.toyota.com',
					'submenu' => [
						['model' => 'XV50',
							'href' => '//www.toyota.com/XV50'
						],
						['model' => 'XV40',
							'href' => '//www.toyota.com/XV40'
						],
						['model' => 'XV30',
							'href' => '//www.toyota.com/XV30'
						]
					]
				],
				'Honda' => [
					'href' => '//www.toyota.com',
					'submenu' => [
						['model' => 'CRV',
							'href' => '//www.honda.com/CRV'
						],
						['model' => 'Civic',
							'href' => '//www.honda.com/Civic'
						],
						['model' => 'Accord',
							'href' => '//www.honda.com/Accord'
						]
					]
				]

			]
		];

		print_r($arr);

		// кодируем JSON в строку $json_string и выводим на экран
		$json_string = (json_encode($arr));
		echo $json_string."<br><br>";

		// декодируем JSON из строки $json_string в ассоциативный массив (т.к. TRUE) и выводим на экран
		//print_r(json_decode($json_string, true));
		$arr_json = (json_decode($json_string, true));
		print_r($arr_json);


		/*
		 -------------------------------------------------------------
		 правильность написания JSON структуры
		 https://habrahabr.ru/post/158927/
		 https://www.youtube.com/watch?v=-s1uaxKpOPQ
		 -------------------------------------------------------------
		 валидатор JSON формата
		 https://jsonlint.com/
		 -------------------------------------------------------------

		*/







	?>

</pre>
