<?php
App::uses('OgpAppModel', 'Ogp.Model');

class Ogp extends OgpAppModel {
	
	public $name = 'Ogp';
	
	public $connection = 'plugin';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = [
			'title' => [
				'maxLength' => [
					'rule' => ['maxLength', 255],
					'message' => '最大255文字'
				],
			],
			'description' => [
				'maxLength' => [
					'rule' => ['maxLength', 255],
					'message' => '最大255文字'
				],
			],
			'image' => [
				'url' => [
					'rule' => 'url',
					'allowEmpty' => true,
					'message' => 'httpから始まるURLを入力'
				],
			],
		];
	}
	
/*
	public $validate = [
		'title' => [
			'maxLength' => [
				'rule' => ['maxLength', 255],
				'message' => '最大255文字'
			],
		],
		'description' => [
			'maxLength' => [
				'rule' => ['maxLength', 255],
				'message' => '最大255文字'
			],
		],
		'image' => [
			'url' => [
				'rule' => 'url',
				'message' => 'httpから始まるURLを入力'
			],
		],
	];
*/
	
	
}
