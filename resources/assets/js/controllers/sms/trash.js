angular
	.module('inspinia')
	.controller('trashedSMSController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];

		$scope.getMessages = function()
		{

			$http({
				url: 'sms/report/trash',
				method: 'get'
			}).then(function(res){
				$scope.messages = res.data;
				$scope.selectedRows = [];
			});
		}

		$scope.getMessages();

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


	    $scope.restore = function(key, id, multi){
	    	$http({
	    		url: 'sms/restore/'+id,
	    		method: 'post'
	    	}).then(function(res){
	    		if(typeof multi == 'undefined'){
	    			$scope.messages.splice(key, 1);
	    		}
	    	});
	    }

	    $scope.destroy = function(key, id, multi){
	    	$http({
	    		url: 'sms/delete/destroy/'+id,
	    		method: 'delete'
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
	    		$scope.destroy($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getMessages();
	    }

	    $scope.restoreSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.destroy($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'sms/report/trash',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	}, 500);
	    }

        	jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').trigger('click');
        	});

	});