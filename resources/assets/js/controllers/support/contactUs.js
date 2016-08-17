angular
	.module('inspinia')
	.controller('contactUsController', function($rootScope, $scope, $http){
		
		$scope.contactUs = '';

		$http({
			url: 'customization/contact-us',
			method: 'get'
		}).then(function(res){
			$scope.contactUs = res.data;
		});

	});	