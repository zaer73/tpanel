angular
	.module('inspinia')
	.controller('postalCodeController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$scope.getPostalCodes = function()
		{
			$http({
				url: 'postal-code/api',
				method: 'get'
			}).then(function(res){
				$scope.postalCodes = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getPostalCodes();

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'postal-code/'+index
			});
			$scope.postalCodes.splice(key, 1);
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
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	$scope.getPostalCodes();
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