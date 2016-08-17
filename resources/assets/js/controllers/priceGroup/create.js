angular
	.module('inspinia')
	.controller('createPriceGroupController', function($rootScope, $scope, $http){

		$scope.savePriceGroupURL = 'price-group';

		$http({
			method: 'get', 
			'url': 'price-group/api'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$http({
			method: 'get', 
			'url': 'price-group/create'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});