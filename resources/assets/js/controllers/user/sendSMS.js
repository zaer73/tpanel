angular
	.module('inspinia')
	.controller('sendMessageToUserController', function($rootScope, $scope, charactersFactory){
		
		$scope.messageCharacters = 0;

		$scope.sendSingleSMSURL = 'sms/send/to';
		$scope.sendGroupSMSURL = 'sms/send/to/group';

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

	});	