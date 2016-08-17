angular.module('inspinia')
	.controller('userPermissionsController', function($rootScope, $scope, $http, $stateParams){
		$scope.userPermissionsURL = 'permissions/user/' + $stateParams.user_id;
		$scope.userPriceGroupURL = 'price-group/user/' + $stateParams.user_id;
		$http({
			method: 'get',
			url: 'permissions/user/' + $stateParams.user_id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info.permissions = res.data.permissions;
			$scope.username = res.data.username;
		});  

		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});

		$http({
			method: 'get',
			url: 'permissions/groups',
		}).then(function(res){
			$scope.permissionGroups = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.priceGroups = res.data;
		});

		$http({
			url: 'price-group/'+$stateParams.user_id,
			method: 'get'
		}).then(function(res){
			$scope.userPriceGroups = res.data;
		});

		$scope.permissionGroupChanged = function(){
			var permissions = JSON.parse($scope.selectedPermissionGroup);
			for(var key in permissions){
				if(permissions[key] != 0 && permissions[key] != 1) continue;
				$rootScope.info.permissions[key] = permissions[key];
			}
		}

		$scope.customCreditFluent = []

		$http({
			url: 'fluent-credits/'+$stateParams.user_id,
			method: 'get'
		}).then(function(res){
			$scope.fluentCredits = res.data;
			if(res.data.custom){
				$scope.customCreditFluent = res.data.custom;
				$rootScope.info.customCreditFluent = res.data.custom;
			}
		});

		$scope.removeFluentCustom = function(key){
			$scope.customCreditFluent.splice(key, 1);
		}

		$scope.addNewCustomCredit = function(key){
			$scope.customCreditFluent.push({
				ceil: '',
				fee: ''
			});
		}

		$scope.submitFluentCredit = function(){
			$rootScope.info.customCreditFluent = $scope.customCreditFluent;
		}
	});