<div class="container">
    <h2>Ask Question</h2>

    <form id="question-form" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="title" class="col-sm-1 control-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="Title">
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="col-sm-1 control-label">Category</label>
            <div class="col-sm-10">
                <select id="category">
                    <?php
                    if ($categories) {
                        foreach ($categories as $category) {
                    ?>
                            <option value="<?= $category->name ?>"><?= $category->name ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <!-- <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true"> Dropdown <span class="caret"></span> </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a> </li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a> </li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a> </li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a> </li>
                    </ul>
                </div> -->
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-1 control-label">Description</label>
            <div class="col-sm-10">
                <textarea rows="5" class="form-control" id="description" placeholder="Description"></textarea>
            </div>
        </div>

        <!-- <div class="form-group">
            <label for="tags" class="col-sm-1 control-label">Tags</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="tags" placeholder="Tags">
            </div>
        </div> -->

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <a id="submit-btn" class="btn btn-success">Post</a>
            </div>
        </div>
    </form>
</div>

<script>
    // Defining the Question model
    let Question = Backbone.Model.extend({
        // Defining the default attributes for a question
        defaults: {
            title: '',
            category: '',
            description: ''
        },

        // Defining the validation rules for the model
        validate: function(attributes) {
            if (!attributes.title) {
                return 'Title is required';
            }
        },

        // Defining the URL where the model should be sent
        url: '<?= base_url() ?>index.php/question/question'
    });

    // Defining the QuestionForm View
    let QuestionFormView = Backbone.View.extend({
        el: '#question-form',

        // Defining the events for the view
        events: {
            'click #submit-btn': 'submitQuestion'
        },

        // Defining the submitQuestion function
        submitQuestion: function() {
            let question = new Question({
                title: this.$('#title').val(),
                category: this.$('#category').val(),
                description: this.$('#description').val()
            });

            question.save({}, {
                success: function(model, response) {
                    window.location.href = '<?= base_url() ?>index.php/question/question/id/' + response.id;
                },
                error: function(model, response) {
                    console.log(response.error);
                }
            });
        }
    });

    // Instantiating the QuestionForm View
    let questionFormView = new QuestionFormView();
</script>