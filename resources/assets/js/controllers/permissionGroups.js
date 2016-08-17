angular
	.module('inspinia')
	.controller('permissionGroupsController', function($rootScope, $scope, $http, DTOptionsBuilder, SweetAlert, $filter){
		$http({
			method: 'get',
			url: 'permissions/groups',
			data: []
		}).then(function(res){
			$scope.groups = res.data;
		});

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

	    $scope.delete = function(id, key){
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
						url: 'permissions/groups/' + id,
						data: []
					}).then(function(res){
						$scope.groups.splice(key, 1);
					});
				}
			});
	    }
	});