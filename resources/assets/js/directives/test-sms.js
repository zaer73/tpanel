angular
    .module('inspinia')
    .directive('testSms', function(){
    	return {
    		templateUrl: 'views/common/test_sms_template.html',
    		controller: function($rootScope, $scope, $modal, $attrs, charactersFactory){
                var brand = ($attrs.brand == 'true') ? true : false;
                var international = ($attrs.international == 'true') ? true : false;

                // $scope.testMessageCharacters = 0;
                // $scope.testMessagePages = 0;

                // $scope.calculateCharactersTest = function(text){
                //     $scope.testMessageCharacters = (typeof text != 'undefined') ? $rootScope.info.text.length : 0;
                //     $scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
                // }

    			$scope.openTestSMSModal = function(){
                    console.log($scope);
                    if(brand){
                        $modal.open({
                            templateUrl: 'views/common/test_sms_brand.html',
                        });
                    } else{ 
                        if(international){
                            $modal.open({
                                templateUrl: 'views/common/test_sms_international.html',
                            });
                        } else {
                            $modal.open({
                                templateUrl: 'views/common/test_sms.html',
                            });
                        }
                    }
                }

                $rootScope.sendTestMessageURL = 'sms/test';
    		}
    	}
    });