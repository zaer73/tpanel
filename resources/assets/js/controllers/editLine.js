angular
	.module('inspinia')
	.controller('editLineController', function($rootScope, $scope, $http, $stateParams){
		$scope.editId = $stateParams.line_id;
		$http({
			url: 'lines/'+$scope.editId+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});
		$scope.editLineURL = 'lines/'+$scope.editId;

		$http({
			url: 'api/users/agents',
			method: 'get'
		}).then(function(res){
			$scope.agents = res.data;
			setTimeout(function(){
				$(".chosen-select-agent").trigger('chosen:updated');
			}, 200)
		});

		$scope.selectUsers = function(){
			$http({
				url: 'api/users/users?agent='+$rootScope.info.agent_id,
				method: 'get'
			}).then(function(res){
				$scope.users = res.data;
				setTimeout(function(){
					$(".chosen-select-user").trigger('chosen:updated');
				}, 200)
			});
		}

		$scope.canBeRahyab = false;

		$scope.rahyabDetector = function(){
			if(!$rootScope.info.number) return;
			$scope.canBeRahyab = ($rootScope.info.number.match(/^50001/));
		}
	});