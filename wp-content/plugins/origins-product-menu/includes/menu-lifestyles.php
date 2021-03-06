<div ng-app="origins" ng-controller="mainLifestyleController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Lifestyles...'}">
    <div class="container" id="all-lifestyle-portal">

        <h3>Origins Menu Lifestyles</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <div class="row">

            <div class="col-md-12">
                <button ng-click="postLifestyle()" class="btn btn-success btn-md" id="add-lifestyle"><i class="fa fa-plus" aria-hidden="true"></i> Add Lifestyle</button>
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
                        <tr ng-repeat="lifestyle in lifestyles">
                            <td>{{lifestyle.id}}</td>
                            <td>{{lifestyle.slug}}</td>
                            <td>{{lifestyle.name}}</td>
                            <td>{{lifestyle.description}}</td>
                            <td class="controls">
                                <a href="#" class="edit-lifestyle btn btn-md btn-primary" ng-click="postLifestyle(lifestyle)" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="delete-lifestyle btn btn-md btn-danger" ng-click="deleteLifestyle(lifestyle.id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

    </div>

    <script type="text/ng-template" id="postLifestyleModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">{{lifestyleObj.id ? 'Edit' : 'Add'}} Menu Lifestyle</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <form id="addlifestyle" ng-submit="lifestyleSubmit(lifestyleObj)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" ng-model="lifestyleObj.name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" ng-model="lifestyleObj.description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>  
    </script>

    <script type="text/ng-template" id="deleteLifestyleModal.html">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Are you sure to delete this item?</h3>
        </div>
        <div class="modal-body" id="modal-body">
            <button type="button" class="btn btn-success" ng-click="delete(lifestyleObj.lifestyleId)">Yes</button>
            <button type="button" class="btn btn-danger" ng-click="cancel()">No</button>
        </div>  
    </script>

</div>

<script>
    var url = "<?php echo get_site_url(); ?>";
</script>



