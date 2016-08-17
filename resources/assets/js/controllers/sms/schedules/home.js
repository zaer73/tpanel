angular
	.module('inspinia')
	.controller('schedulesController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$http({
			url: 'sms/schedules',
			method: 'get'
		}).then(function(res){
			$scope.schedules = res.data;
		});

		$scope.disable = function(key, index){
			$scope.schedules[key].status = -1;
			$http({
				url: 'sms/schedules/disable',
				method: 'post',
				data: {
					id: index
				}
			})
		}

		$scope.enable = function(key, index){
			$scope.schedules[key].status = 0;
			$http({
				url: 'sms/schedules/enable',
				method: 'post',
				data: {
					id: index
				}
			})
		}

		$scope.delete = function(key, index){
			$scope.schedules.splice(key, 1);
			$http({
				url: 'sms/schedules/'+index,
				method: 'delete',
			});
		}

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
					url: 'sms/schedules',
					method: 'get'
				}).then(function(res){
					$scope.schedules = res.data;
				});
	    	}, 500);
	    }


		    jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').trigger('click');
        	});

	});	