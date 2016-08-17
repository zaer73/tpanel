angular
	.module('inspinia')
	.controller('editPollController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editPollURL = 'polls/'+$scope.id;

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'polls/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.answers = res.data.answer;
		});

		$scope.addAnswer = function($event){
			$event.preventDefault();
			$scope.answers.push('');
		}

	});	