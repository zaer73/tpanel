angular
	.module('inspinia')
	.controller('createChargesController', function($rootScope, $scope){
		
		$scope.createChargesURL = 'charges';

		$scope.random = Math.random().toString(36).substring(13, 5);

	});	