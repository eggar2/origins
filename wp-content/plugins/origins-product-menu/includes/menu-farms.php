<div ng-app="origins" ng-controller="mainFarmController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Farms...'}">
    <div class="container" id="all-farm-portal">

        <h3>Origins Menu Farms</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="row">

            <div class="col-md-12">
                <button ng-click="postFarm()" class="btn btn-success btn-md" id="add-farm"><i class="fa fa-plus" aria-hidden="true"></i> Add Farm</button>
            </div>

            <div class="col-md-12 table-responsive">
                <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Slug</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="farm in farms">
                            <td>{{farm.id}}</td>
                            <td>{{farm.slug}}</td>
                            <td>{{farm.name}}</td>
                            <td>{{farm.description}}</td>
                            <td class="controls">
                                <a href="#" class="edit-farm btn btn-md btn-primary" ng-click="postFarm(farm)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-farm btn btn-md btn-danger" ng-click="deleteFarm(farm.id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="postFarmModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{farmObj.id ? 'Edit' : 'Add'}} Menu Farm</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form id="addfarm" ng-submit="farmSubmit(farmObj)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" ng-model="farmObj.name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" ng-model="farmObj.description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>  
    </script>

    <script type="text/ng-template" id="deleteFarmModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Are you sure to delete this item?</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <button type="button" class="btn btn-success" ng-click="delete(farmObj.farmId)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>

<script>
    var url = "<?php echo get_site_url(); ?>";
</script>



