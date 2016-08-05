app.controller(
    'create_invoice_ctrl', [
        '$scope'
        , 'Restful'
        , 'Services'
        , function ($scope, Restful, Services){
            'use strict';
            $scope.invoice_date = moment().format('YYYY-MM-DD');
            $scope.service = new Services();
            $scope.grand_total = 0;
            $scope.input_money = 0;
            $scope.sub_total = 0;
            $scope.discount = '';
            $scope.total_discount = 0;
            $scope.remaining = 0;
            var pay_type = '';
            var bank = '';
            var discount = '';
            $scope.init = function(params){
                // start init Doctor List
                Restful.get('api/DoctorList').success(function(data){
                    $scope.doctors = data;
                });
                Restful.get('api/CustomerType').success(function(data){
                    $scope.customerType = data;
                });
            };
            $scope.init();
            $scope.edit = function(params){
                alert('edit');
                //$('#create-invoice-popup').modal('show');
                //$scope.edit = params;
                //console.log(params);
            };
            $scope.disable = false;
            $scope.save = function(){
                if( !angular.isDefined($scope.customer_list.selected) ){
                    return $scope.service.alertMessage(
                        'Warning:','No Customer. Please Select Customer.','warning'
                    );
                }

                if($scope.invoices.length == 0){
                    return $scope.service.alertMessage(
                        'Warning:','No Service In List. Please Add Service.','warning'
                    );
                }
                var data = {
                    invoice: {
                        invoice_no: 'test_invoice_no',
                        invoice_date: $scope.invoice_date,
                        customer_id: $scope.customer_list.selected.id,
                        customer_name: $scope.customer_list.selected.full_name,
                        customer_type_id: $scope.customer_list.selected.customer_type_id,
                        customer_type_name: $scope.customer_list.selected.customer_type[0].name,
                        doctor_id: $scope.customer_list.selected.doctor_fields[0].id,
                        doctor_name: $scope.customer_list.selected.doctor_fields[0].name,
                        noted: $scope.note,
                        pay_type: pay_type,
                        bank: bank,
                        sub_total: $scope.sub_total,
                        discount_type: discount,
                        total_discount: $scope.total_discount,
                        discount: $scope.discount,
                        grand_total: $scope.grand_total,
                        deposit: $scope.input_money,
                        balance: $scope.remaining
                    },
                    invoice_detail: $scope.invoices
                };
                console.log(data);
                $scope.disable = true;
                Restful.save( 'api/Invoice' , data).success(function (data) {
                    $scope.close();
                    console.log(data);
                    $scope.service.alertMessage('<strong>Success: </strong>', 'Save Success.', 'success');
                    $scope.disable = false;
                    clearAll();
                });
            };

            function clearAll(){
                $scope.close();
                $scope.note = '';
                $scope.grand_total = 0;
                $scope.input_money = 0;
                $scope.sub_total = 0;
                $scope.discount = '';
                $scope.total_discount = 0;
                $scope.remaining = 0;
                var pay_type = '';
                $scope.inputDiscountAmount = false;
                $scope.customer_list = {};
                var bank = '';
                var discount = '';
                $scope.cash = false;
                $scope.dollar = false;
                $scope.percent = false;
                $scope.aclida = false;
                $scope.bank = false;
                $scope.cpb = false;
                $scope.invoices = [];
            };

            $scope.changePaySelect = function(value){
                pay_type = value;
                if(value == 'bank'){
                    $scope.cash = false;
                    $scope.bank = true;
                }else{
                    $scope.bank = false;
                    bank = '';
                    $scope.aclida = false;
                    $scope.cpb = false;
                    $scope.cash = true;
                }
            };

            $scope.changeBankSelect = function(value){
                bank = value;
                if(value == 'CPB'){
                    $scope.aclida = false;
                    $scope.cpb = true;
                }else{
                    $scope.cpb = false; console.log(value);
                    $scope.aclida = true;
                }
            };

            $scope.remove = function($index){
                $scope.invoices.splice($index, 1);
            };
            $scope.invoices = [];
            $scope.add = function(){
                if(!angular.isDefined( $scope.service_list.selected ) ){
                    return $scope.service.alertMessage(
                        'warning:','Please Select Service Name.','warning'
                    );
                }
                if(!angular.isDefined( $scope.unit ) ){
                    return $scope.service.alertMessage(
                        'warning:','Please Input Unit.','warning'
                    );
                }
                var unit_in_stock = parseInt($scope.service_list.selected.unit);
                //console.log(unit_in_stock);
                //console.log('qty in stock => ',$scope.service_list.selected.unit);
                // check if qty has in stock add
                //if($scope.unit < unit_in_stock ) {
                    // check if exist in list
                    for (var i = 0, l = $scope.invoices.length; i < l; i++) {
                        var obj = $scope.invoices[i];
                        if (obj.service_id === $scope.service_list.selected.id) {
                            var old_qty = parseInt(obj.qty) + parseInt($scope.unit);
                            // check again in existing object
                            //if( old_qty < unit_in_stock){
                                obj.qty = old_qty;
                                obj.dent_order = $scope.dent_order;
                                obj.color = $scope.color;
                                obj.total = obj.qty * obj.unit_price;
                                $scope.getTotal();
                                $scope.close();
                                return;
                            //}else{
                            //    return  $scope.service.alertMessage(
                            //        'warning:','OPP! Out Off Stock. You Have Only ' + $scope.service_list.selected.unit +' Unit In Stock.','warning'
                            //    );
                            //}
                        }
                    }
                    $scope.invoices.push({
                        service_id: $scope.service_list.selected.id,
                        service_name: $scope.service_list.selected.service_name,
                        dent_order: $scope.dent_order,
                        color: $scope.color,
                        qty: $scope.unit,
                        unit_price: $scope.service_list.selected.price,
                        total: $scope.service_list.selected.price * $scope.unit
                    });
                    $scope.getTotal();
                    $scope.close();
                //}else{
                //    return  $scope.service.alertMessage(
                //        'warning:','OPP! Out Off Stock. You Have Only ' + $scope.service_list.selected.unit +' Unit In Stock.','warning'
                //    );
                //}
            };

            // functional get total of all products
            $scope.getTotal = function(){
                $scope.sub_total = 0;
                for (var i = 0, l = $scope.invoices.length; i < l; i++) {
                    var obj = $scope.invoices[i];
                    $scope.sub_total = $scope.sub_total + (obj.qty * obj.unit_price);
                }
                $scope.sub_total.toFixed(2);
                $scope.grand_total = $scope.sub_total.toFixed(2);
                $scope.remaining = $scope.grand_total;
            };

            // calculate money payment
            $scope.inputMoney = function(){
                if($scope.sub_total){
                    $scope.remaining = ($scope.sub_total - $scope.input_money - $scope.total_discount).toFixed(2);
                }else{
                    $scope.remaining = '';
                }
            };
            // function calculate discount when change value
            $scope.inputDiscount = function(){
                //$scope.total_discount = $scope.discount;
                $scope.checkTypeDiscount();
                //$scope.grand_total = $scope.sub_total - $scope.total_discount;
            };

            // functionality calculate discount type
            $scope.checkTypeDiscount = function(value) {
                $scope.inputDiscountAmount = true;
                if( value ){
                    discount = value;
                }
                if(discount == "percent"){
                    $scope.total_discount = (($scope.discount / 100) * $scope.sub_total).toFixed(2);
                    $scope.grand_total = $scope.sub_total - $scope.total_discount;
                    $scope.remaining =  $scope.grand_total - $scope.input_money;
                    $scope.percent = true;
                    $scope.dollar = false;
                }else{
                    $scope.total_discount = $scope.discount;
                    $scope.grand_total = $scope.sub_total - $scope.total_discount;
                    $scope.remaining = $scope.grand_total - $scope.input_money;
                    $scope.dollar = true;
                    $scope.percent = false;
                }
            };

            $scope.changeUnit = function(params){
                console.log(params);
                $scope.getTotal();
            };

            $scope.close = function(){
                $scope.disable = false;
                $scope.service_list = {};
                $scope.unit = '';
                $scope.dent_order = '';
                $scope.color = '';
                $scope.edit = '';
            };

            // customer filter
            $scope.customer_list = {};
            $scope.refreshCustomerList = function(customer_list) {
                var params = {name: customer_list, search_in_invoice: 'yes'};
                return Restful.get('api/CustomerList', params).then(function(response) {
                    $scope.CustomerList = response.data.elements;
                });
            };
            var customerId = '';
            $scope.changeService = function(id){
                customerId = id;
                $scope.refreshServiceList();
            };
            $scope.changeCustomer = function(params){
                customerId = params.selected.customer_type_id;
                $scope.refreshServiceList();
            };

            // service filter
            $scope.service_list = {};

            $scope.refreshServiceList = function(service) {
                var params = {name: service, customer_type_id: customerId};
                return Restful.get('api/Service', params).then(function(response) {
                    $scope.serviceList = response.data.elements;
                });
            };
        }
    ]);