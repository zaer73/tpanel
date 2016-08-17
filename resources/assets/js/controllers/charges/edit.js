angular
	.module('inspinia')
	.controller('editChargesController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editChargesURL = 'charges/'+$scope.id;

		$http({
			url: 'charges/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	