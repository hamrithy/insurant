app.controller(
    'pay_bill_ctrl', [
        '$scope'
        , 'Restful'
        , 'Services'
        , function ($scope, Restful, Services){
            $scope.service = new Services();
            var jQueryDatePickerOpts = {
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: false,
                showAnim: ''
            };
            $("#jQueryDatePicker").datepicker(jQueryDatePickerOpts);
            $scope.loading = false;
            $scope.init = function(params){
                $scope.loading = true;
                $scope.purchase = '';
                Restful.get('api/Purchase', params).success(function(data){
                    $scope.purchase = data;
                    $scope.loading = false;
                });
            };

            $scope.checkValueInput = function(params){
                console.log(  parseInt( params.remain) );
                if( $scope.payment_amount >= parseInt( params.remain) ){
                    $scope.payment_amount = params.remain;
                    console.log(params.remain);
                }
            };

            $scope.date = moment().format('DD-MM-YYYY');
            $scope.sub_total = 0;
            $scope.balance = 0;
            $scope.save = function(){
                if( !angular.isDefined($scope.vendor_list.selected) ){
                    return $scope.service.alertMessage(
                        'Warning:','No Vendor. Please Select Vendor.','warning'
                    );
                }
                if($scope.listData.length == 0){
                    return $scope.service.alertMessage(
                        'Warning:','No Product In List. Please Add Product.','warning'
                    );
                }
                $scope.disable = true;
                var data = {
                    payment: [{
                        payment_date: $scope.date,
                        total: $scope.sub_total,
                        balance: $scope.balance,
                        note: $scope.note,
                        reference_no: $scope.reference_no,
                        supplier_id: $scope.vendor_list.selected.id,
                        supplier_name: $scope.vendor_list.selected.name,
                    }],
                    payment_detail: $scope.listData
                };
                console.log(data);
                Restful.save('api/Payment', data).success(function (data) {
                    console.log(data);
                    clear();
                    clearVendor();
                    clearProduct();
                });
            };

            function clearVendor(){
                $scope.listData = [];
                $scope.reference_no = '';
                $scope.vendor_list = {};
                $scope.note = '';
                $scope.input_money = '';
                $scope.sub_total = 0;
                $scope.remaining = 0;
            };

            // vendor filter
            $scope.vendor_list = {};
            $scope.refreshVendorList = function(vendor_list) {
                var params = {name: vendor_list};
                return Restful.get('api/VendorList', params).then(function(response) {
                    $scope.vendors = response.data.elements;
                });
            };

            // filter by vendor to show in purchase list
            $scope.getVendor = function(params){
                var data = {
                    vendor_id: params.id
                };
                $scope.init(data);
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

            // functionality calculate discount type
            $scope.checkTypeDiscount = function(value) {
                $scope.inputDiscountAmount = true;
                if( value ){
                    discount = value;
                }
                if(discount == "percent"){
                    $scope.total_discount = (($scope.discount / 100) * $scope.sub_total).toFixed(2);
                    $scope.grand_total = $scope.sub_total - $scope.total_discount;
                    $scope.balance =  $scope.grand_total - $scope.input_money;
                    $scope.percent = true;
                    $scope.dollar = false;
                }else{
                    $scope.total_discount = $scope.discount;
                    $scope.grand_total = $scope.payment_amount - $scope.total_discount;
                    $scope.balance = $scope.grand_total - $scope.input_money;
                    $scope.dollar = true;
                    $scope.percent = false;
                }
            };
        }
    ]);