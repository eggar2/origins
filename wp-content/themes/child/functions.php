<?php

// function generate_doc(){

// 	require_once 'libs/PHPWord.php';

// 	$PHPWord = new PHPWord();

// 	$section = $PHPWord->createSection();

// 	$section->addImage( get_stylesheet_directory_uri() . '/images/_mars.jpg');
// 	$section->addTextBreak(2);

// 	$section->addImage(get_stylesheet_directory_uri() . '/images/_earth.JPG', array('width'=>210, 'height'=>210, 'align'=>'center'));
// 	$section->addTextBreak(2);

// 	$section->addImage(get_stylesheet_directory_uri() . '/images/_mars.jpg', array('width'=>100, 'height'=>100, 'align'=>'right'));

// 	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
// 	$objWriter->save('menus.docx');

// }

function generateText(){

	require_once 'libs/PHPWord.php';

	$assets = array(
		'self_discovery' => array(
			'name' => 'SELF DISCOVERY',
			'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
			'products' => array(
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),
				array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				),array(
					'name' => 'Strawberry Diesel',
					'desc' => 'Flavors are just like the name with Strawberry and diesel leaving you with a sweetness. This hybrid is sure to help you discover yourself with happy, relaxing and focused effects. Lineage: Strawberry Cough/NYC Diesel',
					'weight' => '3.5g',
					'price' => '$48',
					'canab_ratio' => '107:1',
					'farm' => 'Mj Productions'
				)
			)
		)		
	);

	$PHPWord = new PHPWord();
	$section = $PHPWord->createSection();

	// STYLES
	$PHPWord->addFontStyle('heading_title', array('align'=>'center', 'size'=>40, 'name'=>'MixSerif'));
	$PHPWord->addFontStyle('lifestyle_title', array('align'=>'center', 'size'=>30, 'name'=>'MixSerif'));
	$PHPWord->addFontStyle('product_title', array('align'=>'center', 'size'=>12, 'name'=>'MixSerif'));
	$PHPWord->addFontStyle('heading_desc', array('align'=>'center', 'size'=>12, 'name'=>'Gotham'));
	$PHPWord->addParagraphStyle('center', array('align'=>'center', 'spaceAfter'=>100));
	$divider_image_style = array('align'=>'center');

	// title
	$section->addText('LIFESTYLES', 'heading_title', 'center');
	$section->addImage('doc_divider.png', $divider_image_style);
	$section->addTextBreak(1);

	// description
	$section->addText("At Origins, our mission is to provide Seattle's most consultative approach, and to provide you with the most accurate method to select product.", 'heading_desc', 'center');

	$section->addPageBreak();

	// Start Loop
	foreach ($assets as $lifestyle) {

		// type title
		$section->addText('FLOWER', 'heading_title', 'center');
		$section->addImage('doc_divider.png', $divider_image_style);
		$section->addTextBreak(2);

		// lifestyle title
		$section->addText($lifestyle['name'], 'lifestyle_title', 'center');
		$section->addTextBreak(1);

		// description
		$section->addText($lifestyle['desc'], 'heading_desc', 'center');
		$section->addTextBreak(2);

		foreach ($lifestyle['products'] as $product) {
			$section->addText($product['canab_ratio'] .' '. $product['name'] .' — '. $product['farm'], 'product_title', 'center');
			$section->addText($product['desc'], 'heading_desc', 'center');
			$section->addText($product['weight'].'-'.$product['price'], 'heading_desc', 'center');
			$section->addTextBreak(1);
		}

	}


	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$filename = substr( time(), -5);
	$objWriter->save( $filename.'.docx');

}

