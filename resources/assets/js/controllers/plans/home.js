angular
	.module('inspinia')
	.controller('plansController', function($rootScope, $scope, $http, DTOptionsBuilder, SweetAlert, $filter){
		
		$http({
			url: 'plans',
			method: 'get'
		}).then(function(res){
			$scope.plans = res.data;
		});

		$scope.delete = function(key, index){
			SweetAlert.swal({
				title: $filter('translate')("ARE_YOU_SURE?"),
				type: "warning",
    			showCancelButton: true,
    			closeOnConfirm: true,
    			closeOnCancel: true,
    			confirmButtonText: $filter('translate')('YES_DELETE_IT'),
    			cancelButtonText: $filter('translate')('NO'),
			}, function(isConfirm){
				if(isConfirm){
					$http({
						method: 'delete',
						url: 'plans/'+index
					});
					$scope.plans.splice(key, 1);
				}
			})
		};

		$scope.disable = function(key, index){
			SweetAlert.swal({
				title: $filter('translate')("ARE_YOU_SURE?"),
				type: "warning",
    			showCancelButton: true,
    			closeOnConfirm: true,
    			closeOnCancel: true,
    			confirmButtonText: $filter('translate')('YES_DISABLE_IT'),
    			cancelButtonText: $filter('translate')('NO'),
			}, function(isConfirm){
				if(isConfirm){
					$http({
						method: 'delete',
						url: 'plans/disable/'+index
					});
					$scope.plans[key].status = -1;
				}
			});
		};

		$scope.enable = function(key, index){
			$http({
				method: 'put',
				url: 'plans/enable/'+index
			});
			$scope.plans[key].status = 0;
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