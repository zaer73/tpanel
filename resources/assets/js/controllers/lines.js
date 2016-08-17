angular
	.module('inspinia')
	.controller('linesController', function($rootScope, $scope, $http, DTOptionsBuilder, $stateParams){
		$scope.lines = [];
		$scope.targetId = $stateParams.id;
		$scope.toUserUrl = 'lines/to-user/'+$stateParams.id;
		var url;
		if(!$stateParams.id){
			url = 'lines';
		} else {
			url = 'lines/' + $stateParams.id;
		}


		$http({
			method: 'get',
			url: url
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			method: 'get',
			url: 'lines/to-user'
		}).then(function(res){
			$scope.linesToUser = res.data;
		});

		$scope.delete = function(key){
			var lineId = $scope.lines[key].id;
			$http({
				method: 'delete',
				url: 'lines/'+lineId 
			}).then(function(res){
				$scope.lines.splice(key,1);
			});
		}

		$scope.makeGeneral = function(key){
			$http({
				url: 'lines/toggle-general',
				method: 'put',
				data: {
					id: $scope.lines[key].id
				}
			});
			$scope.lines[key].general = !$scope.lines[key].general;
		}

		$scope.toggleShoppable = function(key, id){
			$scope.lines[key].shoppable = !$scope.lines[key].shoppable;
			$http({
				url: 'lines/toggle-shoppable',
				method: 'put',
				data: {
					id: id
				}
			});
			return false;
		}

		$scope.toggleNotifier = function(key, id){
			for(line_key in $scope.lines){
				$scope.lines[line_key].notifier = 0;
			}
			$scope.lines[key].notifier = !$scope.lines[key].notifier;
			$http({
				url: 'lines/toggle-notifier',
				method: 'put',
				data: {
					line_id: id
				}
			});
			return false;
		}

		$scope.toggleOwner = function(id, type){
			$http({
				url: 'lines/toggle-owner/'+type,
				method: 'put',
				data: {
					line_id: id
				}
			}).then(function(){
				$http({
					method: 'get',
					url: url
				}).then(function(res){
					$scope.lines = res.data;
				});
			});
		}

		$scope.dtOptions = DTOptionsBuilder.newOptions()
	        .withDOM('<"html5buttons"B>lTfgitp')
	        .withButtons([
	            {extend: 'copy'},
	            {extend: 'csv'},
	            {extend: 'excel', title: 'ExampleFile'},
	            

	            {extend: 'print',
	                customize: function (win){
	                    $(win.document.body).addClass('white-bg');
	                    $(win.document.body).css('font-size', '10px');

	                    $(win.document.body).find('table')
	                        .addClass('compact')
	                        .css('font-size', 'inherit');
	                }
	            }
	        ]);
	});