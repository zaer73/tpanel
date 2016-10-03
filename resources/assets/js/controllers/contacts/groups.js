angular
	.module('inspinia')
	.controller('contactGroupController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){

		$scope.selectedRows = [];

		// $scope.getGroups = function()
		// {
		// 	$http({
		// 		url: 'contacts/groups',
		// 		method: 'get'
		// 	}).then(function(res){
		// 		$scope.groups = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }
		// $scope.getGroups();

		$scope.delete = function(key, id){
	    	$http({
	    		method: 'delete',
	    		url: 'contacts/groups/'+id,
	    	});
	    	$scope.groups.splice(key, 1);
	    }

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getGroups();
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

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
		{
	        data: 'select_box',
	        name: 'select_box',
	        sortable: false
	    },
		{
	        data: 'id',
	        name: 'id'
	    }, {
	        data: 'title',
	        name: 'title'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'actions',
	        name: 'actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/contacts/groups', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();
		
	});	