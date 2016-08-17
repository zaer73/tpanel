angular
	.module('inspinia')
	.controller('createLanguageController', function($rootScope, $scope, $http){
		
		$scope.createLanguageURL = 'languages';

		$http({
			url: 'languages/create', 
			method: 'get'
		}).then(function(res){
			$scope.items = res.data;
		});

	});	