'use strict';

demoApp.controller('clientsController', ['$rootScope', '$scope', '$http', 'config',
    function clientsController ($rootScope, $scope, $http, config) {
        $scope.msg = 'Clients Message';
        $rootScope.pageTitle = config.appName + ' - Clients';

        $http({method: 'GET',
               url: config.baseApiServerPrefix + 'clients/'}).then(
            function successCallback(response) {
                //console.log(response);
                $scope.clients = response.data.clients;
            },
            function errorCallback(response) {
                console.log(response);
            });

    }
]);
