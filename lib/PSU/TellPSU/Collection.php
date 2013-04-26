<?php

namespace PSU\TellPSU;

abstract class Collection extends \PSU\Collection {

	protected $_collection_key;

	static $parent_key;
	static $child_key = 'id';

	public function __construct( $id = null ) {
		$this->_collection_key = $id;
	}//end __construct

	/**
	 *
	 */
	public function count() {
		list($sql, $args) = $this->_get_sql();
		$sql = "SELECT COUNT(1) FROM ($sql) cnt";
		$count = \PSU::db('myplymouth')->GetOne($sql);
		return $count;
	}//end count

	/**
	 * @sa _get_sql()
	 */
	public function get( $keys = null ) {
		list($sql, $args) = $this->_get_sql( $keys );

		$rset = \PSU::db('myplymouth')->Execute( $sql, $args );

		return $rset;
	}//end get

	public function get_by_active( $item, $it = null ) {
		return $this->get_by_filter( '\PSU\TellPSU\FilterIterator\Active', $item, $it );
	}//end get_by_school

	public function get_by_answer( $item, $it = null ) {
		return $this->get_by_filter( '\PSU\TellPSU\FilterIterator\Answer', $item, $it );
	}//end get_by_school

	/**
	 * get an iterator by Validation
	 * 
	 * @param $class_name \b full class name for object used in iterator
	 * @param $item \b Object id, object, or slug
	 * @param $it \b iterator object
	 * @param $inverse \b FALSE = include $item associations.  TRUE = exclude $item associations
	 */
	public function get_by_filter( $class_name, $item, $it = null, $inverse = false ) {
		if( ! $it ) {
			$it = $this->getIterator();
		}//end if

		return new $class_name( $item, $it, $inverse );
	}//end get_by_validation

	public function get_by_targeting( $item, $it = null ) {
		return $this->get_by_filter( '\PSU\TellPSU\FilterIterator\Targeting', $item, $it );
	}//end get_by_school

	public function get_by_user( $item, $it = null ) {
		return $this->get_by_filter( '\PSU\TellPSU\FilterIterator\User', $item, $it );
	}//end get_by_school

	/**
	 * Return the SQL command to fetch our child rows.
	 */
	protected function _get_sql( $keys = null ) {
		$table = static::$table;
		$parent_key = static::$parent_key;
		$join = static::$join;

		//
		// set up WHERE clause
		//

		$where_sql = array('1=1');
		$args = array();

		if( null !== $this->_collection_key && ! isset( $keys ) ) {
			if( is_array( $this->_collection_key ) ) {
				$keys = $this->_collection_key;
			} else {
				$keys = array( $parent_key => $this->_collection_key );
			}
		}

		foreach( (array) $keys as $key => $value ) {
			$where = '';

			if( is_array($value) && count($value) == 1 ) {
				$value = array_pop($value);
			}

			if( is_array( $value ) ) {
				// array of values; use IN()
				$tmp = array();
				foreach( $value as $v ) {
					$tmp[] = \PSU::db('banner')->qstr( $v );
				}
				$value = implode(', ', $tmp);

				$where .= "{$table}.{$key} IN ({$value})";
			} else {
				// simple scalar value
				$value = \PSU::db('myplymouth')->qstr( $value );
				if( strpos( $key, '.' ) === false ) {
					$where .= "{$table}.{$key} = {$value}";
				} else {
					$where .= "{$key} = {$value}";
				}//end if
			}

			$where_sql[] = $where;
		}

		//
		// set up ORDER clause
		//

		$order_sql = $this->_get_order();

		if( $order_sql ) {
			$order_sql = "ORDER BY {$order_sql}";
		}

		//
		// do the query
		//

		$where_sql = implode( ' AND ', $where_sql );

		$join_wants = array();
		if( $join ) {
			$join_sql = "";
			foreach( $join as $join_data ) {
				foreach( $join_data['want'] as $field ) {
					$join_wants[] = $field['field'] . ' AS ' . $field['alias'];
				}//end foreach

				$join_sql .= " {$join_data['type']} {$join_data['table']} ON 1=1 " ;
				foreach( $join_data['fields'] as $fieldset ) {
					$join_sql .= "{$fieldset['logic']} {$fieldset['field1']} = {$fieldset['field2']} "; 
				}//end foreach
			}//end foreach
		}//end if

		if( $join_wants ) {
			$join_wants = ',' . implode( ', ', $join_wants );
		} else {
			unset( $join_wants );
		}//end else

		$sql = "
			SELECT {$table}.* {$join_wants}
			FROM myplymouth.{$table} {$join_sql}
			WHERE {$where_sql} {$order_sql}
		";

		$this->_get_sql_cache = array($sql, $args);

		return $this->_get_sql_cache;
	}//end _get_sql

	/**
	 * Column list for ordering the result set.
	 */
	protected function _get_order() {
		return null;
	}//end _get_order
}//end class
