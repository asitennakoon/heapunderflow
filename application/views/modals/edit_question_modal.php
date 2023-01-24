<div class="modal" id="edit-question-modal" tabindex="-1" role="dialog" aria-labelledby="edit-question-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="edit-question-modal-label">Edit Question</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="title" class="control-label">Title:</label>
                        <input type="text" class="form-control" id="edit-title" value="<?= $question->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description:</label>
                        <textarea class="form-control" id="edit-description"><?= $question->description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category" class="control-label">Category:</label>
                        <select class="form-control" id="edit-category">
                            <?php
                            if ($categories) {
                                foreach ($categories as $category) {
                            ?>
                                    <option value="<?= $category->name ?>" <?php if ($category->name == $question->category) { ?>selected<?php } ?>><?= $category->name ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-quiz-changes-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>