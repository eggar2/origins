angular.module('origins.specials', [
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'toastr',
    'darthwade.loading',
    'datatables.columnfilter',
    'slugifier'
])

.controller('mainSpecialController', function( $scope, specialsService, $uibModal, $loading, $http, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, toastr ) {

    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(10);
    $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(0)
    ];
    $scope.special = {};
    $scope.loadSpecials = function(){
        $loading.start('origins-loading');
        specialsService.getAllSpecials().then(function(data){
            $scope.specials = data;
            $loading.finish('origins-loading');
        });
    }

    $scope.loadSpecials(); 

    $scope.postSpecial = function(specialObj) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'postSpecialModal.html',
            controller: 'specialModalCtrl',
            resolve: {
                params: function () {
                  return specialObj;
                }
            }
        });
        modalInstance.result.then(function (message) { //submitted
            toastr.success('Success!', message);
            $scope.loadSpecials(); 
        });
    };

    $scope.deleteSpecial = function(specialId){
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'deleteSpecialModal.html',
            controller: 'specialModalCtrl',
            resolve: {
                params: function () {
                  return { specialId:specialId };
                }
            }
        });

        modalInstance.result.then(function () { //submitted
            toastr.success('Success!', 'Successfully deleted special');
            $scope.loadSpecials(); 
        }, function () { //cancelled
        });
    };

})

.controller('specialModalCtrl', function ($uibModalInstance, $scope, specialsService, params, Slug) {

    $scope.specialObj = angular.copy(params);

    $scope.specialSubmit = function(specialObj){
        specialObj.slug = Slug.slugify(specialObj.name);
        // save to DB
        specialsService.postSpecial(specialObj).then(function(data){
            $uibModalInstance.close(data);
        });
    };

    $scope.delete = function(specialId){
        // delete from DB
        specialsService.deleteSpecial(specialId).then(function(data){
            $uibModalInstance.close(specialId);
        });
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss();
    };

})

.service('specialsService', function ($http, $q, $loading) {

    return {
        getAllSpecials: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_origins_specials' },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting specials...');
                },
                success : function( response ) {
                    console.log('success requesting specials');
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        postSpecial: function(specialObj){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'post_origins_special', params: specialObj },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting specials...');
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        deleteSpecial: function(specialId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_special', specialId: specialId },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting specials...');
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



