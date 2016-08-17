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