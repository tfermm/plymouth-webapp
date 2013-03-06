<?php

namespace PSU\TellPSU;

class Questions extends Collection {
	static $_name = 'Questions';
	static $child = 'PSU\\TellPSU\\Question';
	static $table = 'tp_questions';
	static $join = array(
		array(
			'type' => 'JOIN',
			'table' => 'myplymouth.tp_targets_v',
			'want' => array(
				array(
					'field' => 'tp_targets_v.role',
					'alias' => 'role',
				),
			),
			'fields' => array(
				array(
					'logic' => 'AND',
					'field1' => 'tp_targets_v.id',
					'field2' => 'tp_questions.target_role_id',
				),
			),
		),
	);

	protected function _get_order() {
		return 'date_created';
	}
}//end class
