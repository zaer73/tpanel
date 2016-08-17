angular
	.module('inspinia')
	.controller('createPollController', function($rootScope, $scope, $http){
		
		$scope.createPollURL = 'polls';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.answers = [{answer: ''}];

		$scope.addAnswer = function($event){
			$event.preventDefault();
			$scope.answers.push({answer: ''});
		}

	});	