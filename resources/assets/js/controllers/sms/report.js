angular
	.module('inspinia')
	.controller('reportSMSController', function($rootScope, $scope, $http, DTOptionsBuilder, $modal, $state, $ocLazyLoad){
		
		$scope.messages = [];
		$rootScope.groupMessages = [];
		$scope.selectedRows = [];

		$scope.getMessages = function(){
			$http({
				url: 'sms/report',
				method: 'get'
			}).then(function(res){
				$scope.messages = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getMessages();

		$scope.resendProcessing = false;

		$scope.retry = function(){
			$http({
				url: 'sms/retry',
				method: 'post'
			});
			$scope.resendProcessing = true;
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

	    $scope.delete = function(key, message_id){
	    	$http({
	    		method: 'delete',
	    		url: 'sms/delete/sent/'+message_id,
	    	});
	    }

	    $scope.resend = function(queueName, inputId){
	    	if(queueName == '') return;
	    	var route = queueName.replace('SMS', '', queueName);
	    	$state.go('app.sms.'+route+'Resend', {id: inputId});
	    	// $http({
	    	// 	method: 'post',
	    	// 	url: 'sms/resend',
	    	// 	data: message
	    	// }).then(function(){
	    	// 	$scope.getMessages();
	    	// });	
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
		    $scope.getMessages();
	    }

	    $scope.resendSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.resend(selected, $scope.messages[selected].id);
	    	}
	    	$scope.selectedRows = [];
	    }

    	jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').trigger('click');
    	});

        $scope.showGroupMessages = function(id){
        	$rootScope.groupMessages = [];
        	$http({
        		method: 'get',
        		url: 'sms/report/group/'+id
        	}).then(function(res){
        		$rootScope.groupMessages = res.data;
        	})
        	$modal.open({
                templateUrl: 'views/common/show_group_numbers.html',
                controller: function($scope, DTOptionsBuilder){
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
                }
            });
        }

	});	