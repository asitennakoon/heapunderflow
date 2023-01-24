<div class="container">
    <div id="question-section">
        <div class="col-md-12 row question-container" style="padding-top: 0">
            <div>
                <input id="question-id" type="hidden" value="<?= $question->id ?>">
                <h2 style="display: inline-block" id="title"><?= $question->title ?></h2>
                <a id="edit-question-link" style="display: inline-block; margin-left: 10px" href="#">Edit</a>
                <a id="delete-question-link" style="display: inline-block; margin-left: 10px" href="#">Delete</a>
            </div>

            <div class="col-md-1">
                <div class="row center-content"><a class="btn btn-link upvote-btn"><span class="glyphicon glyphicon-chevron-up"></span></a></div>
                <div class="row"><strong><span id="upvote-count" class="form-control text-center"><?= $question->upvoteCount ?></span></strong></div>
                <div class="row center-content"> <a class="btn btn-link downvote-btn"><span class="glyphicon glyphicon-chevron-down"></span></a></div>
            </div>

            <div class="col-md-11">
                <h4 id="description"><?= $question->description ?></h4>
                <a href="<?= base_url() ?>index.php/question/question/category/<?= $question->category ?>" id="category-url">
                    <div class="label label-default tag-container" id="category">
                        <?= $question->category ?>
                    </div>
                </a>

                <div class="row">
                    <div class="row username-text"><a href=""><?= $question->username ?></a></div>
                    <div class="row username-text"><?= $question->date ?></div>
                </div>
            </div>
        </div>

        <?php $this->load->view('modals/edit_question_modal.php'); ?>
    </div>

    <div id="answers-section" class="row col-md-12">
        <h3>Answers (<span id="answer-count"><?= $question->answerCount ?></span>)</h3>
        <div id="answers-list"></div>

        <?php $this->load->view('modals/edit_answer_modal.php'); ?>
    </div>

    <div class="col-md-12">
        <div class="row answer-from">
            <h3>Your Answer</h3>
            <form id="answer-form">
                <div class="form-group">
                    <textarea id="answer-description" rows="8" cols="70"></textarea>
                </div>
                <a id="answer-submit-btn" class="btn btn-success">Answer</a>
            </form>
        </div>
    </div>
</div>


<script type="text/template" id="answer-template">
    <div class="row answer-container" style="margin-left: 0; margin-right: 0">
        <div class="col-md-1">
            <div class="row center-content"><a class="btn btn-link upvote-btn" data-answer-id="<%= id %>"><span class="glyphicon glyphicon-chevron-up"></span></a></div>
            <div class="row"><span class="form-control text-center"><strong><%= upvoteCount %></strong></span></div>
            <div class="row center-content"><a class="btn btn-link downvote-btn" data-answer-id="<%= id %>"><span class="glyphicon glyphicon-chevron-down"></span></a></div>
        </div>
        <div class="col-md-11">
            <span><%= description %></span>
            <div class="row">
                <div class="col-md-3">
                    <a class="edit-answer-link" href="#" data-answer-id="<%= id %>" data-description="<%= description %>">Edit</a>
                    <a class="delete-answer-link" href="#" data-answer-id="<%= id %>" style="margin-left: 10px">Delete</a>
                </div>
                <div class="row username-text"><a href=""><%= username %></a></div>
                <div class="row username-text"><%= date %></div>
            </div>
        </div>
    </div>
</script>

