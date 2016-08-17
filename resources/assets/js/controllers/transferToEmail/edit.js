angular
	.module('inspinia')
	.controller('editTransferToEmailController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editTransferToEmailURL = 'transfer-to-email/'+$scope.id;

		$http({
			url: 'transfer-to-email/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.transfer;
			$scope.lines = res.data.lines;
		});

	});	