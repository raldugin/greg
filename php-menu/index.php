<!DOCTYPE html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<title>Menu</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab|Roboto:400,700&amp;subset=cyrillic">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/menu.css">
</head>

<body>
	<?php 

	$menu = [
			'Simple link',
			
			'Dropdown' => [ 'Toyota' =>	[ 'href' => '//www.toyota.com' ],
							'Nissan' => [ 'href' => '//www.nissan.com' ],
							'Wolksvagen' => [ 'href' => '//www.wolksvagen.com' ], 
							'Honda' => 	[ 'href' => '//www.honda.com'],
							'Audi' => 	[ 'href' => '//www.audi.com' ]
			],
			
			'Multi dropdown' =>	[ 
							'Nissan Leaf' => [
											'href' => '//www.nissan.com'
										],
							'Toyota Camry' => [
											'href' => '//www.toyota.com',
											'submenu' => [
															[ 'model' => 'XV50',
															  'href' => '//www.toyota.com/XV50'
															],
															[ 'model' => 'XV40',
															  'href' => '//www.toyota.com/XV40'
															],
															[ 'model' => 'XV30',
															  'href' => '//www.toyota.com/XV30'
															]
														]
											],
							'Honda' => [
											'href' => '//www.toyota.com',
											'submenu' => [
															[ 'model' => 'CRV',
															  'href' => '//www.honda.com/CRV'
															],
															[ 'model' => 'Civic',
															  'href' => '//www.honda.com/Civic'
															],
															[ 'model' => 'Accord',
															  'href' => '//www.honda.com/Accord'
															]
														]
										]
							
			]
	];

	function generate_submenu ($array) {
		foreach ($array	as $key => $value) {
			echo "<li><a href=\"{$value['href']}\">{$value['model']}</a></li>";
		}
	};

	function dump_array ($arr) {
		echo "<pre><hr>";
		print_r($arr);
		echo "</pre><hr>";
	};

	?>

<header>
	<nav>
		<ul class="menu">
			
				<?php foreach ($menu as $key => $root_menu) : ?>

						<?php if (is_array($root_menu)) : ?>  <!-- если многомерный массив то читаем его элементы и формируем dropdown меню первого уровня -->
							<li class="has_submenu_slidedown"><a href=""><?= $key; ?></a>
								<ul class="submenu_slidedown">
									<?php asort($root_menu) ?> <!-- сортируем элементы -->
									
									<?php foreach ($root_menu as $key => $root_menu_item): ?> 
										<?php if (isset($root_menu_item['submenu'])): ?> <!-- если в элементах массива есть элементы подменю то читаем их формируем submenu второго уровня -->
											<?php asort($root_menu_item['submenu']) ?>
											<li class="has_submenu_dropdown"><a href=""><?= $key; ?></a>
												<ul class="submenu_dropdown">
													<?= generate_submenu($root_menu_item['submenu']) 
												</ul>
											</li>

										<?php else: ?>
										<li><a href="<?= $root_menu_item['href'] ?>"><?= $key ?></a></li>

										<?php endif ?>
									<?php endforeach ?>

								</ul>
							</li>

						<?php else: ?>
							<li><a href=""><?= $root_menu ?></a></li>
						<?php endif ?>
				<?php endforeach ?>
		</ul>
	</nav>
</header>
</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script>
	$(document).ready(function(){
		$('.has_submenu_slidedown >a').append("<span> +</span>");
		$('.has_submenu_dropdown >a').append("<span> +</span>");
		
		$('.menu').find('.has_submenu_slidedown').on('mouseenter mouseleave', function(){
			$(this).find('.submenu_slidedown:first').stop(true, true).slideToggle(350, "easeOutExpo");
		});
		$('.menu').find('.has_submenu_dropdown').on('mouseenter mouseleave', function(){
			$(this).find('.submenu_dropdown:first').stop(true, true).fadeToggle(350, "easeOutExpo");
		});
	});
</script>
</html>