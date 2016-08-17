angular
	.module('inspinia')
	.controller('usersController', function($rootScope, $scope, $http, DTOptionsBuilder, $modal, SweetAlert, $filter){

		$scope.selectedRows = [];
		$scope.selectedNumbers = [];

		$http({
			method: 'get',
			url: 'users',
			data: []
		}).then(function(res){
			$scope.users = res.data;
		});

		$scope.enable = function(key, id){
			SweetAlert.swal({
                title: $filter('translate')('ARE_YOU_SURE'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: $filter('translate')('YES'),
                cancelButtonText: $filter('translate')('NO')},
            function (isConfirm) {
                if (isConfirm) {
					$scope.users[key].status = 0;
					$http({
						url: 'users/toggle-status/'+id,
						method: 'put'
					});
				}
			});
		}

		$scope.disable = function(key, id){
			SweetAlert.swal({
                title: $filter('translate')('ARE_YOU_SURE'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: $filter('translate')('YES'),
                cancelButtonText: $filter('translate')('NO')},
            function (isConfirm) {
                if (isConfirm) {
					$scope.users[key].status = -1;
					$http({
						url: 'users/toggle-status/'+id,
						method: 'put'
					});
				}
			});
		}

		$scope.makeAgent = function(key, id){
			SweetAlert.swal({
                title: $filter('translate')('ARE_YOU_SURE'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: $filter('translate')('YES'),
                cancelButtonText: $filter('translate')('NO')},
            function (isConfirm) {
                if (isConfirm) {
                    $scope.users[key].role = 1;
					$http({
						url: 'users/toggle-role/'+id,
						method: 'put'
					});
                }
            });
		}

		$scope.makeUser = function(key, id){
			SweetAlert.swal({
                title: $filter('translate')('ARE_YOU_SURE'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: $filter('translate')('YES'),
                cancelButtonText: $filter('translate')('NO')},
            function (isConfirm) {
                if (isConfirm) {
					$scope.users[key].role = 0;
					$http({
						url: 'users/toggle-role/'+id,
						method: 'put'
					});
				}
			});
		}

		$scope.trash = function(key, id){
			SweetAlert.swal({
                title: $filter('translate')('ARE_YOU_SURE'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: $filter('translate')('YES'),
                cancelButtonText: $filter('translate')('NO')},
            function (isConfirm) {
                if (isConfirm) {
					$scope.users.splice(key, 1);
					$http({
						url: 'users/'+id,
						method: 'delete'
					});
				}
			});
		}

		$scope.sendMessage = function(key, number){
			$rootScope.sendMessageToMobile = number;
			$modal.open({
                templateUrl: 'views/common/sms_to_user.html',
            });
		}

		$scope.selectRow = function(key, id, number){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		delete($scope.selectedNumbers[$scope.selectedNumbers.indexOf(number)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    	$scope.selectedNumbers.push(number);
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.trash($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'users',
					method: 'get'
				}).then(function(res){
					$scope.users = res.data;
				});
	    	}, 500);
	    }

	    $scope.sendGroup = function(){
	    	$rootScope.sendMessageToMobile = $scope.selectedNumbers.join();
			$modal.open({
                templateUrl: 'views/common/sms_to_user_group.html',
            });
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').trigger('click');
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

	});	