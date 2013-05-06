<?php

namespace PSU\OnlineForms\Template;

class Stages extends Collection {
	static $_name = 'Stages';
	static $child = 'PSU\\OnlineForms\\Template\\Stage';
	static $table = 'template_processor';
	static $join = array(
		array(
			'type' => 'JOIN',
			'table' => 'online_forms.processor_types',
			'want' => array(
				array(
					'field' => 'processor_types.name',
					'alias' => 'processor_type',
				),
			),
			'fields' => array(
				array(
					'logic' => 'AND',
					'field1' => 'processor_types.id',
					'field2' => 'template_processor.processor_type_id',
				),
			),
		),
	);

	protected function _get_order() {
		return 'id';
	}
}//end class
