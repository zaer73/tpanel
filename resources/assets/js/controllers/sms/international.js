angular
	.module('inspinia')
	.controller('sendInternationalSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){
		
		$scope.sendInternationalSMSURL = 'sms/send/to/international';

		
		$scope.messageCharacters = 0;
		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		$scope.groups = [];
		$scope.contacts = [];
		$scope.selectedGroup = null;

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$http({
			url: 'contacts/contact',
			method: 'get'
		}).then(function(res){
			$scope.contacts = res.data;
		});

		if($stateParams.id){
			$http({
				url: 'sms/input/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
				$scope.calculateCharacters($rootScope.info.text);
			});
		}

	});	