angular
	.module('inspinia')
	.controller('createUserController', function($rootScope, $scope, $http){

		$scope.createUserURL = 'users';
		$scope.createLawyerUserURL = 'users/lawyer';

		$http({
			url: 'plans',
			method: 'get'
		}).then(function(res){
			$scope.plans = res.data;
		})

	});
angular
	.module('inspinia')
	.controller('createLineController', function($rootScope, $scope, $http){
		$scope.createLineURL = 'lines';
	
		$http({
			url: 'api/users/agents',
			method: 'get'
		}).then(function(res){
			$scope.agents = res.data;
			setTimeout(function(){
				$(".chosen-select-agent").trigger('chosen:updated');
			}, 200)
		});

		$scope.selectUsers = function(){
			$http({
				url: 'api/users/users?agent='+$rootScope.info.agent_id,
				method: 'get'
			}).then(function(res){
				$scope.users = res.data;
				setTimeout(function(){
					$(".chosen-select-user").trigger('chosen:updated');
				}, 200)
			});
		}

		$scope.canBeRahyab = false;

		$scope.rahyabDetector = function(){
			if(!$rootScope.info.number) return;
			$scope.canBeRahyab = ($rootScope.info.number.match(/^50001/));
		}
	});
angular
	.module('inspinia')
	.controller('createPermissionGroupsController', function($rootScope, $scope, $http){
		$scope.createPermissionGroupURL = 'permissions/groups';
		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});
	});
angular
	.module('inspinia')	
	.controller('creditController', ['$scope', '$rootScope', '$stateParams', '$http', function($scope, $rootScope, $stateParams, $http){
		$scope.changeCreditURL = "users/credit/" + $stateParams.id;
		$scope.creditURL = "api/users/credit/" + $stateParams.id;

		$http({
			url: $scope.creditURL,
			method: 'post'
		}).then(function(res){
			$rootScope.info = res.data;
		})
	}]);
angular
	.module('inspinia')
	.controller('editLawyerController', function($rootScope, $scope, $http, $stateParams){

		$scope.editLawyerUserURL = 'users/lawyer/'+$stateParams.id;

		$http({
			url: 'users/lawyer/'+$stateParams.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});


	});
angular
	.module('inspinia')
	.controller('editLineController', function($rootScope, $scope, $http, $stateParams){
		$scope.editId = $stateParams.line_id;
		$http({
			url: 'lines/'+$scope.editId+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});
		$scope.editLineURL = 'lines/'+$scope.editId;

		$http({
			url: 'api/users/agents',
			method: 'get'
		}).then(function(res){
			$scope.agents = res.data;
			setTimeout(function(){
				$(".chosen-select-agent").trigger('chosen:updated');
			}, 200)
		});

		$scope.selectUsers = function(){
			$http({
				url: 'api/users/users?agent='+$rootScope.info.agent_id,
				method: 'get'
			}).then(function(res){
				$scope.users = res.data;
				setTimeout(function(){
					$(".chosen-select-user").trigger('chosen:updated');
				}, 200)
			});
		}

		$scope.canBeRahyab = false;

		$scope.rahyabDetector = function(){
			if(!$rootScope.info.number) return;
			$scope.canBeRahyab = ($rootScope.info.number.match(/^50001/));
		}
	});
angular
	.module('inspinia')
	.controller('editPermissionGroupsController', function($rootScope, $scope, $http, $stateParams){
		$scope.id = $stateParams.group_id
		$scope.editPermissionGroupURL = 'permissions/groups/' + $scope.id;
		$http({
			method: 'get',
			url: 'permissions/groups/' + $scope.id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});
	});
angular
	.module('inspinia')	
	.controller('ajaxFormController', [
		'$scope', 
		'$rootScope',
		'$http',
		'$attrs',
		'$element', 
		'initialsFactory',
		'$modal',
		'SweetAlert',
		'$filter',
		function($scope, $rootScope, $http, $attrs, $element, initialsFactory, $modal, SweetAlert, $filter){
			$scope.ajaxInProcess = false;
			$rootScope.info = {};

			$rootScope.submitFunctionFromOutside = this.submit = function(e){
				if(typeof e != 'undefined'){
					e.preventDefault();
				}
				$scope.ajaxInProcess = true;
				jQuery('button[type=submit]').attr('disabled', 'disabled').addClass('disabled');
				var method = $attrs.method;
				var url = $attrs.action;
				var id = $attrs.id;
				var method_field = jQuery('#'+id).find('input[name=_method]').val();
				method = (method_field && method_field.length) ? method_field : method;
				if($rootScope.sendOnRootScope){
					$rootScope.info.sendOn = $rootScope.sendOnRootScope;
				}
				$http({
					method: method,
					url: url,
					data: $rootScope.info
				}).then(function successCallback(response){
					$scope.ajaxInProcess = false;
					jQuery('button[type=submit]').removeAttr('disabled').removeClass('disabled');
					if(response.data.result == 'success'){
						// $scope.formSuccess = response.data.message;
						SweetAlert.swal({ 
							title: '',
							text: response.data.message,
							type: 'success'
						});
						$scope.formErrors = false;
						if(response.data.reset){
							$rootScope.info = {};
							$rootScope.info.is_confirmed = 'not';
						}
						$rootScope.sendOnRootScope = null;
						$rootScope.$broadcast('successfulRequest', response.data.message);
						if(response.data.notify){
							SweetAlert.swal({ 
								title: '',
								text: $filter('translate')('SMS_TO_GROUP_SENT')
							});
						}
					} else {
						$scope.ajaxInProcess = false;
						jQuery('button[type=submit]').removeAttr('disabled').removeClass('disabled');
						if(response.data.result == 'exception'){
							SweetAlert.swal({ 
								title: '',
								text: [response.data.errors],
								type: 'warning'
							});
							// $scope.formErrors = [response.data.errors];
						} else {
							if(response.data.result == 'blacklist'){
								// alert(response.data.message);
								return;
							} else {
								if(response.data.result == 'group_confirm'){
									if($rootScope.info.is_confirmed && $rootScope.info.is_confirmed == 'not'){
										$rootScope.sms_confirmation_credit = response.data.totalCost;
										$rootScope.sms_confirmation_amount = response.data.numbers;
										$modal.open({
					                        templateUrl: 'views/common/sms_confirmation.html',
					                        controller: function($rootScope, $modalInstance){
					                        	$rootScope.cancelConfirmation = function(){
													$modalInstance.dismiss('cancel');
												}
												$rootScope.acceptConfirmation = function(){
													$rootScope.info.is_confirmed = 'on';
													$rootScope.submitFunctionFromOutside();
													$modalInstance.dismiss('cancel');
												}
					                        }
					                    });
									}
									return;
								}
							}
							// $scope.formErrors = response.data.errors;
							SweetAlert.swal({ 
								title: '',
								text: response.data.errors,
								type: 'warning'
							});
						}
						$scope.formSuccess = false;
					}
					$scope.watchForProcess();
				}, function errorCallback(response){
					jQuery('button[type=submit]').removeAttr('disabled').removeClass('disabled');
					$scope.watchForProcess();
					if(response.message){
						// $scope.formErrors = [response.message];
						SweetAlert.swal({ 
							title: '',
							text: [response.message],
							type: 'warning'
						});
					} else {
						if(response.status == 422){
							var errors_return = [];
							for(var key in response.data){
								var errors = response.data[key];
								for(error_key in errors){
									errors_return.push(errors[error_key]);
								}
							}
							// $scope.formErrors = errors_return;
							SweetAlert.swal({ 
								title: '',
								text: errors_return,
								type: 'warning'
							});
						} else {
							// $scope.formErrors = [response.data];
							SweetAlert.swal({ 
								title: '',
								text: [response.data],
								type: 'warning'
							});
						}
					}
					$scope.formSuccess = false;
				});

			};

			this.withValues = function(url){
				var initials = initialsFactory.get(url, []);
				initials.then(function(res){
					$rootScope.info = res.data;
				});
			}

			$scope.watchForProcess = function(){
				$scope.ajaxInProcess = false;
			}
		}
	]);
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
angular
	.module('inspinia')	
	.controller('profileController', ['$scope', '$rootScope', '$http', '$stateParams', function($scope, $rootScope, $http, $stateParams){
		$scope.canChangePassword = true;
		$rootScope.$watch('user', function(user){
			if(user.id){
				$scope.changePasswordURL = "users/profile/" + user.id + "/password";
				$scope.changeBirthdayURL = "users/profile/" + user.id + "/birth";
				$scope.changeInfoURL = 'users/profile';
				if(!$stateParams.id){
					$rootScope.info = user;
				} else {
					$scope.changeBirthdayURL = "users/profile/" + $stateParams.id + "/birth";
					$http({
						url: 'users/'+$stateParams.id,
						method: 'get'
					}).then(function(res){
						$rootScope.info = res.data;
					});
					$scope.canChangePassword = false;
					$scope.changeInfoURL = 'users/profile/'+$stateParams.id;
				}
			}
		}, true);

	}]);
