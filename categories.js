'use strict';

tbTestApp.controller('categoriesController', ['$rootScope', '$scope', '$location', '$http', 'config',
    function categoriesController ($rootScope, $scope, $location, $http, config) {
        $scope.msg = 'Categories Message';
        $rootScope.pageTitle = config.appName + ' - Categories';
        $http.get(config.baseApiServerPrefix + 'categories/').then(
            function successCallback(response) {
                $scope.categories = response.data.categories;
            },
            function errorCallback(response) {
                console.log(response);
            });
        $scope.deleteCategory = function (category) {
            $http.delete(config.baseApiServerPrefix + 'categories/' + category.category.id).then(
                function successCallback(response) {
                    window.location = '#/categories/';
                    window.location.reload();
                },
                function errorCallback(response) {
                    console.log(response);
                });
        }
    }
]);
