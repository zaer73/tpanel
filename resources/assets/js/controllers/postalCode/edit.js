angular
	.module('inspinia')
	.controller('editPostalCodeController', function($rootScope, $scope, $http, $stateParams){
			
		$scope.id = $stateParams.id;
			
		$scope.editPostalCodeURL = 'postal-code/'+$scope.id;

		$http({
			method: 'get',
			url: 'postal-code/'+$scope.id+'/edit'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	