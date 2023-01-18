<div class="container">
    <div id="question-section">
        <div class="col-md-12 row question-container" style="padding-top: 0">
            <div>
                <h2 style="display: inline-block"><?= $question->title ?></h2>
                <a style="display: inline-block; margin-left: 10px" href="#" data-toggle="modal" data-target="#editModal">Edit</a>
                <a style="display: inline-block; margin-left: 10px" href="delete">Delete</a>
            </div>

            <div class="col-md-1">
                <div class="row center-content"><a class="btn btn-link"><span class="glyphicon glyphicon-chevron-up"></span></a></div>
                <div class="row"><span class="form-control text-center"><strong><?= $question->upvoteCount ?></strong></span></div>
                <div class="row center-content"> <a class="btn btn-link"><span class="glyphicon glyphicon-chevron-down"></span></a></div>
            </div>

            <div class="col-md-11">
                <h4><?= $question->description ?></h4>
                <a href="<?= base_url() ?>index.php/question/index/category/<?= $question->category ?>">
                    <div class="label label-default tag-container">
                        <?= $question->category ?>
                    </div>
                </a>

                <div class="row">
                    <div class="row username-text"><a href=""><?= $question->username ?></a></div>
                    <div class="row username-text"><?= $question->date ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row col-md-12">
        <h3>Answers (<span id="answer-count"><?= $question->answerCount ?></span>)</h3>
        <div id="answers-section"></div>
    </div>

    <div class="col-md-12">
        <div class="row answer-from">
            <h3>Your Answer</h3>
            <form id="answer-form">
                <div class="form-group">
                    <textarea id="answer-description" rows="8" cols="70"></textarea>
                </div>
                <input id="question-id" type="hidden" value="<?= $question->id ?>">
                <a id="answer-submit-btn" class="btn btn-success">Answer</a>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('modals/edit_question_modal.php'); ?>


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
                <div class="col-md-3"><a href="edit">Edit</a><a href="delete" style="margin-left: 10px">Delete</a></div>
                <div class="row username-text"><a href=""><%= username %></a></div>
                <div class="row username-text"><%= date %></div>
            </div>
        </div>
    </div>
</script>

<script>
    // Defining the Answer model
    let Answer = Backbone.Model.extend({
        // Defining the default attributes for an answer
        defaults: {
            questionId: '',
            description: '',
            date: '',
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
            answers.fetch({
                async: false
            });
            this.render();
            this.model.on('add', this.render, this).on('change', this.render, this);
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

            this.$el.html(html);
        },

        events: {
            'click .upvote-btn': 'upvote',
            'click .downvote-btn': 'downvote'
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
                questionId: this.$('#question-id').val(),
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
</script>