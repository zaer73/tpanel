angular
	.module('inspinia')
	.controller('createFluentCreditGroupController', function($rootScope, $scope, $stateParams, $http){
		
		$scope.createFluentCreditGroupURL = 'fluent-credits/groups';

		if($stateParams.id){
			$scope.editFluentCreditGroupURL = 'fluent-credits/groups/'+$stateParams.id;

			$http({
				url: 'fluent-credits/groups/'+$stateParams.id+'/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			});
		}

	});	