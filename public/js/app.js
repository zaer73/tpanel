(function () {
    angular.module('inspinia', [
        'ui.router',                    // Routing
        'oc.lazyLoad',                  // ocLazyLoad
        'ui.bootstrap',                 // Ui Bootstrap
        'pascalprecht.translate',       // Angular Translate
        'ngIdle',                       // Idle timer
        'ngSanitize',                    // ngSanitize
    ])
    .config(['$httpProvider', function ($httpProvider) {
		$httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"
	}])
	.run(['$rootScope', 'userIdFactory', 'roleFactory', '$state', function($rootScope, userIdFactory, roleFactory, $state){
        $rootScope.$on('$stateChangeStart',
            function(event, toState, toParams, fromState, fromParams){
                userIdFactory.getUserInfo(toState);
            });
	}]);
})();