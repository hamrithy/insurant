<?php
use
    OSC\PaymentMaster\Collection as  PaymentCol,
    OSC\PaymentMaster\Object as  PaymentObj,
    OSC\PaymentMasterDetail\Object as  PaymentDetailObj,
    OSC\PurchaseMaster\Object as  PurchaseObj
;

class RestApiPayment extends RestApi{

    public function get($params){
        $col=new PaymentCol;
        $col->sortById('DESC');
        $params['GET']['id'] ? $col->filterById($params['GET']['id']) : '';
        $showDataPerPage = 20;
        $start = $params['GET']['start'];
        $this->applyLimit($col,
            array(
                'limit' => array( $start, $showDataPerPage )
            )
        );
        return $this->getReturn($col,$params);
    }

    public function post($params){
        $obj = new PaymentObj();
        $obj->setCreateBy($_SESSION['user_name']);
        $obj->setProperties($params['POST']['payment'][0]);
        $obj->insert();
        $paymentId = $obj->getId();
        // start insert data into detail
        foreach( $params['POST']['payment_detail'] as $key => $value){
            $obj = new PaymentDetailObj();
            $obj->setPurchaseId($paymentId);
            $obj->setProperties($value);
            $obj->insert();
            // update balance
            $objpro = new PurchaseObj();
            $objpro->setProductsQuantity($value['qty']);
            $objpro->updateStockIn($value['product_id']);
            unset($value);
        }
        return array(
            'data' => array(
                'id' => $obj->getId(),
                'success' => 'success'
            )
        );
    }

    public function put($params){
        $obj = new PurchaseObj();
        $this->setId($this->getId());
        $obj->setProperties($params['PUT']);
        $obj->update($this->getId());
        return array(
            'data' => array(
                'id' => $obj->getId(),
                'success' => 'success'
            )
        );
    }

    public function delete(){
        $obj = new PurchaseObj();
        $obj->delete($this->getId());
    }

}
