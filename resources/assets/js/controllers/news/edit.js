angular
	.module('inspinia')
	.controller('editNewsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.editNewsURL = 'news/'+$stateParams.news_id;
		$http({
			method: 'get',
			url: 'news/'+$stateParams.news_id+'/edit'
		}).then(function(res){
			$rootScope.info = res.data;
		});
	});	