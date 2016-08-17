angular
	.module('inspinia')
	.controller('editDefaultMessagesController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.editDefaultMessagesURL = 'sms/default-messages/'+$stateParams.id;

		$http({
			url: 'sms/default-messages/'+$stateParams.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	