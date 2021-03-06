<?php

namespace OSC\ProductsType;

use
	Aedea\Core\Database\StdObject as DbObj
	;

class Object extends DbObj {

	protected
		$name
		, $description
	;

	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'name',
				'description'
			)
		);

		return parent::toArray($args);
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				name,
				description
			FROM
				products_type
			WHERE
				id = '" . (int)$this->getId() . "'	
		");

		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Product Type not found",
				404
			);
		}
		$this->setProperties($this->dbFetchArray($q));
	}

	public function update($id){
		if( !$id ) {
			throw new Exception("save method requires id to be set");
		}
		$this->dbQuery("
			UPDATE
				products_type
			SET
				name = '" . $this->getName() . "',
				description = '" . $this->getDescription() . "'
			WHERE
				id = '" . (int)$id . "'
		");

	}

	public function delete($id){
		if( !$id ) {
			throw new Exception("delete method requires id to be set");
		}
		$this->dbQuery("
			DELETE FROM
				products_type
			WHERE
				id = '" . (int)$id . "'
		");
	}

	public function insert(){
		$this->dbQuery("
			INSERT INTO
				products_type
			(
				name,
				description,
				create_date
			)
				VALUES
			(
				'" . $this->getName() . "',
				'" . $this->getDescription() . "',
 				NOW()
			)
		");
		$this->setId( $this->dbInsertId() );
	}


	public function setDescription( $string ){
		$this->description = $string;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setName( $string ){
		$this->name = $string;
	}

	public function getName(){
		return $this->name;
	}

}
