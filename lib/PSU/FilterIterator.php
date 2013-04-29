<?php

abstract class PSU_FilterIterator extends FilterIterator implements Countable {

	/**
	 *
	 */
	public function apply_sort( $sort_by, $sort_params = null ) {
		$object_array = iterator_to_array( $this );
		usort( $object_array, function( $a, $b ) use ( $sort_by, $sort_params ) {
			$base_a = method_exists( $a, $sort_by ) ? $a->$sort_by( $sort_params ) : $a->$sort_by;
			$base_b = method_exists( $b, $sort_by ) ? $b->$sort_by( $sort_params ) : $b->$sort_by;
			$sort_type = gettype( $base_a );

			switch( $sort_type ) {
				case ( $sort_type == 'object' || $sort_type == 'array' || $sort_type == 'boolean' ):
					$base_a = $base_a ? TRUE : FALSE;
					$base_b = $base_b ? TRUE : FALSE;

					if( $base_a == $base_b ) {
						return 0;
					}//end if
					return $base_a == TRUE ? 1 : -1;

				case ( $sort_type == 'integer' || $sort_type == 'double' ):
					if( $base_a == $base_b ) {
						return 0;
					}//end if
					return $base_a < $base_b ? -1 : 1;

				case 'string':
					return strcmp( $base_a, $base_b );
			}//end switch

		});

		return new ArrayIterator($object_array);
	}//end function

	public function count() {
		$elements = iterator_to_array( $this );
		return count( $elements );
	}

	public function not_empty() {
		$this->rewind();
		$result = (bool)$this->current();

		return $result;
	}

	public function is_empty() {
		return ! $this->not_empty();
	}
}
