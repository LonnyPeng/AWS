/**
 * Created by wangwei on 2017/5/17.
 */
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope,$http, $timeout,$interval) {
    $scope.firstName= "John";
    $scope.lastName= "Doe";
    $scope.name = 'wangwei';
    $scope.email = '';
    $scope.sayHellow = function () {
      alert('hellow');  
    };
    $scope.counts=['zhongguo','riben','hanguo','jianada','meiguo'];
    $http.get("index.php").then(function (response) {
        $scope.myWelcome = response.data;
    });
    $scope.myWelcome = "Hello World!";
    $timeout(function () {
        $scope.myWelcome = "How are you today?";
    }, 3000);

    $scope.theTime = new Date().toLocaleDateString();
    $interval(function () {
        $scope.theTime = new Date().toLocaleTimeString(); 
    },1000); 
});