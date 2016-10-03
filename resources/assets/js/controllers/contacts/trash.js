angular
	.module('inspinia')
	.controller('trashContactController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){
		
		$scope.selectedRows = [];

		// $scope.getContacts = function()
		// {
		// 	$http({
		// 		method: 'get',
		// 		url: 'contacts/trash'
		// 	}).then(function(res){
		// 		$scope.contacts = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }	
		// $scope.getContacts();

		$scope.restore = function(key, index){
			$http({
				url: 'contacts/trash/restore/'+index,
				method: 'post'
			});
			$scope.contacts.splice(key, 1);
		}

		$scope.explode = function(key, index){
			$http({
				url: 'contacts/trash/explode/'+index,
				method: 'post'
			});
			$scope.contacts.splice(key, 1);
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
	    		$scope.explode($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getContacts();
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
	        data: 'name',
	        name: 'name'
	    }, {
	        data: 'number',
	        name: 'number'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'trash_actions',
	        name: 'trash_actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/contacts/trash', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();
	});	