var app = angular.module('origins', [
    'datatables',
    'datatables.bootstrap',
    'ui.bootstrap',
    'toastr',
    'darthwade.loading',
    'datatables.columnfilter',
    'origins.types',
    'origins.farms',
    'origins.lifestyles',
    'origins.specials',
    'origins.bulkupload'
]);

app.controller('mainController', function( $scope, $loading, $http, $filter, menuService, PagerService, toastr, $uibModal ) {

    $scope.loadMenu = function(page){
        $loading.start('origins-loading');
        menuService.getAllMenu(page).then(function(data){
            console.log(data);
            if( data.length <= 0 && $scope.current_page != 1 ){ //reset to page 1 if no items && not page 1
                $scope.setPage( 1 );
            }else{
                $scope.menus = data;
                $scope.itemsCount = data.length;
            }

            $loading.finish('origins-loading');
        });
    }

    $scope.current_page = 1;

    // PAGINATION ====================================================
    $scope.setPage = function(page){

        PagerService.getTotalItems().then(function(data){
            $scope.rowSelected = [];
            $scope.totalItems = data;
            $scope.pager = {};
            if (page < 1 || page > $scope.pager.totalPages) {
                return;
            }
            $scope.current_page = page;
            $scope.pager = PagerService.GetPager(data, page);
            $scope.loadMenu($scope.current_page);

        });

    }

    $scope.setPage( $scope.current_page );

    // PAGINATION ====================================================

    // DELETE MENU/S
    $scope.deleteMenu = function(menuId){

        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'deleteMenuModal.html',
            controller: 'menuModalCtrl',
            resolve: {
                params: function () {
                  return { menuId:menuId };
                }
            }
        });

        modalInstance.result.then(function () { //submitted
            toastr.success('Successfully deleted menu');
            $scope.loadMenu($scope.current_page);
        }, function () { //cancelled
        });
    };

    $scope.rowSeletionChanged = function (menu) {
        if($scope.rowSelected.indexOf(menu) !== -1) { //if exists
            $scope.rowSelected.splice($scope.rowSelected.indexOf(menu), 1);
        }else{
            $scope.rowSelected.push(menu);
        }
    }

});

app.service('PagerService', function ($http, $q, $loading) {
    return {
        GetPager: function(totalItems, currentPage, pageSize) {
            currentPage = currentPage || 1;

            // default page size is 10
            pageSize = pageSize || 10;

            // calculate total pages
            var totalPages = Math.ceil(totalItems / pageSize);

            var startPage, endPage;
            if (totalPages <= 10) {
                // less than 10 total pages so show all
                startPage = 1;
                endPage = totalPages;
            } else {
                // more than 10 total pages so calculate start and end pages
                if (currentPage <= 6) {
                    startPage = 1;
                    endPage = 10;
                } else if (currentPage + 4 >= totalPages) {
                    startPage = totalPages - 9;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - 5;
                    endPage = currentPage + 4;
                }
            }

            // calculate start and end item indexes
            var startIndex = (currentPage - 1) * pageSize;
            var endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

            // create an array of pages to ng-repeat in the pager control
            var pages = _.range(startPage, endPage + 1);

            // return object with all pager properties required by the view
            return {
                totalItems: totalItems,
                currentPage: currentPage,
                pageSize: pageSize,
                totalPages: totalPages,
                startPage: startPage,
                endPage: endPage,
                startIndex: startIndex,
                endIndex: endIndex,
                pages: pages
            };

        },
        getTotalItems: function() {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'origins_get_total_items' },
                dataType: 'json',
                beforeSend: function() {
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        },
    }
});

