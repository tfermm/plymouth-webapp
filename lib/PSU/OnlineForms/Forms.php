<?php

namespace PSU\OnlineForms;

class Forms extends Collection {
	static $_name = 'Forms';
	static $child = 'PSU\\OnlineForms\\Form';
	static $table = 'forms';
	static $join = array(
		array(
			'type' => 'JOIN',
			'table' => 'online_forms.form_template',
			'want' => array(
				array(
					'field' => 'form_template.template_id',
					'alias' => 'template_id',
				),
			),
			'fields' => array(
				array(
					'logic' => 'AND',
					'field1' => 'form_template.form_id',
					'field2' => 'forms.id',
				),
			),
		),
	);

	protected function _get_order() {
		return 'date_created';
	}
}//end class
