angular.module('origins.types', [
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'toastr',
    'darthwade.loading',
    'datatables.columnfilter',
    'slugifier'
])

.controller('mainTypeController', function( $scope, typesService, $uibModal, $loading, $http, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, toastr ) {

    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(10);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0)
    ];
    $scope.types = {};
    $scope.loadTypes = function(){
        $loading.start('origins-loading');
        typesService.getAllTypes().then(function(data){
            console.log(data);
            $scope.types = data;
            $loading.finish('origins-loading');
        });
    }

    $scope.loadTypes(); 

    $scope.postType = function(typeObj) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'newTypeModal.html',
            controller: 'typeModalCtrl',
            resolve: {
                params: function () {
                  return typeObj;
                }
            }
        });
        modalInstance.result.then(function (message) { //submitted
            // $scope.typeObjAdded = typeObjAdded;
            toastr.success('Success!', message);
            $scope.loadTypes(); 
        });
    };

    $scope.deleteType = function(typeId){
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'deleteTypeModal.html',
            controller: 'typeModalCtrl',
            resolve: {
                params: function () {
                  return { typeId:typeId };
                }
            }
        });

        modalInstance.result.then(function () { //submitted
            toastr.success('Success!', 'Successfully deleted type');
            $scope.loadTypes(); 
        }, function () { //cancelled
        });
    };

})


// TYPES MODAL
.controller('typeModalCtrl', function ($uibModalInstance, $scope, typesService, params, Slug) {

    $scope.typeObj = angular.copy(params);

    $scope.typeSubmit = function(typeObj){
        typeObj.slug = Slug.slugify(typeObj.name);
        // save to DB
        typesService.postType(typeObj).then(function(data){
            $uibModalInstance.close(data);
        });
    };
   
    $scope.delete = function(typeId){
        // delete from DB
        typesService.deleteType(typeId).then(function(data){
            $uibModalInstance.close(typeId);
        });
    };

    $scope.cancel = function(typeId){
        $uibModalInstance.dismiss();
    };

})

.controller('mainSubTypeController', function( $scope, typesService, $uibModal, $loading, $http, $filter, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, toastr ) {

    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(10);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0)
    ];
    $scope.types = {};
    $scope.loadSubTypes = function(){
        $loading.start('origins-loading');
        typesService.getAllSubTypes().then(function(data){
            console.log(data);
            $scope.subtypes = data;
            $loading.finish('origins-loading');
        });
    }

    $scope.loadSubTypes(); 

    $scope.postSubType = function(subtypeObj, isDelete) {

        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: isDelete ? 'deleteTypeModal.html' : 'postSubTypeModal.html',
            controller: 'subtypeModalCtrl',
            resolve: {
                subtype: function () {
                  return subtypeObj;
                },
                isEdit: function () {
                  return subtypeObj == null ? false : true;
                }
            }
        });
        modalInstance.result.then(function (message) { //submitted
            toastr.success('Successfully deleted sub type!');
            $scope.loadSubTypes(); 
        });

    };

})

.controller('subtypeModalCtrl', function ($uibModalInstance, $scope, typesService, subtype, isEdit, Slug) {
    
    $scope.subtypeObj = angular.copy(subtype);

    // get parent types
    typesService.getAllTypes().then(function(data){
        $scope.parent_type_option = data;
        if( isEdit ) 
            $scope.selectedParentType = $scope.parent_type_option.filter(function(item) { return item.id == $scope.subtypeObj.parent_type })[0];
        else
            $scope.selectedParentType = $scope.parent_type_option[0];
    });

    $scope.subtypeSubmit = function(subtypeObj){
        subtypeObj.slug = Slug.slugify(subtypeObj.name);
        subtypeObj.parent_type = $scope.selectedParentType.id;
            
        typesService.postSubType(subtypeObj).then(function(data){
            $uibModalInstance.close(data);
        });
    };

    $scope.delete = function(subtypeId){
        // console.log(subtypeId);
        typesService.deleteSubType(subtypeId).then(function(data){
            $uibModalInstance.close(subtypeId);
        });
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss();
    };

})

.service('typesService', function ($http, $q, $loading) {

    return {
        getAllTypes: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_origins_types' },
                dataType: 'json',
                beforeSend: function() {
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
         getAllSubTypes: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_origins_subtypes' },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting types...');
                },
                success : function( response ) {
                    console.log('success requesting types');
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        postType: function(typeObj){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'post_origins_type', params: typeObj },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting types...');
                },
                success : function( response ) {
                	console.log(response);
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        postSubType: function(subtypeObj){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'post_origins_subtype', params: subtypeObj },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting types...');
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        deleteType: function(typeId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_type', typeId: typeId },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting types...');
                },
                success : function( response ) {
                    console.log(response);
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
        deleteSubType: function(subtypeId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_subtype', subtypeId: subtypeId },
                dataType: 'json',
                beforeSend: function() {
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        }
    }

})

