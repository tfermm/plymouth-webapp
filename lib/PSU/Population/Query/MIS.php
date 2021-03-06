<?php

class PSU_Population_Query_MIS extends PSU_Population_Query {

	/**
	 * Return a set of matched users for the PSU_Population object.
	 */
	public function query( $args = array() ) {

		$defaults = array(
			'identifier' => 'wp_id',
		);

		$args = PSU::params( $args, $defaults );

		$sql = "
			SELECT DISTINCT ".$args['identifier']."
			  FROM v_idm_attributes
			 WHERE attribute = 'mis'
		";

		unset( $args['identifier'] );

		return PSU::db('banner')->GetCol( $sql, $args );
	}
}
