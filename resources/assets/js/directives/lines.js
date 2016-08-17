angular
    .module('inspinia')
    .directive('lines', function(){
    	return {
    		templateUrl: 'views/common/lines.html',
    		controller: function($rootScope, $scope, $http, $attrs){
                $rootScope.lineIdNumbers = [];
                $rootScope.linesRahyab = [];
                var url = 'lines/to-send';
                if($attrs.rahyab){
                    url = 'lines/to-send?rahyab=true';
                }
    			$http({
					url: url,
					method: 'get',
				}).then(function(res){
					$rootScope.linesToSend = res.data;
                    if(typeof $rootScope.linesToSend == 'object'){
                        res.data = $rootScope.linesToSend;
                    }
                    for(key in res.data){
                        $rootScope.lineIdNumbers[$rootScope.linesToSend[key].id] = $rootScope.linesToSend[key].number;
                        $rootScope.linesRahyab[$rootScope.linesToSend[key].id] = $rootScope.linesToSend[key].rahyab;
                    }
                    console.log($rootScope.linesToSend.length);
				});
    		}
    	}
    });