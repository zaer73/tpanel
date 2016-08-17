angular
	.module('inspinia')
	.controller('marketingCodeController', function($rootScope, $scope, $http){
		$http({
			url: 'marketing-codes',
			method: 'get'
		}).then(function(res){
			$scope.marketingCode = res.data;
			$rootScope.info = res.data;
			$scope.createMarketingPolicyURL = 'marketing-codes/'+$rootScope.user.id;
		});

		
	});