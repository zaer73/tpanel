angular
	.module('inspinia')
	.controller('createPlansController', function($rootScope, $scope, $http){
		
		$scope.createPlansURL = 'plans';

		$http({
			url: 'plans/create',
			method: 'get'
		}).then(function(res){
			$scope.data = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

	});	