angular
	.module('inspinia')
	.controller('createCodereaderController', function($rootScope, $scope, $http){
		
		$scope.createCodereaderURL = 'codereaders';

		$scope.conditions = [{condition: '', reaction: ''}];

		$scope.addRow = function($event){
			$event.preventDefault();
			$scope.conditions.push({condition: '', reaction: ''});
		}

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	