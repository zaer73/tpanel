angular
	.module('inspinia')
	.controller('financialReportController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){
		
		$scope.transactions = [];

		// $http({
		// 	url: 'financial/report',
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
		$scope.dataTableColumns = [
  		// {
	   //      data: 'select_box',
	   //      name: 'select_box',
	   //      sortable: false
	   //  },
  		{
	        data: 'id',
	        name: 'id'
	    }, {
	        data: 'group.title',
	        name: 'group'
	    }, {
	        data: 'name',
	        name: 'name'
	    }, {
	        data: 'number',
	        name: 'number'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'actions',
	        name: 'actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/financial/report', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();

	});	