<script>
    let Question = Backbone.Model.extend({
        defaults: {
            id: '',
            title: '',
            category: '',
            description: ''
        },

        validate: function(attributes) {
            if (!attributes.title) {
                return 'Title is required';
            }
        },

        url: '<?= base_url() ?>index.php/question/question'
    });

    let QuestionSectionView = Backbone.View.extend({
        el: '#question-section',

        events: {
            'click #save-quiz-changes-btn': 'saveQuizChanges',
            'click #delete-question-link': 'deleteQuiz',
            'click .upvote-btn': 'upvote',
            'click .downvote-btn': 'downvote'
        },

        saveQuizChanges: function() {
            let question = new Question({});

            question.save({
                id: this.$('#question-id').val(),
                title: this.$('#edit-title').val(),
                category: this.$('#edit-category').val(),
                description: this.$('#edit-description').val()
            }, {
                patch: true,

                success: function(model, response) {
                    $('#edit-question-modal').modal('hide');

                    //update the question section with the updated data
                    $('#title').text(response.title);
                    $('#description').text(response.description);
                    $('#category').text(response.category);
                    $('#category-url').attr('href', '<?= base_url() ?>index.php/question/question/category/' + response.category);

                    //update the modal with the updated data
                    $('#edit-title').val(response.title);
                    $('#edit-description').val(response.description);
                    $('#edit-category').val(response.category);
                },
                error: function(model, response) {
                    console.log(response);
                }
            });
        },

        deleteQuiz: function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this question?")) {
                let question = new Question({});

                question.destroy({
                    url: '<?= base_url() ?>index.php/question/question/' + $('#question-id').val(),

                    success: function(model, response) {
                        window.location.href = '<?= base_url() ?>index.php/question/question';
                    },
                    error: function(model, response) {
                        console.log(response);
                    }
                });
            }
        },

        upvote: function(e) {
            $.ajax({
                url: '<?= base_url() ?>index.php/question/upvote',
                method: 'POST',
                data: {
                    id: this.$('#question-id').val()
                },
                success: function(response) {
                    $('#upvote-count').text(response['upvoteCount']);
                }
            });
        },

        downvote: function(e) {
            $.ajax({
                url: '<?= base_url() ?>index.php/question/downvote',
                method: 'POST',
                data: {
                    id: this.$('#question-id').val()
                },
                success: function(response) {
                    $('#upvote-count').text(response['upvoteCount']);
                }
            });
        }
    });

    let questionSectionView = new QuestionSectionView();


    // Defining the Answer model
    let Answer = Backbone.Model.extend({
        // Defining the default attributes for an answer
        defaults: {
            questionId: '',
            description: ''
        },

        // Defining the URL where the model should be sent
        url: '<?= base_url() ?>index.php/answer/answer'
    });

    // Defining the Answer collection
    let Answers = Backbone.Collection.extend({
        model: Answer,
        url: '<?= base_url() ?>index.php/answer/answers/questionId/<?= $question->id ?>'
    });

    let answers = new Answers();

    let AnswersSectionView = Backbone.View.extend({
        model: answers,
        el: '#answers-section',
        template: _.template($('#answer-template').html()),

        initialize: function(options) {
            if ($('#answer-count').text() > 0) {
                answers.fetch({
                    async: false
                });
            }
            this.render();
            this.model.on('add', this.render, this).on('change', this.render, this).on('remove', this.render, this);
        },

        render: function() {
            let html = '';
            let that = this;

            answers.each(function(answer) {
                html += that.template({
                    id: answer.id,
                    username: answer.get('username'),
                    description: answer.get('description'),
                    date: answer.get('date'),
                    upvoteCount: answer.get('upvoteCount')
                });
            });

            this.$('#answers-list').html(html);
        },

        events: {
            'click #save-answer-changes-btn': 'saveAnswerChanges',
            'click .delete-answer-link': 'deleteAnswer',
            'click .upvote-btn': 'upvote',
            'click .downvote-btn': 'downvote'
        },

        saveAnswerChanges: function() {
            let answer = new Answer({});

            answer.save({
                id: this.$('#edit-answer-id').val(),
                description: this.$('#edit-answer').val()
            }, {
                patch: true,

                success: function(model, response) {
                    $('#edit-answer-modal').modal('hide');

                    let answer = answers.get(response['id']);
                    answer.set({
                        'description': response['description']
                    });
                },
                error: function(model, response) {
                    console.log(response);
                }
            });
        },

        deleteAnswer: function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this answer?")) {
                let id = $(e.currentTarget).data('answer-id');
                let answer = new Answer({
                    id: id
                });

                answer.destroy({
                    url: '<?= base_url() ?>index.php/answer/answer/' + id,

                    success: function(model, response) {
                        console.log("Success");
                        let answer = answers.get(id);
                        answers.remove(answer);
                        $('#answer-count').html(answers.length);
                    },
                    error: function(model, response) {
                        console.log("Failure");
                        console.log(response);
                    }
                });
            }
        },

        upvote: function(e) {
            $.ajax({
                url: '<?= base_url() ?>index.php/answer/upvote',
                method: 'POST',
                data: {
                    answerId: $(e.currentTarget).data('answer-id')
                },
                success: function(response) {
                    let answer = answers.get(response['id']);
                    answer.set({
                        'upvoteCount': response['upvoteCount']
                    });
                }
            });
        },

        downvote: function(e) {
            $.ajax({
                url: '<?= base_url() ?>index.php/answer/downvote',
                method: 'POST',
                data: {
                    answerId: $(e.currentTarget).data('answer-id')
                },
                success: function(response) {
                    let answer = answers.get(response['id']);
                    answer.set({
                        'upvoteCount': response['upvoteCount']
                    });
                }
            });
        }
    });

    let answersSectionView = new AnswersSectionView();

    // Defining the Answer Form View
    let AnswerFormView = Backbone.View.extend({
        el: '#answer-form',

        // Defining the events for the view
        events: {
            'click #answer-submit-btn': 'submitAnswer'
        },

        // Defining the submitAnswer function
        submitAnswer: function() {
            let answer = new Answer({
                questionId: $('#question-id').val(),
                description: this.$('#answer-description').val()
            });

            answer.save({}, {
                success: function(model, response) {
                    answers.add(response);
                    $('#answer-count').html(answers.length);
                },
                error: function(model, response) {
                    console.log(response);
                }
            });
        }
    });

    let answerFormView = new AnswerFormView();

    $('#edit-question-link').on('click', function(e) {
        e.preventDefault();
        $('#edit-question-modal').modal('show');
    });

    $('#answers-section').on('click', '.edit-answer-link', function(e) {
        e.preventDefault();
        $('#edit-answer-id').val($(this).data('answer-id'));
        $('#edit-answer').val($(this).data('description'));

        $('#edit-answer-modal').modal('show');
    });

    $('[data-dismiss="modal"]').click(function() {
        $('.modal').modal('hide');
    });
</script>