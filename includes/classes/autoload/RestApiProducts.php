<?php

use
	OSC\Products\Collection
		as ProductCol
	, OSC\Products\Object
		as ProductObj
;

class RestApiProducts extends RestApi {

	public function get($params){
		$col = new ProductCol();
		// start limit page
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$id = $params['GET']['id'];
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);
		$col->sortByDate('DESC');
		$col->filterById($id);
		$col->filterByName($params['GET']['name']);
		$params['GET']['status'] ? $col->filterByStatus(1) : '';
		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);

	}

	public function post($params){
		$productObject = new ProductObj();
		$productObject->setProperties($params['POST']);
		$productObject->insert();
		return array(
			'data' => array(
				'id' => $productObject->getId()
			)
		);
	}

	public function put($params){
		$obj = new ProductObj();
		$obj->setProperties($params['PUT']);
		$obj->update($this->getId());
	}

	public function delete(){
		$obj = new ProductObj();
		$obj->delete($this->getId());
		return array(
			'data' => array(
				'data' => 'success'
			)
		);
	}

	public function patch($params){
		$obj = new ProductObj();
		$obj->setStatus($params['PATCH']['status']);
		$obj->updateStatus($this->getId());
	}

}

