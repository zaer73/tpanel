angular
	.module('inspinia')
	.controller('createLinePatternController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.createLinePatternURL = 'line-patterns';

		$http({
			url: 'api/operators',
			method: 'post'
		}).then(function(res){
			$scope.operators = res.data;
		});

		if($stateParams.id){
			$http({
				url: 'line-patterns/'+$stateParams.id+'/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			})
		}

	});	