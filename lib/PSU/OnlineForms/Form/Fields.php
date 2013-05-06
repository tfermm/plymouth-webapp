<?php

namespace PSU\OnlineForms\Form;

class Fields extends Collection {
	static $_name = 'Fields';
	static $child = 'PSU\\OnlineForms\\Form\\Field';
	static $table = 'forms_meta';
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
		return 'activity_date';
	}
}//end class
