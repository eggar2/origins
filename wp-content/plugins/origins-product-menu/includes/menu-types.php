<div ng-app="origins" ng-controller="mainTypeController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Types...'}">
    <div class="container" id="all-farm-portal">

        <h3>Origins Menu Types</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="row">

            <div class="col-md-12">
                <button ng-click="postType()" class="btn btn-success btn-md" id="add-type"><i class="fa fa-plus" aria-hidden="true"></i> Add Type</button>
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
                        <tr ng-repeat="type in types">
                            <td>{{type.id}}</td>
                            <td>{{type.slug}}</td>
                            <td>{{type.name}}</td>
                            <td>{{type.description}}</td>
                            <td class="controls">
                                <a href="#" class="edit-type btn btn-md btn-primary" ng-click="postType(type)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-type btn btn-md btn-danger" ng-click="deleteType(type.id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="newTypeModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{typeObj.id ? 'Edit' : 'Add'}} Menu Type</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form id="addtype" ng-submit="typeSubmit(typeObj)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" ng-model="typeObj.name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" ng-model="typeObj.description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>  
    </script>

    <script type="text/ng-template" id="deleteTypeModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Are you sure to delete this type?</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <button type="button" class="btn btn-success" ng-click="delete(typeObj.typeId)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>

<script>
    var url = "<?php echo get_site_url(); ?>";
</script>



