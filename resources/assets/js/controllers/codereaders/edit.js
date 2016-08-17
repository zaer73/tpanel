angular
	.module('inspinia')
	.controller('editCodereaderController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editCodereaderURL = 'codereaders/'+$scope.id;

		$scope.conditions = [{condition: '', reaction: ''}];

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});


		$http({
			url: 'codereaders/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.conditions = res.data.conditions;
		});

		$scope.addRow = function($event){
			$event.preventDefault();
			$scope.conditions.push({condition: '', reaction: ''});
		}

	});	