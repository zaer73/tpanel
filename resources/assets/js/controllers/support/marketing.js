angular
	.module('inspinia')
	.controller('supportMarketingCodeController', function($rootScope, $scope, $http){
		
		$scope.marketingCode = [];

		$http({
			url: 'customization/marketing_code',
			method: 'get'
		}).then(function(res){
			$scope.marketingCode = res.data;
		});

	});	