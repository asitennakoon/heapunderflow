<div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editModalLabel">Edit Question</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="title" class="control-label">Title:</label>
                        <input type="text" class="form-control" id="title" value="<?= $question->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description:</label>
                        <textarea class="form-control" id="description"><?= $question->description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category" class="control-label">Category:</label>
                        <select class="form-control" id="category">
                            <option value="<?= $question->category ?>" selected><?= $question->category ?></option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>