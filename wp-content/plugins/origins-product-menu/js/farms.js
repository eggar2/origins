angular.module('origins.farms', [
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'toastr',
    'darthwade.loading',
    'datatables.columnfilter',
    'slugifier'
])

.controller('mainFarmController', function( $scope, farmsService, $uibModal, $loading, $http, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, toastr ) {

    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(10);
    $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(0)
    ];
    $scope.farms = {};
    $scope.loadFarms = function(){
        $loading.start('origins-loading');
        farmsService.getAllFarms().then(function(data){
            $scope.farms = data;
            $loading.finish('origins-loading');
        });
    }

    $scope.loadFarms(); 

    $scope.postFarm = function(farmObj) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'postFarmModal.html',
            controller: 'farmModalCtrl',
            resolve: {
                params: function () {
                  return farmObj;
                }
            }
        });
        modalInstance.result.then(function (message) { //submitted
            toastr.success('Success!', message);
            $scope.loadFarms(); 
        });
    };

    $scope.deleteFarm = function(farmId){
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'deleteFarmModal.html',
            controller: 'farmModalCtrl',
            resolve: {
                params: function () {
                  return { farmId:farmId };
                }
            }
        });

        modalInstance.result.then(function () { //submitted
            toastr.success('Success!', 'Successfully deleted farm');
            $scope.loadFarms(); 
        }, function () { //cancelled
        });
    };

})

.controller('farmModalCtrl', function ($uibModalInstance, $scope, farmsService, params, Slug) {

    $scope.farmObj = angular.copy(params);

    $scope.farmSubmit = function(farmObj){
        // save to DB
        farmObj.slug = Slug.slugify(farmObj.name);
        farmsService.postFarm(farmObj).then(function(data){
            $uibModalInstance.close(data);
        });
    };

    $scope.delete = function(farmId){
        // delete from DB
        farmsService.deleteFarm(farmId).then(function(data){
            $uibModalInstance.close(farmId);
        });
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss();
    };

})

.service('farmsService', function ($http, $q, $loading) {

    return {
        getAllFarms: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_origins_farms' },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting farms...');
                },
                success : function( response ) {
                    console.log('success requesting farms');
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        postFarm: function(farmObj){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'post_origins_farm', params: farmObj },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting farms...');
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        deleteFarm: function(farmId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_farm', farmId: farmId },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting farms...');
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



