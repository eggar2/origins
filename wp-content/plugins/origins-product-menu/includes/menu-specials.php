<div ng-app="origins" ng-controller="mainSpecialController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Specials...'}">
    <div class="container" id="all-special-portal">

        <h3>Origins Menu specials</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="row">

            <div class="col-md-12">
                <button ng-click="postSpecial()" class="btn btn-success btn-md" id="add-special"><i class="fa fa-plus" aria-hidden="true"></i> Add Special</button>
            </div>

            <div class="col-md-12 table-responsive">
                <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="special in specials">
                            <td>{{special.id}}</td>
                            <td>{{special.name}}</td>
                            <td>{{special.description}}</td>
                            <td class="controls">
                                <a href="#" class="edit-special btn btn-md btn-primary" ng-click="postSpecial(special)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-special btn btn-md btn-danger" ng-click="deleteSpecial(special.id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="postSpecialModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{specialObj.id ? 'Edit' : 'Add'}} Menu Special</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form id="addspecial" ng-submit="specialSubmit(specialObj)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" ng-model="specialObj.name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" ng-model="specialObj.description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>  
    </script>

    <script type="text/ng-template" id="deleteSpecialModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Are you sure to delete this item?</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <button type="button" class="btn btn-success" ng-click="delete(specialObj.specialId)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>

<script>
    var url = "<?php echo get_site_url(); ?>";
</script>



