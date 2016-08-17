angular
	.module('inspinia')
	.controller('supportFaqController', function($rootScope, $scope, $http){
		
		$scope.faqs = [];

		$http({
			url: 'faqs',
			method: 'get'
		}).then(function(res){
			$scope.faqs = res.data;
		});

	});	