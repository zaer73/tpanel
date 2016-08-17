angular
	.module('inspinia')
	.controller('sendSingleSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.userId = null;
		$scope.contacts = [];
		$scope.messageCharactersSingle = 0;
		$scope.testMessageCharacters = 0;


		$scope.sendSingleSMSURL = 'sms/send/to';

		$http({
			url: 'contacts/contact',
			method: 'get'
		}).then(function(res){
			$scope.contacts = res.data;
			$scope.contacts.unshift('');
		});

		$http({
			url: 'sms/schedules',
			method: 'get'
		}).then(function(res){
			$scope.schedules = res.data;
		});

		$scope.calculateCharacters = function(text){
			$scope.messageCharactersSingle = $scope.testMessageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

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