angular
	.module('inspinia')
	.controller('settingsController', function($rootScope, $scope, $rootScope, $http){
		$rootScope.$watch('user', function(userId){
			$scope.changeSettingsURL = "users/setting/"+$rootScope.user.id;
		});

		$rootScope.info = [];

		$http({
			url: 'api/users/settings',
			method: 'post'
		}).then(function(res){
			$scope.userSettings = res.data;
			for(var key in res.data){
				$rootScope.info[key] = res.data[key];
			}
		});

		$http({
			url: 'api/info',
			method: 'get'
		}).then(function(res){
			$scope.apiKey = res.data;
		});

	});
angular.module('inspinia')
	.controller('userPermissionsController', function($rootScope, $scope, $http, $stateParams){
		$scope.userPermissionsURL = 'permissions/user/' + $stateParams.user_id;
		$scope.userPriceGroupURL = 'price-group/user/' + $stateParams.user_id;
		$http({
			method: 'get',
			url: 'permissions/user/' + $stateParams.user_id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info.permissions = res.data.permissions;
			$scope.username = res.data.username;
		});  

		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});

		$http({
			method: 'get',
			url: 'permissions/groups',
		}).then(function(res){
			$scope.permissionGroups = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.priceGroups = res.data;
		});

		$http({
			url: 'price-group/'+$stateParams.user_id,
			method: 'get'
		}).then(function(res){
			$scope.userPriceGroups = res.data;
		});

		$scope.permissionGroupChanged = function(){
			var permissions = JSON.parse($scope.selectedPermissionGroup);
			for(var key in permissions){
				if(permissions[key] != 0 && permissions[key] != 1) continue;
				$rootScope.info.permissions[key] = permissions[key];
			}
		}

		$scope.customCreditFluent = []

		$http({
			url: 'fluent-credits/'+$stateParams.user_id,
			method: 'get'
		}).then(function(res){
			$scope.fluentCredits = res.data;
			if(res.data.custom){
				$scope.customCreditFluent = res.data.custom;
				$rootScope.info.customCreditFluent = res.data.custom;
			}
		});

		$scope.removeFluentCustom = function(key){
			$scope.customCreditFluent.splice(key, 1);
		}

		$scope.addNewCustomCredit = function(key){
			$scope.customCreditFluent.push({
				ceil: '',
				fee: ''
			});
		}

		$scope.submitFluentCredit = function(){
			$rootScope.info.customCreditFluent = $scope.customCreditFluent;
		}
	});
angular
	.module('inspinia')
	.controller('usersController', function($rootScope, $scope, $http, DTOptionsBuilder, $modal, SweetAlert, $filter, DataTableService){

		$scope.selectedRows = [];
		$scope.selectedNumbers = [];

		// $http({
		// 	method: 'get',
		// 	url: 'users',
		// 	data: []
		// }).then(function(res){
		// 	$scope.users = res.data;
		// });

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
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
	 //        .withDOM('<"html5buttons"B>lTfgitp')
	 //        .withButtons([
	 //            {extend: 'copy'},
	 //            {extend: 'csv'},
	 //            {extend: 'excel', title: 'ExampleFile'},
	            

	 //            {extend: 'print',
	 //                customize: function (win){
	 //                    $(win.document.body).addClass('white-bg');
	 //                    $(win.document.body).css('font-size', '10px');

	 //                    $(win.document.body).find('table')
	 //                        .addClass('compact')
	 //                        .css('font-size', 'inherit');
	 //                }
	 //            }
	 //        ]);
	 
	$scope.dataTableColumns = [{
        data: 'username',
        name: 'username'
    }, {
        data: 'name',
        name: 'name'
    }, {
        data: 'mobile',
        name: 'mobile'
    }, {
        data: 'plan',
        name: 'plan'
    }, {
        data: 'parent_user',
        name: 'parent_user'
    }, {
        data: 'last_login',
        name: 'last_login'
    }, {
        data: 'actions',
        name: 'actions'
    }];

 	$rootScope.getTableData = function() {

        $scope.dtOptions = DataTableService.build('/users', $scope.dataTableColumns, $scope);

    }

    $rootScope.getTableData();

	});	
angular
	.module('inspinia')
	.controller('createAutoreplyController', function($rootScope, $scope, $http){
		
		$scope.createAutoreplyURL = 'autoreplies';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editAutoreplyController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editAutoreplyURL = 'autoreplies/'+$scope.id;

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'autoreplies/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('autorepliesController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
		
		$http({
			url: 'autoreplies',
			method: 'get'
		}).then(function(res){
			$scope.autoreplies = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'autoreplies/'+index,
				method: 'delete'
			});
			$scope.autoreplies[key].status = -1;
		};

		$scope.activate = function(key, index){
			$http({
				url: 'autoreplies/enable/'+index,
				method: 'put'
			});
			$scope.autoreplies[key].status = 0;
		};

		$scope.trash = function(key, index){
			$http({
				url: 'autoreplies/trash/'+index,
				method: 'delete'
			});
			$scope.autoreplies.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'autoreplies',
					method: 'get'
				}).then(function(res){
					$scope.autoreplies = res.data;
				});
	    	}, 500);
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createBlacklistController', function($rootScope, $scope){
		
		$scope.createBlacklistURL = 'blacklist';

	});	
angular
	.module('inspinia')
	.controller('editBlacklistController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editBlacklistURL = 'blacklist/'+$scope.id;

		$http({
			url: 'blacklist/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$scope.createBlacklistURL = 'blacklist';

	});	
angular
	.module('inspinia')
	.controller('blacklistController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
		
		$scope.getBlacklist = function()
		{
			$http({
				url: 'blacklist',
				method: 'get'
			}).then(function(res){
				$scope.blacklists = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getBlacklist();

		$scope.delete = function(key, index){
			$http({
				url: 'blacklist/'+index,
				method: 'delete'
			});
			$scope.blacklists.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	$scope.getBlacklist();
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createChargesController', function($rootScope, $scope){
		
		$scope.createChargesURL = 'charges';

		$scope.random = Math.random().toString(36).substring(13, 5);

	});	
angular
	.module('inspinia')
	.controller('editChargesController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editChargesURL = 'charges/'+$scope.id;

		$http({
			url: 'charges/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('chargesController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'charges',
			method: 'get'
		}).then(function(res){
			$scope.charges = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'charges/'+index
			});
			$scope.charges.splice(key, 1);
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
angular
	.module('inspinia')
	.controller('createCodereaderController', function($rootScope, $scope, $http){
		
		$scope.createCodereaderURL = 'codereaders';

		$scope.conditions = [{condition: '', reaction: ''}];

		$scope.addRow = function($event){
			$event.preventDefault();
			$scope.conditions.push({condition: '', reaction: ''});
		}

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editCodereaderController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editCodereaderURL = 'codereaders/'+$scope.id;

		$scope.conditions = [{condition: '', reaction: ''}];

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});


		$http({
			url: 'codereaders/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.conditions = res.data.conditions;
		});

		$scope.addRow = function($event){
			$event.preventDefault();
			$scope.conditions.push({condition: '', reaction: ''});
		}

	});	
angular
	.module('inspinia')
	.controller('codereaderController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
		
		$http({
			url: 'codereaders',
			method: 'get'
		}).then(function(res){
			$scope.codereaders = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'codereaders/'+index,
				method: 'delete'
			});
			$scope.codereaders[key].status = -1;
		};

		$scope.activate = function(key, index){
			$http({
				url: 'codereaders/enable/'+index,
				method: 'put'
			});
			$scope.codereaders[key].status = 0;
		};

		$scope.trash = function(key, index){
			$http({
				url: 'codereaders/trash/'+index,
				method: 'delete'
			});
			$scope.codereaders.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'codereaders',
					method: 'get'
				}).then(function(res){
					$scope.codereaders = res.data;
				});
	    	}, 500);
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createContactController', function($rootScope, $scope, $http, $modal, SweetAlert, $filter){
		
		$scope.createContactURL = 'contacts/contact';
		$scope.contacts = [{name: '', number: ''}];

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$scope.importContacts = function($event){
			$event.preventDefault();
			$modal.open({
                templateUrl: 'views/contacts/import_contacts.html',
            });
		}

		$rootScope.$on('fileUploaded', function(){
			SweetAlert.swal({
	            title: $filter('translate')('CONTACTS_IMPORTED'),
	        });
	        location.reload();
		});

		$scope.addNewContactRow = function($event){
			$event.preventDefault();
			$scope.contacts.push({name: '', number: ''});
		}

		$scope.removeContactRow = function($event, key){
			$event.preventDefault();
			$scope.contacts.splice(key, 1);
		}

	});	
