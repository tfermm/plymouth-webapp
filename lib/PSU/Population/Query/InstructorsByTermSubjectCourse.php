<?php

/**
 * Return a set of matched users for the PSU_Population object.
 */
class PSU_Population_Query_InstructorsByTermSubjectCourse extends PSU_Population_Query {

	/**
	 * Finds all instructors by term, subject, course
	 * @param  array  $args must pass in 'term_code', 'subject_code', 'course_number'
	 * @return array  return list of Instructors teaching given term/subject/course
	 */
	public function query( $args = array() ) {

		$defaults = array(
			'term_code' => NULL,
			'subject_code' => NULL,
			'course_number' => NULL,
		);

		$args = PSU::params( $args, $defaults );

		// If we do not have the necessary query information then return empty array
		if(!$args['term_code'] || !$args['subject_code'] || !$args['course_number']) {
			return array();
		}

		$sql = "
			SELECT spriden_id
			FROM spriden
			JOIN sirasgn ON spriden_pidm = sirasgn_pidm
			JOIN ssbsect ON ssbsect_crn = sirasgn_crn
			WHERE spriden_change_ind IS NULL
			AND ssbsect_term_code = :term_code
			AND ssbsect_subj_code = :subject_code
			AND ssbsect_crse_numb = :course_number
			GROUP BY spriden_id
		";

		return PSU::db('banner')->GetCol( $sql, $args );
	}
}
