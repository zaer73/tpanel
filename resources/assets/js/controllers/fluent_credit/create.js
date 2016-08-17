angular
	.module('inspinia')
	.controller('createFluentCreditController', function($rootScope, $scope, $http){
		
		$scope.createFluentCreditURL = 'fluent-credits';

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		})

	});	