angular
	.module('inspinia')
	.controller('editPlansController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editPlansURL = 'plans/'+$scope.id;

		$http({
			url: 'plans/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.plan;
			$scope.data = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

	});	