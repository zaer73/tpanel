angular
	.module('inspinia')
	.controller('receivedSMSController', function($rootScope, $scope, $http, $modal, DTOptionsBuilder){

		$scope.selectedRows = [];

		$scope.getMessages = function()
		{
			$http({
				url: 'sms/report/received',
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

	    $scope.forward = function(event, message){
	    	$rootScope.messageToForward = message;
	    	$modal.open({
	    		templateUrl: 'views/sms/forward-modal.html',
	    		controller: 'forwardMessageController'
	    	});
	    }

	    $scope.reply = function(event, message){
	    	$rootScope.messageToReply = message;
	    	$modal.open({
	    		templateUrl: 'views/sms/reply-modal.html',
	    		controller: 'replyMessageController'
	    	});
	    }

	    $scope.delete = function(key, index, multi){
	    	$http({
				'method': 'delete',
				'url': 'sms/report/received/'+index
			}).then(function () {
				$scope.getMessages();
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
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getMessages();
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

	})
	.controller('forwardMessageController', function($rootScope, $scope, $http, $modalInstance){
		$scope.message = $rootScope.messageToForward;

	    $rootScope.$on('successfulRequest', function(){
	    	$modalInstance.close();
	    });

	    $scope.sendSingleSMSURL = 'sms/send/to';

	    $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	    };
	})
	.controller('replyMessageController', function($rootScope, $scope, $http, $modalInstance){
		$scope.message = $rootScope.messageToReply;

	    $rootScope.$on('successfulRequest', function(){
	    	$modalInstance.close();
	    });

	    $scope.sendSingleSMSURL = 'sms/send/to';

	    $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	    };
	});