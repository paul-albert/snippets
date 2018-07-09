'use strict';

demoApp
    .directive('leftMenu', function () {
        return {
            controller: function ($scope, $http) {
                $http.get('data/menu.json').then(
                    function successCallback (response) {
                        $scope.menu = response.data;
                    },
                    function errorCallback (response) {
                        //
                    }
                );
            },
            restrict: 'E',
            templateUrl: 'templates/menu.html'
        };
    })
    .directive('bsActiveLink', ['$location', function ($location) {
        return {
            restrict: 'A', // use as attribute
            replace: false,
            link: function (scope, elem) {
                //after the route has changed
                scope.$on("$routeChangeSuccess", function () {
                    var hrefs = ['/#' + $location.path(),
                                 '#' + $location.path(), //html5: false
                                 $location.path()]; //html5: true
                    angular.forEach(elem.find('a'), function (a) {
                        a = angular.element(a);
                        if (-1 !== hrefs.indexOf(a.attr('href'))) {
                            a.parent().parent().addClass('active');
                        } else {
                            a.parent().parent().removeClass('active');
                        };
                    });
                });
            }
        }
    }])
;
