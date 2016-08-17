angular
	.module('inspinia')
	.controller('createModuleController', function($rootScope, $scope, $http){
		
		$scope.createTransferToEmailURL = 'modules';

		$http({
			url: 'modules/api',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

	});	