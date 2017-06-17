<div ng-app="origins" ng-controller="mainSubTypeController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Types...'}">
    <div class="container" id="all-farm-portal">

        <h3>Origins Menu Sub Types</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="row">

            <div class="col-md-12">
                <button ng-click="postSubType()" class="btn btn-success btn-md" id="add-type"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Type</button>
            </div>

            <div class="col-md-12 table-responsive">
                <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Description</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="subtype in subtypes">
                            <td>{{subtype.id}}</td>
                            <td>{{subtype.name}}</td>
                            <td>{{subtype.parent_name}}</td>
                            <td>{{subtype.description}}</td>
                            <td class="controls">
                                <a href="#" class="edit-subtype btn btn-md btn-primary" ng-click="postSubType(subtype)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-subtype btn btn-md btn-danger" ng-click="postSubType(subtype, 1)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="postSubTypeModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{subtypeObj.id ? 'Edit' : 'Add'}} Menu SubType</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form id="addtype" ng-submit="subtypeSubmit(subtypeObj)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" ng-model="subtypeObj.name" required>
                </div>
                <div class="form-group">
                <label for="parent_type">Parent Type:</label>
                    <select id="parent_type" class="form-control" ng-model="selectedParentType" ng-options="parent_type.name for parent_type in parent_type_option">
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" ng-model="subtypeObj.description"></textarea>
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
            <button type="button" class="btn btn-success" ng-click="delete(subtypeObj.id)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>

<script>
    var url = "<?php echo get_site_url(); ?>";
</script>



