<div ng-app="origins" ng-controller="mainController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Menu...'}">
    <div class="container" id="all-menu-portal">

        <h3>Origins Menu</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="col-md-12">
            <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_add_menu" class="btn btn-success btn-md" id="add-farm"><i class="fa fa-plus" aria-hidden="true"></i> Add Menu</a>
            <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_bulk_upload_menu" class="btn btn-success btn-md" id="add-farm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Bulk Upload Menu</a>
            <!-- <a href="#" class="btn btn-danger btn-md" id="bulk-delete-menu"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a> -->

            <div class="search pull-right">
               <input type="text" name="search">
               <a href="#" class="btn btn-primary btn-md"><i class="fa fa-search" aria-hidden="true"></i></a> 
           </div>
            <br><br>

        </div>

        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="row-border hover table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>CBS Ratio</th>
                            <th>Lab Result</th>
                            <th>Prices</th>
                            <th>Farm</th>
                            <th>Type</th>
                            <th>Sub Type</th>
                            <th>Lifestyle</th>
                            <th>Designations</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="menu in menus">
                            <td>
                                <input type="checkbox">
                            </td>
                            <td>{{menu.id}}</td>
                            <td>{{menu.name}}</td>
                            <td>{{menu.description}}</td>
                            <td>{{menu.cbs_ratio}}</td>
                            <td>
                                <a ng-show="menu.lab_result_link" href="{{menu.lab_result_link}}" class="btn btn-sm btn-info" target="_blank">View</a>
                            </td>
                            <td class="prices" style="width: 100px;">
                                <p ng-if="menu.prices" ng-repeat="p in menu.prices">
                                    <span>{{p.weight}}</span> - <span>${{p.price}}</span>
                                </p>
                            </td>
                            <td>{{menu.farm}}</td>
                            <td>{{menu.type}}</td>
                            <td>{{menu.subtype}}</td>
                            <td>{{menu.lifestyle}}</td>
                            <td>{{menu.special_tags}}</td>
                            <td class="controls" style="width: 100px;">
                                <a href="<?php echo get_site_url() . '/wp-admin/admin.php?page=origins_add_menu&edit='; ?>{{menu.id}}" class="edit-menu btn btn-md btn-primary" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-menu btn btn-md btn-danger" ng-click="deleteMenu(menu.id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- pager -->
                <ul ng-if="pager.pages.length" class="pagination">
                    <li ng-class="{disabled:pager.currentPage === 1}">
                        <a ng-click="setPage(1)">First</a>
                    </li>
                    <li ng-class="{disabled:pager.currentPage === 1}">
                        <a ng-click="setPage(pager.currentPage - 1)">Previous</a>
                    </li>
                    <li ng-repeat="page in pager.pages" ng-class="{active:pager.currentPage === page}">
                        <a ng-click="setPage(page)">{{page}}</a>
                    </li>                
                    <li ng-class="{disabled:pager.currentPage === pager.totalPages}">
                        <a ng-click="setPage(pager.currentPage + 1)">Next</a>
                    </li>
                    <li ng-class="{disabled:pager.currentPage === pager.totalPages}">
                        <a ng-click="setPage(pager.totalPages)">Last</a>
                    </li>
                </ul>
                <!-- pager -->

            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="deleteMenuModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Are you sure to delete this menu?</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <button type="button" class="btn btn-primary" ng-click="delete(menuId)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>
<script>
    var url = "<?php echo get_site_url(); ?>";
</script>
