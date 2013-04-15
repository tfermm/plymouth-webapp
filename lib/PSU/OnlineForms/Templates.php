<?php

namespace PSU\OnlineForms;

class Templates extends Collection {
	static $_name = 'Templates';
	static $child = 'PSU\\OnlineForms\\Template';
	static $table = 'templates';
	/**
	static $join = array(
		array(
			'type' => 'JOIN',
			'table' => 'online_forms.',
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
	 */

	protected function _get_order() {
		return 'id';
	}
}//end class
