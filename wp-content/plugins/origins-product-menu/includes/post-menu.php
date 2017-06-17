<div ng-app="origins" ng-controller="postMenuController" dw-loading="origins-loading" dw-loading-options="{text: 'Loading Menu...'}">
    <div class="container" id="post-menu-portal">

        <h3><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Menu</h3>

        <hr style="border: 3px solid rgba(49,37,28,0.9);"> 

        <form ng-submit="postMenu(menu)" id="post-menu-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" ng-model="menu.name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea rows="4" class="form-control" id="description" ng-model="menu.description"></textarea>
            </div>
            <div class="form-group">
                <label for="cbs_ratio">CBS Ratio</label>
                <input type="text" class="form-control" id="cbs_ratio" ng-model="menu.cbs_ratio">
            </div>
            <div class="form-group">
                <label for="lab_result_link">Lab Results</label>
                <input type="text" id="image_url" class="form-control" ng-model="lab_result_link">
                <input type="button" name="upload-btn" id="upload-btn" class="btn btn-primary btn-md" value="Select File">
            </div>

            <div class="form-group">
                <label for="farm">Farm:</label>
                <select ng-model="selectedFarm" id="farm" class="form-control" ng-options="farm.name for farm in farms track by farm.id">
                    <option value="">Choose Farm</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" ng-model="selectedType" ng-change="onTypeSelected(selectedType)" ng-options="t.name for t in type_options" required>
                    <option value="">Choose Type</option>
                </select>
            </div>

            <div class="form-group" ng-if="selectedType">
                <label for="type">Sub Type:</label>
                <select class="form-control" id="subtype" ng-model="selectedSubType" ng-options="s.name for s in subtype_options_filtered" required>
                    <option value="">Choose Sub Type</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lifestyle">Lifestyle:</label>
                <select id="lifestyle" class="form-control" ng-model="selectedLifestyle" ng-options="lifestyle.name for lifestyle in lifestyles" required>
                    <option value="">Choose Lifestyle</option>
                </select>
            </div>

            <div class="form-group">
                <label for="special">Designation:</label>
                <select id="special" class="form-control" ng-model="selectedSpecialTags" ng-options="special_tags.name for special_tags in special_tags_option">
                    <option value="">Choose Designation</option>
                </select>
            </div>

            <div class="form-group" id="prices_input">
                <label for="prices">Prices: </label>
                <div ng-repeat="price in prices track by $index" class="price-item clearfix">
                    <input type="text" ng-model="price.weight" class="form-control pull-left" placeholder="Weight" required>
                    <input type="text" ng-model="price.price" class="form-control pull-left" placeholder="Price" required>
                    <button type="button" class="btn btn-md btn-danger" ng-show="$last" ng-click="removePrice()">Remove</button>
                </div>
                <button type="button" class="btn btn-md btn-primary clearfix" ng-click="addNewPrice()">Add Price</button>
            </div>

            <hr>

            <button type="submit" class="btn btn-success">Submit</button>
            <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_menu" type="button" class="btn btn-danger">Cancel</a>
        </form>

    </div>
</div>
<script>
    var url = "<?php echo get_site_url(); ?>";
    var menus_url = "<?php echo get_site_url(); ?>/wp-admin/admin.php?page=origins_menu";
    var menu_to_edit = "<?php echo $_GET['edit']; ?>"
    jQuery(document).ready(function($){
        $('#upload-btn').click(function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#image_url').val(image_url);
        });
        });
    });
</script>
