angular
	.module('inspinia')
	.controller('showNewsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		$http({
			method: 'get',
			url: 'news'
		}).then(function(res){
			$scope.news = res.data;
		});

		$scope.changeStatus = function(key){
			$scope.news[key].status = ($scope.news[key].status == 0) ? 1 : 0;
			$http({
				method: 'put',
				url: 'news/'+$scope.news[key].id,
				data: $scope.news[key]
			});
		}

		$scope.delete = function(id){
			$http({
				method: 'delete',
				url: 'news/'+id
			}).then(function(){
				$http({
					method: 'get',
					url: 'news'
				}).then(function(res){
					$scope.news = res.data;
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