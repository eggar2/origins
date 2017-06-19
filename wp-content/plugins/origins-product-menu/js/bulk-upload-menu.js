angular.module('origins.bulkupload', [
    'ui.bootstrap',
    'toastr',
    'ngCsvImport',
    'ngLodash',
    'slugifier'
    ])

.controller('bulkUploadController', function( $scope, $uibModal, $loading, $http, $filter, toastr, bulkUploadService, lodash, Slug, $q ) {

    // init data: farm, lifestyle, subtype, type
    $loading.start('origins-loading');
    bulkUploadService.getAllOptions().then(function(data){
        $loading.finish('origins-loading');

        $scope.farms = data.farms;
        $scope.lifestyles = data.lifestyle;
        // $scope.special_tags_option = data.special_tags; //designations
        $scope.types = data.type;
        $scope.subtypes = data.subtype;

        // console.log( lodash.find( data.farms, {'slug':'zoots'} ).id );
        $scope.count = 0;
        $scope.uploading = false;
    });

    $scope.onUpload = function(){
        $loading.start('origins-uploading');
        $scope.total_items = $scope.csv.result.length;

        // console.log( $scope.csv.result );
        $scope.uploading = true;
        var chain = $q.when();
        
        angular.forEach($scope.csv.result, function(value, key){

            var menu = {};
            menu.name = value['product-name'];
            menu.description = value['product-description'];
            menu.cbs_ratio = value['cannabinoid-ratio'];
            menu.lab_result_link = value['lab-result'];
            menu.designations = [];
            if( value['deals'] != '' )
                menu.designations.push('4');
            if( value['origins-certified'] != '' )
                menu.designations.push('2');
            if( value['cbd'] != '' )
                menu.designations.push('3');
            menu.prices = [];
            for (i = 1; i <= 6; i++) { 
                if( value['price'+i] != '' && value['weight-amount'+i] != '' ){
                    menu.prices.push({
                        price : value['price'+i],
                        weight : value['weight-amount'+i],
                        weight_type : value['weight-type'+i]
                    });
                }
            }
            
            menu.farm = '';
            if( value['farm'] != '' && lodash.find( $scope.farms, {'slug': Slug.slugify(value['farm'])} ) != null ){
                menu.farm = lodash.find( $scope.farms, {'slug': Slug.slugify(value['farm'])} ).id;
            }

            menu.lifestyle = '';
            if( value['lifestyle'] != '' && lodash.find( $scope.lifestyles, {'slug': Slug.slugify(value['lifestyle'])} ) != null ){
                menu.lifestyle = lodash.find( $scope.lifestyles, {'slug': Slug.slugify(value['lifestyle'])} ).id;
            }

            menu.type = '';
            if( value['type'] != '' && lodash.find( $scope.types, {'slug': Slug.slugify(value['type'])} ) != null ){
                menu.type = lodash.find( $scope.types, {'slug': Slug.slugify(value['type'])} ).id;
            }

            menu.subtype = '';
            if( value['sub-types'] != '' && lodash.find( $scope.subtypes, {'slug': Slug.slugify(value['sub-types'])} ) != null ){
                menu.subtype = lodash.find( $scope.subtypes, {'slug': Slug.slugify(value['sub-types'])} ).id;
            }

            // console.log(menu);
            chain = chain.then(function(){
                $scope.count = $scope.count + 1;
                console.log('posting...');
                return bulkUploadService.postMenu(menu).then(function(data){});
            });

        }); //@end forEach

        // the final chain object will resolve once all the posts have completed.
        chain.then(function(){
            $scope.uploading = false;
            $loading.finish('origins-uploading');
            toastr.success('Successfully uploaded menu');
            // setTimeout(function(){ window.location = menus_url; }, 1000);
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
        getAllOptions: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_options' },
                dataType: 'json',
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
    }
})


