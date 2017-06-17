angular.module('origins.bulkupload', [
    'ui.bootstrap',
    'toastr',
    'ngCsvImport'
])

.controller('bulkUploadController', function( $scope, $uibModal, $loading, $http, $filter, toastr, bulkUploadService ) {

    $scope.items = [];
    var count = 0;
    $scope.item_added = 0;

    $scope.onUpload = function(){
        $loading.start('origins-loading');
        $scope.total_items = $scope.csv.result.length;
        angular.forEach($scope.csv.result, function(value, key){

            bulkUploadService.postMenu(value).then(function(data){
                count = count + 1;
                if( count == $scope.csv.result.length ){
                    $loading.finish('origins-loading');
                    toastr.success('Successfully uploaded menu');
                    setTimeout(function(){ window.location = menus_url; }, 1000);
                }
            });

        });
    };

    $scope.csv = {
        content: null,
        header: true,
        headerVisible: true,
        separator: ',',
        separatorVisible: false,
        result: null,
        encoding: 'ISO-8859-1',
        encodingVisible: false,
        uploadButtonLabel: "upload a csv file",
        callback: function(e){
            $scope.onUpload();
        }
    };



})

.service('bulkUploadService', function ($http, $q, $loading) {
    return {
        postMenu: function(menu) {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'origins_post_menu', params : menu },
                dataType: 'json',
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        }, 
    }
})


