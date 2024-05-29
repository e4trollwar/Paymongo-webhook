<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>

<body ng-app="myApp" ng-controller="customersCtrl">


notifications:

 @{{notification}}


</body>
<script >
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {

var source = new EventSource("{{url('notify')}}");
    source.onmessage=function(event){
        $scope.notification =event.data;
        
        $scope.$digest();
    }

});
</script>



</html>