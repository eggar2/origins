angular.module('origins.lifestyles', [
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'toastr',
    'darthwade.loading',
    'datatables.columnfilter'
])

.controller('mainLifestyleController', function( $scope, lifestylesService, $uibModal, $loading, $http, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, toastr ) {

    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(10);
    $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(0)
    ];
    $scope.lifestyle = {};
    $scope.loadLifestyles = function(){
        $loading.start('origins-loading');
        lifestylesService.getAllLifestyles().then(function(data){
            $scope.lifestyles = data;
            $loading.finish('origins-loading');
        });
    }

    $scope.loadLifestyles(); 

    $scope.postLifestyle = function(lifestyleObj) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'postLifestyleModal.html',
            controller: 'lifestyleModalCtrl',
            resolve: {
                params: function () {
                  return lifestyleObj;
                }
            }
        });
        modalInstance.result.then(function (message) { //submitted
            toastr.success('Success!', message);
            $scope.loadLifestyles(); 
        });
    };

    $scope.deleteLifestyle = function(lifestyleId){
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'deleteLifestyleModal.html',
            controller: 'lifestyleModalCtrl',
            resolve: {
                params: function () {
                  return { lifestyleId:lifestyleId };
                }
            }
        });

        modalInstance.result.then(function () { //submitted
            toastr.success('Success!', 'Successfully deleted lifestyle');
            $scope.loadLifestyles(); 
        }, function () { //cancelled
        });
    };

})

.controller('lifestyleModalCtrl', function ($uibModalInstance, $scope, lifestylesService, params) {

    $scope.lifestyleObj = angular.copy(params);

    $scope.lifestyleSubmit = function(lifestyleObj){
        // save to DB
        lifestylesService.postLifestyle(lifestyleObj).then(function(data){
            $uibModalInstance.close(data);
        });
    };

    $scope.delete = function(lifestyleId){
        // delete from DB
        lifestylesService.deleteLifestyle(lifestyleId).then(function(data){
            $uibModalInstance.close(lifestyleId);
        });
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss();
    };

})

.service('lifestylesService', function ($http, $q, $loading) {

    return {
        getAllLifestyles: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_origins_lifestyles' },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting lifestyles...');
                },
                success : function( response ) {
                    console.log('success requesting lifestyles');
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        postLifestyle: function(lifestyleObj){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'post_origins_lifestyle', params: lifestyleObj },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting lifestyles...');
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        deleteLifestyle: function(lifestyleId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_lifestyle', lifestyleId: lifestyleId },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting lifestyles...');
                },
                success : function( response ) {
                    console.log(response);
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        }
    }

})



