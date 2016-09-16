angular
	.module('inspinia')
	.controller('smsReceiversController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];

		$scope.lines = $scope.editURL = $scope.editNumber = [];
		$scope.editURLID = '';
		$scope.editNumberID = '';

		$http({
			url: 'receive-sms',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.editRow = function(key, index){
			$scope.editURLID = index;
			$scope.editNumberID = index;
		}

		$scope.delete = function(id){
			$http({
				url: 'receive-sms/'+id,
				method: 'delete'
			}).then(function(){
				$http({
					url: 'receive-sms',
					method: 'get'
				}).then(function(res){
					$scope.lines = res.data;
				});
			});
		}

		$scope.saveEditURL = function(line){
			$scope.editURL[line.id] = $scope.editURL[line.id]+'?from=FROM&to=TO&text=TEXT';
			$http({
				url: 'receive-sms/'+$scope.editURLID,
				method: 'put',
				data: {
					url: $scope.editURL[line.id],
					receiver_number: $scope.editNumber[line.id]
				}
			});
			line.receivers.redirect_url = $scope.editURL[line.id];
			$scope.editURLID = '';
			$scope.editNumberID = '';
			// $scope.editURL[line.id] = '';
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
					url: 'receive-sms',
					method: 'get'
				}).then(function(res){
					$scope.lines = res.data;
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