app.controller('postMenuController', function( $scope, $loading, $http, $filter, menuService, toastr ) {

    var is_edit = false;

    // set farms options
    menuService.getAllOptions().then(function(data){

        $scope.farms = data.farms;
        $scope.lifestyles = data.lifestyle;
        $scope.special_tags_option = data.special_tags;
        $scope.type_options = data.type;
        $scope.subtype_options = data.subtype;

        if( menu_to_edit ){
            is_edit = true;
            // get menu obj
            menuService.getMenu(menu_to_edit).then(function(response){

                data = response.menu;
                $scope.menu = data;
                $scope.lab_result_link = data.lab_result_link;

                console.log(data);

                if( data ){
                  $scope.selectedFarm = $scope.farms.filter(function(item) { return item.id == data.farm })[0];
                  $scope.selectedType = $scope.type_options.filter(function(item) { return item.id == data.type })[0];
                  $scope.selectedSubType = $scope.subtype_options.filter(function(item) { return item.id == data.subtype })[0];
                  $scope.selectedLifestyle = $scope.lifestyles.filter(function(item) { return item.id == data.lifestyle })[0];
                  // $scope.selectedSpecialTags = $scope.special_tags_option.filter(function(item) { return item.id == data.special_tags })[0];
                  $scope.prices = data.prices ? data.prices : [];  
                    
                    $scope.onTypeSelected($scope.selectedType);  

                }

                if( response.designations ){
                    angular.forEach($scope.special_tags_option, function(tag, key){
                        if( response.designations.filter(function(item) { return item.designation == tag.id }).length > 0 )
                            $scope.special_tags_option[key].selected = true;
                    });
                }

                
            });
        }else{
            $scope.inputInit();
        }

    });

    $scope.inputInit = function(){
        $scope.menu = '';
        $scope.selectedFarm = '';
        $scope.selectedType = '';
        $scope.selectedSubType = '';
        $scope.selectedLifestyle = '';
        // $scope.selectedSpecialTags = '';
        $scope.designations = [];
        $scope.prices = [];
    };

    $scope.onTypeSelected = function(type){
        $scope.subtype_options_filtered = $scope.subtype_options.filter(function(item) { return item.parent_type == type.id });
    };

    $scope.onSubTypeSelected = function(subtype){
        $scope.selectedSubType = subtype;
    }

    // PRICES  
    $scope.addNewPrice = function() {
        var newItemNo = $scope.prices.length + 1;
        $scope.prices.push({'id':newItemNo});
    };

    $scope.removePrice = function() {
        var lastItem = $scope.prices.length-1;
        $scope.prices.splice(lastItem);
    };

    $scope.changeSelection = function(selected){
        console.log(selected);
    };

    $scope.postMenu = function(menu){

        $scope.designations = [];
        angular.forEach($scope.special_tags_option, function(tag){
          if (tag.selected) $scope.designations.push(tag.id);
        });

        $loading.start('origins-loading');

        menu.lab_result_link = jQuery('#image_url').val();

        if( $scope.selectedFarm ) 
            menu.farm = $scope.selectedFarm.id;
        else
            menu.farm = $scope.selectedFarm;

        // if( $scope.selectedType ) 
        //     menu.type = $scope.selectedType.id;
        // else
        //     menu.type = $scope.selectedType;

        menu.type = $scope.selectedType.id;

        if( $scope.selectedSubType ) 
            menu.subtype = $scope.selectedSubType.id;
        else
            menu.subtype = $scope.selectedSubType;
        // menu.subtype = $scope.selectedSubType.id;

        if( $scope.selectedLifestyle ) 
            menu.lifestyle = $scope.selectedLifestyle.id;
        else
            menu.lifestyle = $scope.selectedLifestyle;

        // if( $scope.selectedSpecialTags ) 
        //     menu.special_tags = $scope.selectedSpecialTags.id;
        // else
        //     menu.special_tags = $scope.selectedSpecialTags;

        menu.prices = $scope.prices;
        menu.designations = $scope.designations;

        // console.log(menu);
        // return true;

        menuService.postMenu(menu).then(function(data){
            if( data.success ){
                toastr.success(data.message);
                if( !is_edit ){
                    $scope.inputInit();
                    setTimeout(function(){ window.location = menus_url; }, 1500);
                }
            }else{
                if( data.message == '' )
                    toastr.error('No changes was made.');
                else
                    toastr.error(data.message, 'An error has occured.');
            }
            $loading.finish('origins-loading');
        });

    }

});

app.controller('menuModalCtrl', function ($uibModalInstance, $scope, menuService, params) {

    $scope.menuId = params.menuId;
    $scope.delete = function(menuId){
        // delete from DB
        menuService.deleteMenu(menuId).then(function(data){
            $uibModalInstance.close(menuId);
        });
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss();
    };

})

app.service('menuService', function ($http, $q, $loading) {

    return {
        getAllMenu: function(page) {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'get_menus', page : page },
                dataType: 'json',
                beforeSend: function() {
                },
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
        getMenu: function(menuId) {
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'origins_get_menu', menuId : menuId },
                dataType: 'json',
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        }, 
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
        deleteMenu: function(menuId){
            var deferred = $q.defer();
            jQuery.ajax({
                type : 'post',
                url : url + '/wp-admin/admin-ajax.php',
                data : { action : 'delete_origins_menu', menuId: menuId },
                dataType: 'json',
                beforeSend: function() {
                    console.log('requesting farms...');
                },
                success : function( response ) {
                    deferred.resolve(response);
                }
            });
            return deferred.promise;
        }
    }

});


// app.filter('origins_prices', function() {
//     return function(objString) {

//         output = '';
//         prices = angular.fromJson( objString.replace(/\\/g, '') );
//         angular.forEach(prices, function(value, key){
//             output += '<span><strong>'+ key +'</strong> - $'+ value +'</span>';
//         });

//         return output;
//     };
// });


