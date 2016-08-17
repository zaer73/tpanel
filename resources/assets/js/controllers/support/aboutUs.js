angular
	.module('inspinia')
	.controller('aboutUsController', function($rootScope, $scope, $http){
		
		$scope.aboutUs = '';

		$http({
			url: 'customization/about-us',
			method: 'get'
		}).then(function(res){
			$scope.aboutUs = res.data;
		});

	});	