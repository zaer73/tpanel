angular
	.module('inspinia')
	.controller('sendGroupSMSController', function($rootScope, $scope, $http, $modal, $stateParams, charactersFactory){

		$scope.sendGroupSMSURL = 'sms/send/to/group';
		

		$scope.groups = [];
		$scope.contacts = [];
		$scope.selectedGroup = null;
		$scope.messageCharacters = 0;

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

		$http({
			url: 'sms/schedules',
			method: 'get'
		}).then(function(res){
			$scope.schedules = res.data;
		});

		$scope.newNumber = function(res){
			if(isNaN(res)) return;
			return {
				name: res,
				number: res
			};
		}

		$scope.openDropzoneModal = function(e){
			e.preventDefault();
			$rootScope.modal = $modal.open({
                templateUrl: 'views/sms/import_contacts.html',
            });
		}

		$rootScope.$on('fileUploaded', function(res, msg){
			$scope.$apply(function(){
				var numbers = '';
				for(number in msg){
					numbers += msg[number]+',';
				}
				$rootScope.info.numbers = numbers;
			});
		});

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
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