angular
	.module('inspinia')
	.controller('lawyersController', function($scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'users/lawyer',
			method: 'get'
		}).then(function(res){
			$scope.lawyers = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'users/lawyer/'+index
			});
			$scope.lawyers.splice(key, 1);
		};

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