angular
	.module('inspinia')
	.controller('editFluentCreditController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFluentCreditURL = 'fluent-credits/'+$scope.id;

		$http({
			url: 'fluent-credits/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		})

	});	