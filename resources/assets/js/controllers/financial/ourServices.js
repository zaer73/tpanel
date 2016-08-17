angular
	.module('inspinia')
	.controller('ourServicesController', function($rootScope, $scope, $http){

		$scope.ourServices = '';

		$http({
			url: 'customization/our-services',
			method: 'get'
		}).then(function(res){
			$scope.ourServices = res.data;
		});

	});	