angular
	.module('inspinia')
	.controller('editContactController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editContactURL = 'contacts/contact/'+$scope.id;

		$http({
			url: 'contacts/contact/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('contactGroupController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){

		$scope.selectedRows = [];

		// $scope.getGroups = function()
		// {
		// 	$http({
		// 		url: 'contacts/groups',
		// 		method: 'get'
		// 	}).then(function(res){
		// 		$scope.groups = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }
		// $scope.getGroups();

		$scope.delete = function(key, id){
	    	$http({
	    		method: 'delete',
	    		url: 'contacts/groups/'+id,
	    	});
	    	$scope.groups.splice(key, 1);
	    }

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getGroups();
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
		//     .withDOM('<"html5buttons"B>lTfgitp')
		//     .withButtons([
		//         {extend: 'copy'},
		//         {extend: 'csv'},
		//         {extend: 'excel', title: 'ExampleFile'},
		        
		
		//         {extend: 'print',
		//             customize: function (win){
		//                 $(win.document.body).addClass('white-bg');
		//                 $(win.document.body).css('font-size', '10px');
		
		//                 $(win.document.body).find('table')
		//                     .addClass('compact')
		//                     .css('font-size', 'inherit');
		//             }
		//         }
		//     ]);
		
		$scope.dataTableColumns = [
		{
	        data: 'select_box',
	        name: 'select_box',
	        sortable: false
	    },
		{
	        data: 'id',
	        name: 'id'
	    }, {
	        data: 'title',
	        name: 'title'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'actions',
	        name: 'actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/contacts/groups', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();
		
	});	
angular
	.module('inspinia')
	.controller('ContactController', function($rootScope, $scope, $http, $modal, DTOptionsBuilder, charactersFactory, DataTableService){

		$rootScope.contactNumber = '';
		$scope.messageCharacters = 0;

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		$rootScope.sendSingleSMSURL = 'sms/send/to';
		$rootScope.sendGroupSMSURL =  'sms/send/to/group';
		$scope.selectedRows = [];
		
		// $scope.getContacts = function()
		// {
		// 	$http({
		// 		url: 'contacts/contact',
		// 		method: 'get'
		// 	}).then(function(res){
		// 		$scope.contacts = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }

		// $scope.getContacts();

		$scope.delete = function(key, index, multi){
			$http({
				'method': 'delete',
				'url': 'contacts/contact/'+index
			});
		}

		$scope.sendMessage = function(key, contact){
			$modal.open({
                templateUrl: 'views/contacts/sendMessage.html',
            });
            $rootScope.contactNumber = contact.number;
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getContacts();
	    }

	    $scope.resendSelected = function(){
	    	var numbers = '';
	    	for(selected in $scope.selectedRows){
	    		numbers += selected + ',';
	    	}
	    	$rootScope.contactsNumbers = numbers;
	    	$scope.selectedRows = [];
	    	$modal.open({
                templateUrl: 'views/contacts/sendMessageGroup.html',
            });
	    }

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
  //       .withDOM('<"html5buttons"B>lTfgitp')
  //       .withButtons([
  //           {extend: 'copy'},
  //           {extend: 'csv'},
  //           {extend: 'excel', title: 'ExampleFile'},
            

  //           {extend: 'print',
  //               customize: function (win){
  //                   $(win.document.body).addClass('white-bg');
  //                   $(win.document.body).css('font-size', '10px');

  //                   $(win.document.body).find('table')
  //                       .addClass('compact')
  //                       .css('font-size', 'inherit');
  //               }
  //           }
  //       ]);
  		
  		$scope.dataTableColumns = [
  		{
	        data: 'select_box',
	        name: 'select_box',
	        sortable: false
	    },
  		{
	        data: 'id',
	        name: 'id'
	    }, {
	        data: 'group.title',
	        name: 'group'
	    }, {
	        data: 'name',
	        name: 'name'
	    }, {
	        data: 'number',
	        name: 'number'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'actions',
	        name: 'actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/contacts/contact', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();

        	jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').each(function(){
        			
				jQuery(this).trigger('click');
			});
        	});

	});	
angular
	.module('inspinia')
	.controller('trashContactController', function($rootScope, $scope, $http, DTOptionsBuilder, DataTableService){
		
		$scope.selectedRows = [];

		// $scope.getContacts = function()
		// {
		// 	$http({
		// 		method: 'get',
		// 		url: 'contacts/trash'
		// 	}).then(function(res){
		// 		$scope.contacts = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }	
		// $scope.getContacts();

		$scope.restore = function(key, index){
			$http({
				url: 'contacts/trash/restore/'+index,
				method: 'post'
			});
			$scope.contacts.splice(key, 1);
		}

		$scope.explode = function(key, index){
			$http({
				url: 'contacts/trash/explode/'+index,
				method: 'post'
			});
			$scope.contacts.splice(key, 1);
		}


		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.explode($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getContacts();
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});


		// $scope.dtOptions = DTOptionsBuilder.newOptions()
		//     .withDOM('<"html5buttons"B>lTfgitp')
		//     .withButtons([
		//         {extend: 'copy'},
		//         {extend: 'csv'},
		//         {extend: 'excel', title: 'ExampleFile'},
		        
		
		//         {extend: 'print',
		//             customize: function (win){
		//                 $(win.document.body).addClass('white-bg');
		//                 $(win.document.body).css('font-size', '10px');
		
		//                 $(win.document.body).find('table')
		//                     .addClass('compact')
		//                     .css('font-size', 'inherit');
		//             }
		//         }
		//     ]);

		$scope.dataTableColumns = [
		{
			data: 'select_box',
			name: 'select_box',
			sortable: false
		},
		{
	        data: 'id',
	        name: 'id'
	    }, {
	        data: 'name',
	        name: 'name'
	    }, {
	        data: 'number',
	        name: 'number'
	    }, {
	        data: 'description',
	        name: 'description'
	    }, {
	        data: 'trash_actions',
	        name: 'trash_actions'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/contacts/trash', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();
	});	
angular
	.module('inspinia')
	.controller('customizationController', function($rootScope, $scope, $http){
		
		$rootScope.$watch('user.id', function(res){	
			if(typeof res == 'undefined') return;
			$scope.customizationURL = 'customization/'+$rootScope.user.id;

			$http({
				url: 'customization/' + $rootScope.user.id + '/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			});
		});

	});	
angular
	.module('inspinia')
	.controller('dashboardController', function($rootScope, $scope, $http){

		$rootScope.info = [];
		
		$http({
			url: 'dashboard',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.generateChart();
		});

		$http({
			url: 'news',
			method: 'get'
		}).then(function(res){
			$scope.dashboardNews = res.data;
		});

		$http({
			url: 'support/tickets/dashboard',
			method: 'get'
		}).then(function(res){
			$scope.dashboardTickets = res.data;
		});

		$scope.generateChart = function(){
		    var dataset = [
		        {
		            label: "Number of messages",
		            grow:{stepMode:"linear"},
		            data: $rootScope.info.messages_chart,
		            color: "#1ab394",
		            bars: {
		                show: true,
		                align: "center",
		                barWidth: 24 * 60 * 60 * 600,
		                lineWidth: 0
		            }

		        },
		    ];

		    var options = {
		        grid: {
		            hoverable: true,
		            clickable: true,
		            tickColor: "#d5d5d5",
		            borderWidth: 0,
		            color: '#d5d5d5'
		        },
		        colors: ["#1ab394", "#464f88"],
		        tooltip: true,
		        xaxis: {
		            mode: "time",
		            tickSize: [3, "day"],
		            tickLength: 0,
		            axisLabel: "Date",
		            axisLabelUseCanvas: true,
		            axisLabelFontSizePixels: 12,
		            axisLabelFontFamily: 'Arial',
		            axisLabelPadding: 10,
		            color: "#d5d5d5"
		        },
		        yaxes: [
		            {
		                position: "left",
		                max: $rootScope.info.messages_chart_max_val,
		                color: "#d5d5d5",
		                axisLabelUseCanvas: true,
		                axisLabelFontSizePixels: 12,
		                axisLabelFontFamily: 'Arial',
		                axisLabelPadding: 3
		            },
		            {
		                position: "right",
		                color: "#d5d5d5",
		                axisLabelUseCanvas: true,
		                axisLabelFontSizePixels: 12,
		                axisLabelFontFamily: ' Arial',
		                axisLabelPadding: 67
		            }
		        ],
		        legend: {
		            noColumns: 1,
		            labelBoxBorderColor: "#d5d5d5",
		            position: "nw"
		        }

		    };

		    /**
		     * Definition of variables
		     * Flot chart
		     */
		    $scope.flotData = dataset;
		    $scope.flotOptions = options;
		}

	});	
angular
	.module('inspinia')
	.controller('createFAQSController', function($rootScope, $scope){
		
		$scope.createFAQSURL = 'faqs';

	});	
angular
	.module('inspinia')
	.controller('editFAQSController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFAQSURL = 'faqs/'+$scope.id;

		$http({
			url: 'faqs/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('faqsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'faqs',
			method: 'get'
		}).then(function(res){
			$scope.faqs = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'faqs/'+index
			});
			$scope.faqs.splice(key, 1);
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
angular
	.module('inspinia')
	.controller('createFilteringsController', function($rootScope, $scope){
		
		$scope.createFilteringsURL = 'filterings';

	});	
angular
	.module('inspinia')
	.controller('editFilteringsController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFilteringsURL = 'filterings/'+$scope.id;

		$http({
			url: 'filterings/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('filteringsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'filterings',
			method: 'get'
		}).then(function(res){
			$scope.filterings = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'filterings/'+index
			});
			$scope.filterings.splice(key, 1);
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



angular
	.module('inspinia')
	.controller('ourServicesController', function($rootScope, $scope, $http){

		$scope.ourServices = '';

		$http({
			url: 'customization/our-services',
			method: 'get'
		}).then(function(res){
			$scope.ourServices = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('financialReportController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.transactions = [];

		$http({
			url: 'financial/report',
			method: 'get'
		}).then(function(res){
			$scope.transactions = res.data;
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

angular
	.module('inspinia')
	.controller('submittedBillsController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$http({
			url: '/financial/bill/report',
			method: 'get'
		}).then(function(res){
			$scope.bills = res.data;
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
angular
	.module('inspinia')
	.controller('transactionsController', function($rootScope, $scope, $http, DTOptionsBuilder){
			
		$scope.transactions = [];

		$http({
			url: 'financial/transactions',
			method: 'get'
		}).then(function(res){
			$scope.transactions = res.data;
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
angular
	.module('inspinia')
	.controller('createFluentCreditController', function($rootScope, $scope, $http){
		
		$scope.createFluentCreditURL = 'fluent-credits';

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		})

	});	
angular
	.module('inspinia')
	.controller('editFluentCreditController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFluentCreditURL = 'fluent-credits/'+$scope.id;

		$http({
			url: 'fluent-credits/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		})

	});	
angular
	.module('inspinia')
	.controller('fluentCreditController', function($scope, $http, DTOptionsBuilder){

		$scope.fluentCredits = [];
		
		$http({
			url: 'fluent-credits',
			method: 'get'
		}).then(function(res){
			$scope.fluentCredits = res.data;
		});

		$scope.delete = function(key, index){
			$scope.fluentCredits.splice(key, 1);
			$http({
				url: 'fluent-credits/'+index,
				method: 'delete'
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
angular
	.module('inspinia')
	.controller('createLanguageController', function($rootScope, $scope, $http){
		
		$scope.createLanguageURL = 'languages';

		$http({
			url: 'languages/create', 
			method: 'get'
		}).then(function(res){
			$scope.items = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editLanguageController', function($rootScope, $scope, $http, $stateParams){

		$scope.key = $stateParams.id;

		$scope.editLanguageURL = 'languages/'+$scope.key;
		
		$http({
			url: 'languages/'+$scope.key+'/edit',
			method: 'get'
		}).then(function(res){
			$scope.items = $rootScope.info = res.data;
			$rootScope.info.titleOfLanguage = $scope.key;
			
		});

	});	
angular
	.module('inspinia')
	.controller('languagesController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.languages = [];
		
		$http({
			url: 'languages',
			method: 'get'
		}).then(function(res){
			$scope.languages = res.data;
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
angular
	.module('inspinia')
	.controller('createLinePatternController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.createLinePatternURL = 'line-patterns';

		$http({
			url: 'api/operators',
			method: 'post'
		}).then(function(res){
			$scope.operators = res.data;
		});

		if($stateParams.id){
			$http({
				url: 'line-patterns/'+$stateParams.id+'/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			})
		}

	});	
angular
	.module('inspinia')
	.controller('linePatternController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'line-patterns',
			method: 'get'
		}).then(function(res){
			$scope.linePatterns = res.data;
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
angular
	.module('inspinia')
	.controller('importLineController', function($scope){
		
		$scope.importLineURL = 'lines/import';

	});	

angular
	.module('inspinia')
	.controller('marketingCodeController', function($rootScope, $scope, $http){
		$http({
			url: 'marketing-codes',
			method: 'get'
		}).then(function(res){
			$scope.marketingCode = res.data;
			$rootScope.info = res.data;
			$scope.createMarketingPolicyURL = 'marketing-codes/'+$rootScope.user.id;
		});

		
	});
angular
	.module('inspinia')
	.controller('createModuleController', function($rootScope, $scope, $http){
		
		$scope.createTransferToEmailURL = 'modules';

		$http({
			url: 'modules/api',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editModuleController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editTransferToEmailURL = 'modules/'+$scope.id;

		$http({
			url: 'modules/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.module;
			$scope.modules = res.data.modules;
		});

	});	
angular
	.module('inspinia')
	.controller('moduleController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'modules',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

		$scope.disable = function(key, index){
			$http({
				method: 'delete',
				url: 'modules/'+index
			});
			$scope.modules[key].status = -1;
		}

		$scope.enable = function(key, index){
			$http({
				method: 'put',
				url: 'modules/enable/'+index
			});
			$scope.modules[key].status = 0;
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
angular
	.module('inspinia')
	.controller('createNewsController', function($rootScope, $scope, $http){
		$scope.createNewsURL = 'news';
	});	
angular
	.module('inspinia')
	.controller('editNewsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.editNewsURL = 'news/'+$stateParams.news_id;
		$http({
			method: 'get',
			url: 'news/'+$stateParams.news_id+'/edit'
		}).then(function(res){
			$rootScope.info = res.data;
		});
	});	
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
angular
	.module('inspinia')
	.controller('createNumbersBankController', function($rootScope, $scope, $http, $stateParams){
		
  		$scope.createNumbersBankURL = 'numbers-bank/define';

  		if($stateParams.id){
  			$http({
  				url: 'numbers-bank/'+$stateParams.id+'/edit',
  				method: 'get'
  			}).then(function(res){
  				$rootScope.info = res.data;
  			})
  		}

	});	
angular
	.module('inspinia')
	.controller('numbersBankController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$scope.getNumbers = function()
		{
			$http({
				url: 'numbers-bank',
				method: 'get'
			}).then(function(res){
				$scope.numbers = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getNumbers();

		$scope.delete = function(key, id)
		{
			$http({
				url: 'numbers-bank/'+id,
				method: 'delete'
			}).then(function(){
				$http({
					url: 'numbers-bank',
					method: 'get'
				}).then(function(res){
					$scope.numbers = res.data;
				});
			});
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	$scope.getNumbers();
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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

angular
	.module('inspinia')
	.controller('createOccupationsController', function($rootScope, $scope){
		
		$scope.createOccupationsURL = 'occupations';

	});	
angular
	.module('inspinia')
	.controller('editOccupationsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editOccupationsURL = 'occupations/'+$scope.id;

		$http({
			url: 'occupations/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('occupationsController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$scope.getOccupations = function()
		{
			$http({
				method: 'get',
				url: 'occupations/api'
			}).then(function(res){
				$scope.occupations = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getOccupations();

		$scope.delete = function(key, id, many){
			$http({
				method: 'delete',
				url: 'occupations/'+id
			});
			if (many == false) {
				$scope.occupations.splice(key, 1);
			}
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	$scope.getOccupations();
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createPlansController', function($rootScope, $scope, $http){
		
		$scope.createPlansURL = 'plans';

		$http({
			url: 'plans/create',
			method: 'get'
		}).then(function(res){
			$scope.data = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editPlansController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editPlansURL = 'plans/'+$scope.id;

		$http({
			url: 'plans/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.plan;
			$scope.data = res.data;
		});

		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

	});	
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
angular
	.module('inspinia')
	.controller('createPollController', function($rootScope, $scope, $http){
		
		$scope.createPollURL = 'polls';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.answers = [{answer: ''}];

		$scope.addAnswer = function($event){
			$event.preventDefault();
			$scope.answers.push({answer: ''});
		}

	});	
angular
	.module('inspinia')
	.controller('editPollController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editPollURL = 'polls/'+$scope.id;

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'polls/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.answers = res.data.answer;
		});

		$scope.addAnswer = function($event){
			$event.preventDefault();
			$scope.answers.push('');
		}

	});	
angular
	.module('inspinia')
	.controller('pollsController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];

		
		$http({
			url: 'polls',
			method: 'get'
		}).then(function(res){
			$scope.polls = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'polls/'+index
			});
			$scope.polls.splice(key, 1);
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

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'polls',
					method: 'get'
				}).then(function(res){
					$scope.polls = res.data;
				});
	    	}, 500);
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});
	});	
angular
	.module('inspinia')
	.controller('showPollController', function($rootScope, $scope, $http, $stateParams){

		$http({
			url: 'polls/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.flotPieData = res.data;
		});

	    /**
	     * Pie Chart Data
	     */
	    $scope.flotPieData = [
	       
	    ];

	    /**
	     * Pie Chart Options
	     */
	    $scope.flotPieOptions = {
	        series: {
	            pie: {
	                show: true
	            }
	        },
	        grid: {
	            hoverable: true
	        },
	        tooltip: true,
	        tooltipOpts: {
	            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
	            shifts: {
	                x: 20,
	                y: 0
	            },
	            defaultTheme: false
	        }
	    };


	});
angular
	.module('inspinia')
	.controller('createPostalCodeController', function($rootScope, $scope, $http){
		
		$scope.createPostalCodeURL = 'postal-code';

	});	
angular
	.module('inspinia')
	.controller('editPostalCodeController', function($rootScope, $scope, $http, $stateParams){
			
		$scope.id = $stateParams.id;
			
		$scope.editPostalCodeURL = 'postal-code/'+$scope.id;

		$http({
			method: 'get',
			url: 'postal-code/'+$scope.id+'/edit'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('postalCodeController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$scope.getPostalCodes = function()
		{
			$http({
				url: 'postal-code/api',
				method: 'get'
			}).then(function(res){
				$scope.postalCodes = res.data;
				$scope.selectedRows = [];
			});
		}
		$scope.getPostalCodes();

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'postal-code/'+index
			});
			$scope.postalCodes.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	$scope.getPostalCodes();
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createPreTextController', function($rootScope, $scope, $http){
		
		$scope.createPreTextURL = 'pre-texts';

		$http({
			url: 'pre-texts/api',
			method: 'get',
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editPreTextController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;
		$scope.editPreTextURL = 'pre-texts/'+$scope.id;

		$http({
			url: 'pre-texts/'+$scope.id+'/edit',
			method: 'get',
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			url: 'pre-texts/api',
			method: 'get',
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('preTextController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
			
		$http({
			url: 'pre-texts',
			method: 'get'
		}).then(function(res){
			$scope.preTexts = res.data;
		});

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'pre-texts',
					method: 'get'
				}).then(function(res){
					$scope.preTexts = res.data;
				});
	    	}, 500);
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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

	    $scope.delete = function(key, id){
	    	$http({
	    		url: 'pre-texts/' + id,
	    		method: 'delete'
	    	});
	    	$scope.preTexts.splice(key, 1);
	    }

	});	
angular
	.module('inspinia')
	.controller('createPriceGroupController', function($rootScope, $scope, $http){

		$scope.savePriceGroupURL = 'price-group';

		$http({
			method: 'get', 
			'url': 'price-group/api'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$http({
			method: 'get', 
			'url': 'price-group/create'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});
angular
	.module('inspinia')
	.controller('editPriceGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;
		$scope.editPriceGroupURL = 'price-group/' + $scope.id;
		$http({
			method: 'get',
			url: 'price-group/' + $scope.id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			method: 'get', 
			'url': 'price-group/api'
		}).then(function(res){
			$scope.groups = res.data;
		});
	});	
angular
	.module('inspinia')
	.controller('priceGroupHomeController', function($rootScope, $scope, $filter, $http, DTOptionsBuilder, SweetAlert){
		
		$http({
			url: 'price-group',
			'method': 'get'
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

	    $scope.delete = function(key, group){
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
			    		url: 'price-group/'+group
			    	}).then(function(){
			    		$scope.groups.splice(key,1);
			    	});
			    }
			});
	    }

	});	
angular
	.module('inspinia')
	.controller('smsReceiversEditController', function($rootScope, $scope, $http, $stateParams){

		$scope.editReceiveSettingURL = 'receive-sms/'+$stateParams.id;

		$http({
			url: 'receive-sms/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});
angular
	.module('inspinia')
	.controller('smsReceiversController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];

		$scope.lines = $scope.editURL = $scope.editNumber = [];
		$scope.editURLID = '';
		$scope.editNumberID = '';

		$http({
			url: 'receive-sms',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.editRow = function(key, index){
			$scope.editURLID = index;
			$scope.editNumberID = index;
		}

		$scope.delete = function(id){
			$http({
				url: 'receive-sms/'+id,
				method: 'delete'
			}).then(function(){
				$http({
					url: 'receive-sms',
					method: 'get'
				}).then(function(res){
					$scope.lines = res.data;
				});
			});
		}

		$scope.saveEditURL = function(line){
			$scope.editURL[line.id] = $scope.editURL[line.id]+'?from=FROM&to=TO&text=TEXT';
			$http({
				url: 'receive-sms/'+$scope.editURLID,
				method: 'put',
				data: {
					url: $scope.editURL[line.id],
					receiver_number: $scope.editNumber[line.id]
				}
			});
			line.receivers.redirect_url = $scope.editURL[line.id];
			$scope.editURLID = '';
			$scope.editNumberID = '';
			// $scope.editURL[line.id] = '';
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'receive-sms',
					method: 'get'
				}).then(function(res){
					$scope.lines = res.data;
				});
	    	}, 500);
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('sendFromMobileCreateController', function($scope){
		
		$scope.createSendFromMobileURL = 'send-from-mobile';

	});	
angular
	.module('inspinia')
	.controller('sendFromMobileHomeController', function($scope, $http, DTOptionsBuilder){
		$http({
			url: 'send-from-mobile',
			method: 'get'
		}).then(function(res){
			$scope.sendFromMobiles = res.data; 
		});

		$scope.delete = function(key, id){
			$http({
				url: 'send-from-mobile/'+id,
				method: 'delete'
			});
			$http({
				url: 'send-from-mobile',
				method: 'get'
			}).then(function(res){
				$scope.sendFromMobiles = res.data; 
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
angular
	.module('inspinia')
	.controller('checkoutController', function($rootScope, $scope, $http){

		$scope.selectedGate = '';
		$scope.movingInProgress = false;
		$scope.movingURL = 'financial/checkout/moving-to-gateway';
		
		$http({
			url: 'financial/checkout/gateways',
			method: 'get'
		}).then(function(res){
			$scope.gateways = res.data;
		});

		$scope.gatewaySelected = function(gateway){
			$scope.selectedGate = gateway;
			var id = 'gateway-'+gateway;
			jQuery('#'+id).trigger('submit');
		}

		// $scope.goToGateway = function(){
		// 	$scope.movingInProgress = true;
		// 	$http({
		// 		url: 'financial/checkout/moving-to-gateway',
		// 		method: 'post',
		// 		data: {
		// 			gateway: $scope.selectedGate,
		// 		}
		// 	}).then(function(res){
		// 		window.location.href = res.data.url;
		// 	});
		// }

	});	
angular
	.module('inspinia')
	.controller('invoiceController', function($rootScope, $scope, $http){
		
		$http({
			url: 'financial/invoice',
			mehtod: 'get'
		}).then(function(res){
			$scope.invoice = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'shop/modules/remove-from-invoice/'+index,
				method: 'delete'
			});
			$http({
				url: 'financial/invoice',
				mehtod: 'get'
			}).then(function(res){
				$scope.invoice = res.data;
			});
		}

		$scope.checkout = function(){
			$http({
				url: 'financial/invoice/offline-checkout',
				method: 'post'
			}).then(function(res){
				$scope.shopping_result = res.data;
				if(res.data.result == 'success'){
					$http({
						url: 'financial/invoice',
						mehtod: 'get'
					}).then(function(res){
						$scope.invoice = res.data;
					});
				}
			});
		}

	});	
angular
	.module('inspinia')
	.controller('lineExtensionController', function($rootScope, $scope, $http, DTOptionsBuilder, SweetAlert, $filter){

		$scope.addedLines = [];
		
		$http({
			url: 'shop/lines/extension/list',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.buy = function(key, line){
			$scope.addedLines.push(key);
			SweetAlert.swal({ 
				title: '',
				text: $filter('translate')('LINE_ADDED_TO_SHOPPING_INVOICE')
			});
			$http({
				url: 'shop/lines/add-to-invoice',
				method: 'post',
				data: {
					line_id: line.id
				}
			})
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
angular
	.module('inspinia')
	.controller('shopLinesController', function($rootScope, $scope, $http, DTOptionsBuilder, SweetAlert, $filter){

		$scope.addedLines = [];
		
		$http({
			url: 'shop/lines/list',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.buy = function(key, line){
			$scope.addedLines.push(key);
			SweetAlert.swal({ 
				title: '',
				text: $filter('translate')('LINE_ADDED_TO_SHOPPING_INVOICE')
			});
			$http({
				url: 'shop/lines/add-to-invoice',
				method: 'post',
				data: {
					line_id: line.id
				}
			})
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
angular
	.module('inspinia')
	.controller('shopModulesController', function($rootScope, $scope, $http, DTOptionsBuilder, notify, $filter){

		$scope.addedModules = [];
		
		$http({
			url: 'shop/modules/list',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

		$scope.buy = function(key, index){
			$scope.addedModules.push(key);
			notify({ message: $filter('translate')('MODULE_ADDED_TO_SHOPPING_INVOICE'), classes: 'alert-info', templateUrl: 'views/common/notify.html'});
			$http({
				url: 'shop/modules/add-to-invoice',
				method: 'post',
				data: {
					module_id: index
				}
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
angular
	.module('inspinia')
	.controller('shopSpecialsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'shop/specials/list', 
			method: 'get'
		}).then(function(res){
			$scope.specials = res.data;
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
angular
	.module('inspinia')
	.controller('upgradeCreditController', function($rootScope, $scope, $http, $state, SweetAlert){
		
		$scope.upgradeByCodeURL = 'shop/charge/upgrade/code';
		$scope.fluentCredits = [];

		$http({
			url: 'shop/charge/upgrade/fluent-credits',
			method: 'get'
		}).then(function(res){
			for(ceil in res.data){
				$scope.fluentCredits[ceil] = res.data[ceil];
			}
		});

		$scope.submitChargingBill = function(){
			$http({
				url: 'shop/charge/upgrade/cash',
				method: 'post',
				data: {
					credit: $rootScope.info.credit
				}
			}).then(function(res){
				if(res.data.result == 'success'){
					$state.go('app.shop.checkout');
				} else {
					SweetAlert.swal({ 
						title: '',
						text: res.data.errors,
						type: 'warning'
					});
				}
			}, function(err){
				SweetAlert.swal({ 
					title: '',
					text: err.data.credit[0],
					type: 'warning'
				});
			})
		}

		$scope.calculateSMSFee = function(credit){
			var fee = 0;
			credit = parseInt(credit);
			var length = $scope.fluentCredits.length;
			for(ceil in $scope.fluentCredits){
				if(credit <= ceil) {
					fee = parseInt($scope.fluentCredits[ceil]);
					break;
				} else {
					fee = parseInt($scope.fluentCredits[length-1]);
				}
			}
			$scope.smsFee = fee;
		}

	});	
angular
	.module('inspinia')
	.controller('sendBrandSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){
		
		$scope.sendBrandSMSURL = 'sms/send/to/brand';

		$scope.groups = [];
		$scope.contacts = [];
		$scope.selectedGroup = null;

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


		$scope.messageCharacters = 0;
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
angular
	.module('inspinia')
	.controller('sendCitySMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.province = $scope.city = null;
		
		$scope.messageCharacters = 0;
		// $scope.maxSendingCount = 0;

		$scope.sendCitySMSURL = 'sms/send/to/city';

		$scope.provinces = [];

		$scope.cityChanged = function(city){
			$scope.city = city;
		}

		$scope.provinceChanged = function(province){
			$scope.province = province.id;
		}

		$scope.cityChanged = function(city){
			$http({
				url: 'numbers-bank/count/'+city,
				method: 'get'
			}).then(function(res){
				$scope.sendingCountRelative = res.data.ranges;
				$scope.maxSendingCount = res.data.max;
			});
		}

		$http({
			url: 'numbers-bank/cities',
			method: 'post'
		}).then(function(res){
			$scope.provinces = res.data;
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
				$scope.provinceChanged($rootScope.info.province);
				$scope.cityChanged($rootScope.info.city);
			});
		}

	});
angular
	.module('inspinia')
	.controller('sendGenderSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.messageCharacters = 0;
		$scope.availableNumbers = 0;
		
		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}
		
		$scope.sendGenderSMSURL = 'sms/send/to/gender';

		if($stateParams.id){
			$http({
				url: 'sms/input/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
				$scope.calculateCharacters($rootScope.info.text);
			});
		}

		$scope.provinces = [];

		$http({
			url: 'api/rahyabbulk/provinces',
			method: 'get'
		}).then(function(res){
			$scope.provinces = res.data;
		});

		$scope.getCities = function(){
			$http({
				url: 'api/rahyabbulk/cities?province='+$rootScope.info.province,
				method: 'get',
			}).then(function(res){
				$scope.cities = res.data;
			});
		}

		$scope.agesFrom = [];
		$scope.agesTo = [];
		for(var i=1320;i<=1380;i++){
			$scope.agesFrom.push(i);
		}

		$scope.ageFromChanged = function(){
			for(var i=$rootScope.info.fromAge;i<=1380;i++){
				$scope.agesTo.push(i);
			}
		}

		$scope.preNumberInvalid = false;
		$scope.checkPreNumber = function(){
			$scope.preNumberInvalid = (!$rootScope.info.preNumber.match(/^91[1-9]{0,2}$/)) ? true : false;
		}

		$scope.calculateMessageCount = function($event){
			$event.preventDefault();
			$http({
				url: 'api/rahyabbulk/count',
				method: 'post',
				data: $rootScope.info
			}).then(function(res){
				$scope.availableNumbers = res.data;
			})
		}

	});	
angular
	.module('inspinia')
	.controller('showGenderSMSList', function($scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];

		$http({
			url: 'sms/list/gender',
			method: 'get'
		}).then(function(res){
			$scope.messages = res.data;
		});

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'sms/report',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	}, 500);
	    }

	    $scope.delete = function(id){
	    	$http({
	    		url: 'sms/gender/remove/'+id,
	    		method: 'delete'
	    	}).then(function(){
	    		$http({
					url: 'sms/list/gender',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	});
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('sendInternationalSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){
		
		$scope.sendInternationalSMSURL = 'sms/send/to/international';

		
		$scope.messageCharacters = 0;
		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		$scope.groups = [];
		$scope.contacts = [];
		$scope.selectedGroup = null;

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
angular
    .module('inspinia')
    .controller('sendMapSMSController', function($rootScope, $scope, $http, $timeout) {

        $scope.sendMessages = function() {
            $http({
                url: 'sms/send/to/map',
                method: 'post',
                data: {
                    polygon: $rootScope.info.selectedPolygon,
                    amount: $rootScope.info.amount,
                    text: $rootScope.info.text,
                    sendOn: $rootScope.info.sendOn,
                    line: $rootScope.info.line
                }
            }).then(function(res) {
                // alert(res.data.message);
            });
        }
    });
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
angular
	.module('inspinia')
	.controller('sendPostalCodeSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		
		$scope.messageCharacters = 0;

		$scope.sendPostalCodeSMSURL = 'sms/send/to/postal-code';

		$scope.postalCodes = [];

		$scope.province = $scope.city = null;
		$scope.provinces = [];

		$scope.cityChanged = function(city){
			$scope.city = city;
			$http({
				url: 'postal-code?city='+city,
				method: 'get',
			}).then(function(res){
				$scope.postalCodes = res.data
			});
		}

		$scope.provinceChanged = function(province){
			$scope.province = province.id;
		}
		$http({
			url: 'numbers-bank/cities',
			method: 'post'
		}).then(function(res){
			$scope.provinces = res.data;
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
				$scope.cityChanged($rootScope.info.city);
			});
		}

	});
angular
	.module('inspinia')
	.controller('receivedSMSController', function($rootScope, $scope, $http, $modal, DTOptionsBuilder, DataTableService){

		$scope.selectedRows = [];

		// $scope.getMessages = function()
		// {
		// 	$http({
		// 		url: 'sms/report/received',
		// 		method: 'get'
		// 	}).then(function(res){
		// 		$scope.messages = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }

		// $scope.getMessages();

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
	 //        .withDOM('<"html5buttons"B>lTfgitp')
	 //        .withButtons([
	 //            {extend: 'copy'},
	 //            {extend: 'csv'},
	 //            {extend: 'excel', title: 'ExampleFile'},
	            

	 //            {extend: 'print',
	 //                customize: function (win){
	 //                    $(win.document.body).addClass('white-bg');
	 //                    $(win.document.body).css('font-size', '10px');

	 //                    $(win.document.body).find('table')
	 //                        .addClass('compact')
	 //                        .css('font-size', 'inherit');
	 //                }
	 //            }
	 //        ]);
	 	
	 	$scope.dataTableColumns = [
	 	{
	        data: 'select_box',
	        name: 'select_box',
	        sortable: false
	    }, {
	        data: 'text',
	        name: 'text'
	    }, {
	        data: 'created_at',
	        name: 'created_at'
	    }, {
	        data: 'from',
	        name: 'from'
	    }, {
	        data: 'to',
	        name: 'to'
	    }, {
	        data: 'forward',
	        name: 'forward'
	    }, {
	        data: 'reply',
	        name: 'reply'
	    }, {
	        data: 'delete',
	        name: 'delete'
	    }];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/sms/report/received', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();

	    $scope.forward = function(event, message){
	    	$rootScope.messageToForward = message;
	    	$modal.open({
	    		templateUrl: 'views/sms/forward-modal.html',
	    		controller: 'forwardMessageController'
	    	});
	    }

	    $scope.reply = function(event, message){
	    	$rootScope.messageToReply = message;
	    	$modal.open({
	    		templateUrl: 'views/sms/reply-modal.html',
	    		controller: 'replyMessageController'
	    	});
	    }

	    $scope.delete = function(key, index, multi){
	    	$http({
				'method': 'delete',
				'url': 'sms/report/received/'+index
			}).then(function () {
				$scope.getMessages();
			});
	    }

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getMessages();
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

	})
	.controller('forwardMessageController', function($rootScope, $scope, $http, $modalInstance){
		$scope.message = $rootScope.messageToForward;

	    $rootScope.$on('successfulRequest', function(){
	    	$modalInstance.close();
	    });

	    $scope.sendSingleSMSURL = 'sms/send/to';

	    $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	    };
	})
	.controller('replyMessageController', function($rootScope, $scope, $http, $modalInstance){
		$scope.message = $rootScope.messageToReply;

	    $rootScope.$on('successfulRequest', function(){
	    	$modalInstance.close();
	    });

	    $scope.sendSingleSMSURL = 'sms/send/to';

	    $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	    };
	});
angular
	.module('inspinia')
	.controller('reportSMSController', function($rootScope, $scope, $http, DTOptionsBuilder, $modal, $state, $ocLazyLoad, DataTableService){
		
		$scope.messages = [];
		$rootScope.groupMessages = [];
		$scope.selectedRows = [];

		// $scope.getMessages = function(){
		// 	$http({
		// 		url: 'sms/report',
		// 		method: 'get'
		// 	}).then(function(res){
		// 		$scope.messages = res.data;
		// 		$scope.selectedRows = [];
		// 	});
		// }
		// $scope.getMessages();

		$scope.resendProcessing = false;

		$scope.retry = function(){
			$http({
				url: 'sms/retry',
				method: 'post'
			});
			$scope.resendProcessing = true;
		}

		// $scope.dtOptions = DTOptionsBuilder.newOptions()
	 //        .withDOM('<"html5buttons"B>lTfgitp')
	 //        .withButtons([
	 //            {extend: 'copy'},
	 //            {extend: 'csv'},
	 //            {extend: 'excel', title: 'ExampleFile'},
	            

	 //            {extend: 'print',
	 //                customize: function (win){
	 //                    $(win.document.body).addClass('white-bg');
	 //                    $(win.document.body).css('font-size', '10px');

	 //                    $(win.document.body).find('table')
	 //                        .addClass('compact')
	 //                        .css('font-size', 'inherit');
	 //                }
	 //            }
	 //        ]);
	 
	 	$scope.dataTableColumns = [
	 		{
	 			data: 'selectBox',
	 			name: 'selectBox',
	 			sortable: false
	 		},
		 	{
		        data: 'id',
		        name: 'id'
		    }, {
		        data: 'text',
		        name: 'text'
		    }, {
		        data: 'created_at',
		        name: 'created_at'
		    }, {
		        data: 'sms_status',
		        name: 'sms_status'
		    }, {
		        data: 'line.number',
		        name: 'line',
		        sortable: false
		    }, {
		        data: 'sms_type',
		        name: 'sms_type'
		    }, {
		        data: 'numbers',
		        name: 'numbers'
		    }, {
		        data: 'amount',
		        name: 'amount'
		    }, {
		        data: 'actions',
		        name: 'actions'
		    }
	    ];

	 	$rootScope.getTableData = function() {

	        $scope.dtOptions = DataTableService.build('/sms/report', $scope.dataTableColumns, $scope);

	    }

	    $rootScope.getTableData();

	    $scope.delete = function(key, message_id){
	    	$http({
	    		method: 'delete',
	    		url: 'sms/delete/sent/'+message_id,
	    	});
	    }

	    $scope.resend = function(queueName, inputId){
	    	if(queueName == '') return;
	    	var route = queueName.replace('SMS', '', queueName);
	    	$state.go('app.sms.'+route+'Resend', {id: inputId});
	    	// $http({
	    	// 	method: 'post',
	    	// 	url: 'sms/resend',
	    	// 	data: message
	    	// }).then(function(){
	    	// 	$scope.getMessages();
	    	// });	
	    }

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
		    $scope.getMessages();
	    }

	    $scope.resendSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.resend(selected, $scope.messages[selected].id);
	    	}
	    	$scope.selectedRows = [];
	    }

    	jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

        $scope.showGroupMessages = function(id){
        	$rootScope.groupMessages = [];
        	$http({
        		method: 'get',
        		url: 'sms/report/group/'+id
        	}).then(function(res){
        		$rootScope.groupMessages = res.data;
        	})
        	$modal.open({
                templateUrl: 'views/common/show_group_numbers.html',
                controller: function($scope, DTOptionsBuilder){
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
                }
            });
        }

	});	
angular
	.module('inspinia')
	.controller('sendSingleSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.userId = null;
		$scope.contacts = [];
		$scope.messageCharactersSingle = 0;
		$scope.testMessageCharacters = 0;


		$scope.sendSingleSMSURL = 'sms/send/to';

		$http({
			url: 'contacts/contact',
			method: 'get'
		}).then(function(res){
			$scope.contacts = res.data;
			$scope.contacts.unshift('');
		});

		$http({
			url: 'sms/schedules',
			method: 'get'
		}).then(function(res){
			$scope.schedules = res.data;
		});

		$scope.calculateCharacters = function(text){
			$scope.messageCharactersSingle = $scope.testMessageCharacters = (typeof text != 'undefined') ? text.length : 0;
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
angular
	.module('inspinia')
	.controller('trashedSMSController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];

		$scope.getMessages = function()
		{

			$http({
				url: 'sms/report/trash',
				method: 'get'
			}).then(function(res){
				$scope.messages = res.data;
				$scope.selectedRows = [];
			});
		}

		$scope.getMessages();

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


	    $scope.restore = function(key, id, multi){
	    	$http({
	    		url: 'sms/restore/'+id,
	    		method: 'post'
	    	}).then(function(res){
	    		if(typeof multi == 'undefined'){
	    			$scope.messages.splice(key, 1);
	    		}
	    	});
	    }

	    $scope.destroy = function(key, id, multi){
	    	$http({
	    		url: 'sms/delete/destroy/'+id,
	    		method: 'delete'
	    	});
	    }

	    $scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.destroy($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getMessages();
	    }

	    $scope.restoreSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.destroy($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'sms/report/trash',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	}, 500);
	    }

        	jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
        	});

	});
angular
	.module('inspinia')
	.controller('socketController', function($rootScope, $scope){
		console.log('i');
	});	
angular
	.module('inspinia')
	.controller('createSpecialsController', function($rootScope, $scope){
		
		$scope.createSpecialsURL = 'specials';

	});	
angular
	.module('inspinia')
	.controller('editSpecialsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editSpecialsURL = 'specials/'+$scope.id;

		$http({
			url: 'specials/'+$scope.id+'/edit',
			method: 'get',
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('specialsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'specials',
			method: 'get'
		}).then(function(res){
			$scope.specials = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'specials/'+index
			});
			$scope.specials.splice(key, 1);
		};

		$scope.disable = function(key, index){
			$http({
				method: 'delete',
				url: 'specials/disable/'+index
			});
			$scope.specials[key].status = -1;
		};

		$scope.enable = function(key, index){
			$http({
				method: 'put',
				url: 'specials/enable/'+index
			});
			$scope.specials[key].status = 0;
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
angular
	.module('inspinia')
	.controller('aboutUsController', function($rootScope, $scope, $http){
		
		$scope.aboutUs = '';

		$http({
			url: 'customization/about-us',
			method: 'get'
		}).then(function(res){
			$scope.aboutUs = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('contactUsController', function($rootScope, $scope, $http){
		
		$scope.contactUs = '';

		$http({
			url: 'customization/contact-us',
			method: 'get'
		}).then(function(res){
			$scope.contactUs = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('supportFaqController', function($rootScope, $scope, $http){
		
		$scope.faqs = [];

		$http({
			url: 'faqs',
			method: 'get'
		}).then(function(res){
			$scope.faqs = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('supportMarketingCodeController', function($rootScope, $scope, $http){
		
		$scope.marketingCode = [];

		$http({
			url: 'customization/marketing_code',
			method: 'get'
		}).then(function(res){
			$scope.marketingCode = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('onlineSupportController', function($rootScope, $scope, $http, $stateParams){

		$scope.messages = [];

		$http({
			url: 'support/chat/with/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.messages = res.data;
		});

		$rootScope.$on('notification', function(event, data){
			$scope.$apply(function(){
				$scope.messages.push(data.message);
			});
		});

		$scope.sendMessage = function(){
			$scope.messages.push($scope.message);
			$http({
				url: 'support/chat/new-message',
				method: 'post', 
				data: {
					message: $scope.message,
					receiver: $stateParams.id
				}
			});

			$scope.message = '';

		}
	});	

angular
	.module('inspinia')
	.controller('ticketsController', function($rootScope, $scope, $http, DTOptionsBuilder, $stateParams){
		
		$http({
			url: 'support/tickets',
			method: 'get'
		}).then(function(res){
			$scope.tickets = res.data;
		});

		$scope.createTicketURL = 'support/tickets';
		$scope.answerToTicketURL = 'support/tickets/'+$stateParams.id;

		if($stateParams.id){
			$http({
				url: 'support/tickets/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$scope.ticket = res.data;
			})
		}

		$scope.close = function(key, index){
			$http({
				url: 'support/tickets/cancel/'+index,
				method: 'delete'
			});
			$scope.tickets['sent'][key].condition = '-';
			$scope.tickets['sent'][key].status = -1;
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
angular
	.module('inspinia')
	.controller('createTransferToEmailController', function($rootScope, $scope, $http){
		
		$scope.createTransferToEmailURL = 'transfer-to-email';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('editTransferToEmailController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editTransferToEmailURL = 'transfer-to-email/'+$scope.id;

		$http({
			url: 'transfer-to-email/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data.transfer;
			$scope.lines = res.data.lines;
		});

	});	
angular
	.module('inspinia')
	.controller('transferToEmailController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$http({
			url: 'transfer-to-email',
			method: 'get'
		}).then(function(res){
			$scope.transfers = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'transfer-to-email/'+index
			});
			$scope.transfers.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
    	});

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'sms/report',
					method: 'get'
				}).then(function(res){
					$scope.messages = res.data;
				});
	    	}, 500);
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
angular
	.module('inspinia')
	.controller('changeUserParentController', function($scope, $http, $rootScope, $stateParams){
		
		$scope.changeUserParentURL = 'api/users/change-parent';

		$http({
			url: 'api/users/available-to-parent/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.parents = res.data.users;
			$scope.currentUser = res.data.userInfo;
		});

		$scope.submitForm = function(){
			$rootScope.info.target = $stateParams.id;
		}

	});	
angular
	.module('inspinia')
	.controller('userReportController', function($scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'users/report',
			method: 'get'
		}).then(function(res){
			$scope.logins = res.data;
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
angular
	.module('inspinia')
	.controller('adminSettingController', function($rootScope, $scope, $http){

		$scope.adminSettingsURL = 'admin/update';
		$scope.changeGatewaySettingURL = 'users/setting/gateway';

		$http({
			url: 'admin/info',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$rootScope.info.gateway = [];
			$http({
				url: 'users/setting/gateway',
				method: 'get'
			}).then(function(res){
				$rootScope.info.gateway = res.data.gateway;
			});
			console.log($rootScope.info);
		});

		if($rootScope.user.role == 'agent'){
			$http({
				url: 'users/setting/gateway',
				method: 'get'
			}).then(function(res){
				$rootScope.info.gateway = res.data.gateway;
			});
		}

	});
angular
	.module('inspinia')
	.controller('createContactGroupController', function($rootScope, $scope, $http){
		
		$scope.createContactGroupURL = 'contacts/groups';

	});	
angular
	.module('inspinia')
	.controller('editContactGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editContactGroupURL = 'contacts/groups/'+$scope.id;

		$http({
			url: 'contacts/groups/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('createFluentCreditGroupController', function($rootScope, $scope, $stateParams, $http){
		
		$scope.createFluentCreditGroupURL = 'fluent-credits/groups';

		if($stateParams.id){
			$scope.editFluentCreditGroupURL = 'fluent-credits/groups/'+$stateParams.id;

			$http({
				url: 'fluent-credits/groups/'+$stateParams.id+'/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			});
		}

	});	
angular
	.module('inspinia')
	.controller('fluentCreditHomeController', function($scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

		$scope.delete = function(key, id){
			$http({
				url: 'fluent-credits/groups/'+id,
				method: 'delete'
			});
			$scope.fluentCreditGroups.splice(key, 1);
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
angular
	.module('inspinia')
	.controller('createPreTextGroupController', function($rootScope, $scope, $http){
		
		$scope.createPreTextGroupURL = 'pre-texts/group';

	});	
angular
	.module('inspinia')
	.controller('editPreTextGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.group_id;

		$scope.editPreTextGroupURL = 'pre-texts/group/'+$scope.id;

		$http({
			url: 'pre-texts/group/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('preTextGroupController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
			
		$http({
			url: 'pre-texts/group',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.delete = function(id)
	    {

	    	$http({
	    		url: 'pre-texts/group/'+id,
	    		method: 'delete'
	    	}).then(function(){
	    		$http({
					url: 'pre-texts/group',
					method: 'get'
				}).then(function(res){
					$scope.groups = res.data;
				});
	    	});

	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'pre-texts/group',
					method: 'get'
				}).then(function(res){
					$scope.groups = res.data;
				});
	    	}, 500);
	    }

	    jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
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
angular
	.module('inspinia')
	.controller('createDefaultMessagesController', function($rootScope, $scope){
		
		$scope.createDefaultMessagesURL = 'sms/default-messages';

	});	
angular
	.module('inspinia')
	.controller('editDefaultMessagesController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.editDefaultMessagesURL = 'sms/default-messages/'+$stateParams.id;

		$http({
			url: 'sms/default-messages/'+$stateParams.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	
angular
	.module('inspinia')
	.controller('defaultMessagesController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'sms/default-messages',
			method: 'get'
		}).then(function(res){
			$scope.defaultMessages = res.data;
		});

		$scope.delete = function(key, index){
			$scope.defaultMessages.splice(key, 1);
			$http({
				url: 'sms/default-messages/'+index,
				method: 'delete'
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

angular
	.module('inspinia')
	.controller('schedulesController', function($rootScope, $scope, $http, DTOptionsBuilder){

		$scope.selectedRows = [];
		
		$http({
			url: 'sms/schedules',
			method: 'get'
		}).then(function(res){
			$scope.schedules = res.data;
		});

		$scope.disable = function(key, index){
			$scope.schedules[key].status = -1;
			$http({
				url: 'sms/schedules/disable',
				method: 'post',
				data: {
					id: index
				}
			})
		}

		$scope.enable = function(key, index){
			$scope.schedules[key].status = 0;
			$http({
				url: 'sms/schedules/enable',
				method: 'post',
				data: {
					id: index
				}
			})
		}

		$scope.delete = function(key, index){
			$scope.schedules.splice(key, 1);
			$http({
				url: 'sms/schedules/'+index,
				method: 'delete',
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

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'sms/schedules',
					method: 'get'
				}).then(function(res){
					$scope.schedules = res.data;
				});
	    	}, 500);
	    }


		    jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').each(function(){
				jQuery(this).trigger('click');
			});
        	});

	});	
angular
	.module('inspinia')
	.controller('onlineSupportHomeController', ['$rootScope', '$scope', '$state', '$http', function($rootScope, $scope, $state, $http){
		$rootScope.$watch('user', function(val){
			if(typeof val == 'undefined') return;
			if($rootScope.user.role == 'user') {
				$state.go('app.support.online.chat', {id: $rootScope.user.agent_id});
			}
		});

		$http({
			url: 'support/chat/chats',
			method: 'get'
		}).then(function(res){
			$scope.chats = res.data;
		})
	}]);	
//# sourceMappingURL=tpanel-controllers.js.map
