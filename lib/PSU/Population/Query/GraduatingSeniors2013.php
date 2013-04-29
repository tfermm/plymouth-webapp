<?php

class PSU_Population_Query_GraduatingSeniors2013 extends PSU_Population_Query {

	/**
	 * Return a set of matched users for the PSU_Population object.
	 */
	public function query( $args = array() ) {

		$defaults = array(
			'identifier' => 'wp_id',
		);

		$args = PSU::params( $args, $defaults );

		$sql = "
			SELECT DISTINCT i.".$args['identifier']."
				FROM PSU.graduating_seniors_2013 g
				JOIN PSU_IDENTITY.person_identifiers i
					ON g.pidm = i.pid
		";

		unset( $args['identifier'] );

		return PSU::db('banner')->GetCol( $sql, $args );
	}
}
