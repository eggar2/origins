<div ng-app="origins" ng-controller="bulkUploadController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Menu...'}">
    <div class="container" id="bulk-menu-portal">

        <h3>Bulk Upload Menu</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="block row">
            <div class="title">
                <h4>Select your CSV file: </h4>
            </div>

            <div class="">

                <ng-csv-import 
                class="import"
                content="csv.content"
                header="csv.header" 
                header-visible="csv.headerVisible" 
                separator="csv.separator"
                separator-visible="csv.separatorVisible"
                result="csv.result"
                encoding="csv.encoding"
                encoding-visible="csv.encodingVisible"
                callback="csv.callback"></ng-csv-import>

            </div>

        </div> 
        <hr>
        <div class="col-md-12">
            <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_menu" class="btn btn-success btn-md" id="add-farm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Menu List</a>
            <br><br>
        </div>

    </div>
</div>
<script>
    var url = "<?php echo get_site_url(); ?>";
    var menus_url = "<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_menu";
</script>
