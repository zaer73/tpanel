angular
	.module('inspinia')
	.controller('numbersBankController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$scope.getNumbers = function()
		{
			$http({
				url: 'numbers-bank',
				method: 'get'
			}).then(function(res){
				$scope.numbers = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getNumbers();

		$scope.delete = function(key, id)
		{
			$http({
				url: 'numbers-bank/'+id,
				method: 'delete'
			}).then(function(){
				$http({
					url: 'numbers-bank',
					method: 'get'
				}).then(function(res){
					$scope.numbers = res.data;
				});
			});
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
	    	$scope.getNumbers();
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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