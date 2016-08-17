angular
	.module('inspinia')
	.controller('createTransferToEmailController', function($rootScope, $scope, $http){
		
		$scope.createTransferToEmailURL = 'transfer-to-email';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

	});	