<?php use app\modules\admin\models\Categories; ?>

<h1>Categories</h1>

<!-- Tree categories -->
<div class="tree_cat">
    <div class="btn btn-primary sortByName">
      Sort by name <span>ASC</span>
    </div>

    <div class="btn btn-primary sortByName">
      Sort by name <span>DESC</span>
    </div>
    <div class="main_cat2">
        <!--<span class="add_new_cat " onClick="addMainInput()">Add new cathegory</span>-->
        <form id="main_cat_mainform2" onsubmit="addFirstCategory();return false;">
           <input type="text" id="t0" class="form-control tree_cat_inp2" required="required" placeholder="Add new cathegory" />
           <!--<input type="submit" class="btn btn-primary tree_cat_sub" value="add" />-->
        </form>
    </div>
    <?php echo Categories::recursionForArray($all_category); ?>
</div>

<div class="modal-popup">
  <div class="blackBg"></div>
  <div class="categoryEditModal">
    <div class="liDel close--modal" onclick="modalJS.hideModal(); return false;"></div>
    <div class="modal-wrapper">
      <form method="POST" action="#">
      <div class="modal-header">
        <div class="modal-title">
          Edit category
        </div>
      </div>
      <div class="modal--content">
        <div class="cathegory_textarea">
          <label for="parent_cat">Parent cathegory</label>
          <select id="parent_cat" name="parent_cat">
            <option value='0'>None</option>
            <?php foreach ($parents_category as $categ): ?>
              <option value='<?= $categ['id'] ?>'><?= $categ['category'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="cathegory_textarea">
          <label for="cat_name">Category name: </label>
          <input type="text" id="cat_name" name="cat_name" val="" />
          <input type="hidden" id="cat_id" name="cat_id" val="" />
        </div>
        <div class="cathegory_textarea">
          <label for="cat_name">Category title: </label>
          <input type="text" id="cat_title" name="cat_title" val="" />
        </div>
        <div class="cathegory_textarea">
          <label for="cat_keywords">Meta keywords: </label>
          <textarea class="modal-textarea" id="cat_keywords" name="cat_keywords"></textarea>
        </div>
        <div class="cathegory_textarea">
          <label for="cat_description">Meta description: </label>
          <textarea class="modal-textarea" id="cat_description" name="cat_description"></textarea>
        </div>
        <div class="cathegory_textarea">
          <label for="cat_text_above">Text above content: </label>
          <textarea class="modal-textarea" id="cat_text_above" name="cat_text_above"></textarea>
        </div>
      </div>
        <div class="modal-footer">
          <div class="proccess processing">
            Processing...
          </div>
          <div id="modalAction" class="modal_btm btn btn-success">Save</div>
        </div>
      </form>
    </div>
  </div>
</div>
