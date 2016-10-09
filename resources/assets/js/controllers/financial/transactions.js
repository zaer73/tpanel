angular
	.module('inspinia')
	.controller('transactionsController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){
			
		$scope.transactions = [];

		// $http({
		// 	url: 'financial/transactions',
		// 	method: 'get'
		// }).then(function(res){
		// 	$scope.transactions = res.data;
		// });

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
		//     .withDOM('<"html5buttons"B>lTfgitp')
		//     .withButtons([
		//         {extend: 'copy'},
		//         {extend: 'csv'},
		//         {extend: 'excel', title: 'ExampleFile'},
		        
		
		//         {extend: 'print',
		//             customize: function (win){
		//                 $(win.document.body).addClass('white-bg');
		//                 $(win.document.body).css('font-size', '10px');
		
		//                 $(win.document.body).find('table')
		//                     .addClass('compact')
		//                     .css('font-size', 'inherit');
		//             }
		//         }
		//     ]);
		//     
		$scope.dataTableColumns = [
  		// {
	   //      data: 'select_box',
	   //      name: 'select_box',
	   //      sortable: false
	   //  },
  		{
	        data: 'code',
	        name: 'code',
	        sortable: false
	    }, {
	        data: 'value',
	        name: 'value'
	    }, {
	        data: 'type_title',
	        name: 'type_title'
	    }, {
	        data: 'date',
	        name: 'date'
	    }, {
	        data: 'last_credit',
	        name: 'last_credit'
	    }, {
	        data: 'invoices_connections.payment.RefId',
	        name: 'RefId'
	    }, {
	        data: 'description',
	        name: 'description'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/financial/transactions', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();

	});	