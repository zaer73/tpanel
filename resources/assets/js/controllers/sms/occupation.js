angular
	.module('inspinia')
	.controller('sendOccupationSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		
		$scope.messageCharacters = 0;

		$scope.sendOccupationSMSURL = 'sms/send/to/occupation';

		$scope.occupations = [];

		$http({
			method: 'get',
			url: 'occupations'
		}).then(function(res){
			$scope.occupations = res.data;
		});

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		$scope.occupationChanged = function(occupation){
			$http({
				url: 'occupations/count/'+occupation,
				method: 'get'
			}).then(function(res){
				$scope.sendingCountRelative = res.data.ranges;
				$scope.maxSendingCount = res.data.max;
			});
		}

		if($stateParams.id){
			$http({
				url: 'sms/input/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
				$scope.occupationChanged($rootScope.info.occupation);
				$scope.calculateCharacters($rootScope.info.text);
			});
		}

	});