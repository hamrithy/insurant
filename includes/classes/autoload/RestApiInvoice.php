<?php

use
	OSC\Invoice\Collection as InvoiceCol
	, OSC\Invoice\Object as InvoiceObj
	, OSC\InvoiceDetail\Object as InvoiceDetailObj
;

class RestApiInvoice extends RestApi {

	public function get($params){
		$col = new InvoiceCol();
		// start limit page
		$col->sortById('DESC');
//		$col->filterByName($params['GET']['name']);
//		$col->filterById($params['GET']['id']);
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);
		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);
	}

	public function post($params){
		$obj = new InvoiceObj();
		$obj->setCreateBy($_SESSION['user_name']);
		$obj->setProperties($params['POST']['invoice']);
		$obj->insert();
		$invoiceId = $obj->getId();
		// start insert data into detail
		foreach( $params['POST']['invoice_detail'] as $key => $value){
			$objDetail = new InvoiceDetailObj();
			$objDetail->setInvoiceDetailId($invoiceId);
			$objDetail->setProperties($value);
			$objDetail->insert();
			unset($value);
		}
		return array(
			'data' => array(
				'id' => $invoiceId,
				'success' => 'success'
			)
		);
	}

//	public function put($params){
//		$obj = new InvoiceObj();
//		$obj->setProperties($params['PUT']);
//		$obj->update($this->getId());
//		return array(
//			'data' => array(
//				'id' => $obj->getId(),
//				'success' => 'success'
//			)
//		);
//	}
//
//	public function patch($params){
//		$obj = new InvoiceObj();
//		$obj->setStatus($params['PATCH']['status']);
//		$obj->updateStatus($this->getId());
//	}

}
