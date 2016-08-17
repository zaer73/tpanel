angular
	.module('inspinia')
	.controller('showGenderSMSList', function($scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];

		$http({
			url: 'sms/list/gender',
			method: 'get'
		}).then(function(res){
			$scope.messages = res.data;
		});

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
					url: 'sms/report',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	}, 500);
	    }

	    $scope.delete = function(id){
	    	$http({
	    		url: 'sms/gender/remove/'+id,
	    		method: 'delete'
	    	}).then(function(){
	    		$http({
					url: 'sms/list/gender',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	});
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