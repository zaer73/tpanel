angular
	.module('inspinia')
	.controller('codereaderController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
		
		$http({
			url: 'codereaders',
			method: 'get'
		}).then(function(res){
			$scope.codereaders = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'codereaders/'+index,
				method: 'delete'
			});
			$scope.codereaders[key].status = -1;
		};

		$scope.activate = function(key, index){
			$http({
				url: 'codereaders/enable/'+index,
				method: 'put'
			});
			$scope.codereaders[key].status = 0;
		};

		$scope.trash = function(key, index){
			$http({
				url: 'codereaders/trash/'+index,
				method: 'delete'
			});
			$scope.codereaders.splice(key, 1);
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
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'codereaders',
					method: 'get'
				}).then(function(res){
					$scope.codereaders = res.data;
				});
	    	}, 500);
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