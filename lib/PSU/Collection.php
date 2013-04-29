<?php

namespace PSU;

/**
 * A base class for holding a set of similar objects.
 */
abstract class Collection implements \ArrayAccess, \IteratorAggregate, \Countable {
	/**
	 * Class name of the collection child objects, used
	 * for instantiation. Redefine when extending Collection.
	 */
	static $child = 'stdClass';

	/**
	 * If set, children will be stored in $this->children using
	 * this property of the resulting child object.
	 */
	static $child_key = null;

	/**
	 * Name of iterator objects returned by this collection.
	 */
	static $iterator = '\ArrayIterator';

	/**
	 * Cached iterator.
	 */
	protected $it = null;

	protected $children = null;

	abstract public function get();

	/**
	 *
	 */
	public function add_children( $rows ) {
		$this->children = array();

		foreach( $rows as $row ) {
			$obj = new static::$child( $row );

			if( static::$child_key ) {
				$key = $obj->{static::$child_key};
				$this->children[$key] = $obj;
			} else {
				$this->children[] = $obj;
			}
		}
	}

	/**
	 *
	 */
	public function add_children_array( $objects ) {
		$this->children = array();

		foreach( $objects as $obj ) {
			$this->children[] = $obj;
		}//end foreach
	}//end function

	/**
	 *
	 */
	public function add_children_bare( $children ) {
		$this->children = $children;
	}

	/**
	 *
	 */
	public function apply_sort( $sort_by, $sort_params = null ) {
		$object_array = iterator_to_array( $this->getIterator() );
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

		return $object_array;
	}//end function

	/**
	 *
	 */
	public function count() {
		$this->load();
		return count( $this->children );
	}

	/**
	 *
	 */
	public function getIterator() {
		$this->load();

		if( ! $this->it ) {
			$this->it = new static::$iterator( $this->children );
		} else {
			$this->it->rewind();
		}

		return $this->it;
	}

	/**
	 *
	 */
	public function load() {
		if( null !== $this->children ) {
			return;
		}

		$rows = $this->get();

		$this->add_children( $rows );
	}

	/**
	 * ArrayAccess magic
	 */
	public function offsetExists( $offset ) {
		$this->load();

		return isset( $this->children[ $offset ] );
	}//end offsetExists

	/**
	 * ArrayAccess magic
	 */
	public function offsetGet( $offset ) {
		$this->load();

		return isset( $this->children[ $offset ] ) ? $this->children[ $offset ] : null;
	}//end offsetGet

	/**
	 * ArrayAccess magic
	 */
	public function offsetSet( $offset, $value ) {
		$this->load();

		if( is_null( $offset ) ) {
			$this->children[] = $value;
		} else {
			$this->children[ $offset ] = $value;
		}//end else
	}//end offsetSet

	/**
	 * ArrayAccess magic
	 */
	public function offsetUnset( $offset ) {
		$this->load();

		unset( $this->children[ $offset ] );
	}//end offsetUnset
}//end abstract class Collection
