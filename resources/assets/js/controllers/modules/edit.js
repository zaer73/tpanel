angular
	.module('inspinia')
	.controller('editModuleController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editTransferToEmailURL = 'modules/'+$scope.id;

		$http({
			url: 'modules/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.module;
			$scope.modules = res.data.modules;
		});

	});	