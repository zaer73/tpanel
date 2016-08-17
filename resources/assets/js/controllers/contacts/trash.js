angular
	.module('inspinia')
	.controller('trashContactController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];

		$scope.getContacts = function()
		{
			$http({
				method: 'get',
				url: 'contacts/trash'
			}).then(function(res){
				$scope.contacts = res.data;
				$scope.selectedRows = [];
			});
		}	
		$scope.getContacts();

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
    		jQuery('input[type=checkbox].selectRow').trigger('click');
    	});


		$scope.dtOptions = DTOptionsBuilder.newOptions()
		    .withDOM('<"html5buttons"B>lTfgitp')
		    .withButtons([
		        {extend: 'copy'},
		        {extend: 'csv'},
		        {extend: 'excel', title: 'ExampleFile'},
		        
		
		        {extend: 'print',
		            customize: function (win){
		                $(win.document.body).addClass('white-bg');
		                $(win.document.body).css('font-size', '10px');
		
		                $(win.document.body).find('table')
		                    .addClass('compact')
		                    .css('font-size', 'inherit');
		            }
		        }
		    ]);
	});	