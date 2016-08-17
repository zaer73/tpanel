angular
	.module('inspinia')
	.controller('editPriceGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;
		$scope.editPriceGroupURL = 'price-group/' + $scope.id;
		$http({
			method: 'get',
			url: 'price-group/' + $scope.id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			method: 'get', 
			'url': 'price-group/api'
		}).then(function(res){
			$scope.groups = res.data;
		});
	});	