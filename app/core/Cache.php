<?php

namespace HostList;

class Cache {

	protected static $_instance;

	private $cache	= [];

	private $groups	= [];

	private $hits	= 0;
	private $misses	= 0;

	public function __construct() {
		self::$_instance = $this;
	}

	public function add( $key, $value, $group='default' ) {

		// Can't add if another key already exists in the group. Use set() instead.
		if ( $this->exists($key, $group) )
			return false;

		return $this->set($key, $value, $group);
	}

	public function set( $key, $value, $group='default' ) {

		// Clone if object
		if ( is_object($value) )
			$value = clone $value;

		$this->cache[$group][$key] = $value;

		return true;

	}

	public function get( $key, $group='default' ) {

		if ( !$this->exists($key, $group) ) {
			$this->misses += 1;
			return false;
		}

		$this->hits += 1;

		$result = $this->cache[$group][$key];

		if ( is_object($result) )
			return clone $result;
		else
			return $result;

	}

	public function exists( $key, $group='default' ) {
		return isset( $this->cache[$group] ) && isset( $this->cache[$group][$key] );
	}

	public function stats() {
		return ['hits' => $this->hits, 'misses' => $this->misses, 'cache' => $this->cache];
	}

	public static function getInstance() {
        return self::$_instance;
    }

}

function cache_add( $key, $value, $group='default' ) {
	$cache = Cache::getInstance();
	return $cache->add($key, $value, $group);
}

function cache_set( $key, $value, $group='default' ) {
	$cache = Cache::getInstance();
	return $cache->set($key, $value, $group);
}

function cache_get( $key, $group='default' ) {
	$cache = Cache::getInstance();
	return $cache->get($key, $group);
}

function cache_stats() {
	$cache = Cache::getInstance();
	return $cache->stats();
}
