angular
	.module('inspinia')
	.controller('createSchedulesController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.creaetSchedulesURL = 'sms/schedules';

		$http({
			url: 'sms/schedules/create',
			method: 'get'
		}).then(function(res){
			$scope.scheduleInfos = res.data;
		});

		$scope.monthDays = function(){
			var array = [];
			for(var i=1; i<=31; i++){
				array.push(i);
			}
			return array;
		}

		if($stateParams.id){
			$scope.creaetSchedulesURL = 'sms/schedules/'+$stateParams.id;
			$http({
				url: 'sms/schedules/'+$stateParams.id+'/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			});
		}

	});	