<?php

namespace PSU\OnlineForms;

/**
 * 
 */
abstract class ActiveRecord extends \PSU_Banner_DataObject implements \PSU\ActiveRecord {
	/**
	 * The table holding data for this object.
	 */
	static $table = null;

	/**
	 * A container for related objects (i.e. parents, children)
	 * @sa _get_related()
	 */
	protected $_related_objs = array();

	/**
	 * An array for keeping track of elements that have fallen over to a parent object
	 */
	public $failover = array();

	/**
	 * Optional, static RowCache. (Set at runtime.)
	 */
	static $rowcache = null;

	/**
	 *
	 */
	public function __construct( $row = null ) {
		// is row actually a row identifier (unique key)?
		if( $row && ! is_array( $row ) ) {
			$row = static::row( $row );
		}

		parent::__construct( $row );
	}//end __construct

	/**
	 * returns the activity date's timestamp
	 */
	public function activity_date_timestamp() {
		return $this->date_timestamp( 'activity_date' );
	}//end activity_date_timestamp

	/**
	 * returns the a date var's timestamp
	 */
	public function date_timestamp( $var ) {
		if( isset( $this->$var ) ) {
			if( is_numeric( $this->$var ) ) {
				return $this->$var;
			}

			return strtotime( $this->$var );
		}//end if

		return null;
	}//end date_timestamp

	/**
	 *
	 */
	public function delete( $delete_id = null ) {
		return false;
	}//end function

	/**
	 *
	 */
	public function fields() {

		if( ! static::$table ) {
			throw new \Exception( 'static::$table must be defined' );
		}

		$table = static::$table;

		$sql = "
			SHOW COLUMNS FROM {$table}
		";

		$cols = \PSU::db('online_forms')->GetAll( $sql, $args );
		$result = array();
		foreach( $cols as $col ) {
			if( !strstr( $col['Field'], 'date' ) && $col['Field'] !== 'id' ) {
				$result[] = $col['Field'];
			}//end if
		}//end foreach

		return $result;
	}//end function

	/**
	 *
	 */
	public static function get( $key ) {
		
		if( ! is_scalar( $key ) ) {
			throw new \InvalidArgumentException( 'key must be scalar' );
		}

		$class = get_called_class(); // get_called_class() is full class name, including namespaces
		$field = self::_get_field( $key );
		$idx = "{$class}-{$field->field}-{$field->value}";
		$args = null;

		if( null !== self::$rowcache ) {
			$args = self::$rowcache->get( $class, $field->field, $field->value );
		}

		if( null === $args ) {
			$args = $key;
		}

		$obj = new static( $args );

		if( $obj->id ) {
			$cache["{$class}-id-{$obj->id}"] = $obj;
		}
		return $cache[$idx];
	}//end function

	/**
	 * @param string $key Identifier for this related object type.
	 * @param string $callback Class name or callback used to instantiate this object
	 * @param mixed $id Record identifer, or array of key/value identifier pairs
	 */
	protected function _get_related( $key, $callback, $id ) {
		$id_str = is_array($id) ? serialize($id) : $id;

		if( ! isset( $this->_related_objs[$key] ) ) {
			$this->_related_objs[$key] = array();
		}

		if( ! isset( $this->_related_objs[$key][$id_str] ) ) {
			if( is_callable( $callback ) ) {
				$obj = call_user_func( $callback, $id );
			} else {
				$obj = new $callback( $id );
			}

			$this->_related_objs[$key][$id_str] = $obj;
		}

		return $this->_related_objs[$key][$id_str];
	}

	/**
	 *
	 */
	public function save( $method = 'replace' ) {

		if( ! static::$table ) {
			throw new \Exception( 'static::$table must be defined' );
		}//end if

		$table = static::$table;
		$fields = implode( ', ', $this->fields() );
		$values = array();
		foreach( $this->_prep_args() as $val ) {
			if( $val !== NULL) {
				$values[] = \PSU::db('online_forms')->qstr( $val );
			}//end if
		}//end foreach
		$values = trim( implode( ', ', $values ), ' ,' );
		$sql = "
			REPLACE INTO {$table} ({$fields}) VALUES ({$values})
		";

		return \PSU::db('online_forms')->Execute( $sql, $args );
	}//end function

	/**
	 * Return a record array from the data store, identified
	 * by the given key
	 *
	 * @param mixed $key Id or slug
	 * @return array
	 */
	public static function row( $key ) {
		$field = self::_get_field( $key );

		$where = "{$field->field} = ?";
		$args  = array( $field->value );

		if( ! static::$table ) {
			throw new \Exception( 'static::$table must be defined' );
		}

		$table = static::$table;

		$sql = "
			SELECT *
			FROM {$table}
			WHERE $where
		";

		$row = \PSU::db('online_forms')->GetRow( $sql, $args );

		if( 0 === count($row) ) {
			throw new \PSU\ActiveRecord\NotFoundException( "{$table}.{$field->field} = {$key}" );
		}

		return $row;
	}//end row

	/**
	 * Helper to determine whether we are querying based on a numeric
	 * row ID or a slug.
	 * 
	 * @param string|int $ident The identifier.
	 * @return object An object with two properties: field (id, or slug) and value (the sanitized value).
	 */
	public static function _get_field( $ident ) {
		if( is_numeric($ident) ) {
			$field = 'id';
			$value = (int)$ident;
		} else {
			$field = 'slug';
			$value = $ident;
		}

		return (object)array( 'field' => $field, 'value' => $value );
	}//end _get_field
}//end class
