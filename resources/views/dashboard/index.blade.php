@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total User & Admin</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_admin ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Todo List</h4>
                        </div>
                        <div class="card-body total-todo">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Unfinished Todo</h4>
                        </div>
                        <div class="card-body total-uncompleted-todo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Completed Todo</h4>
                        </div>
                        <div class="card-body total-completed-todo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Todo</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <label for=""></label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control summernote"></textarea>
                            </div>
                            <div class="d-flex float-right">
                                <button class="btn btn-primary float-right btn-submit-todo">
                                    <i class="fas fa-plus-circle"></i> Create
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Todo Lists</h4>
                        <div class="card-header-action">
                            <div class="btn-group mb-3" role="group">
                                <button type="button" class="btn btn-danger btn-show-uncompleted btn-icon icon-left">
                                    <i class="fas fa-times-circle"></i> Uncompleted
                                </button>
                                <button type="button" class="btn btn-success btn-show-completed  btn-icon icon-left">
                                    <i class="fas fa-check-circle"></i> Completed
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="todo-list-content">
                        <div class="uncompleted-todo"></div>
                        <div class="completed-todo"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Share Your Todo List (API) &mdash; <i class="far fa-smile" style="font-size: 18px;"></i></h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary">Generate My API</button>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Search user name"
                                    aria-label="" value="https:dasdsadasdsa">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary" type="button">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editTodoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" name="edit_todo_id" id="edit_todo_id">
                        <div class="form-group">
                            <label for=""></label>
                            <textarea name="edit_body" id="edit_body" cols="30" rows="10" class="form-control summernote"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-todo">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {

            let user_id = "{{ auth()->user()->id }}";
            let token = "3243";
            let completed_status = "{{ \App\TodoList::STATUS_COMPLETED }}";
            let uncompleted_status = "{{ \App\TodoList::STATUS_UNCOMPLETED }}";

            async function totalTodo() {
                fetch('http://127.0.0.1:8000/api/todos/total?user_id=' + user_id)
                    .then(response => response.json())
                    .then(response => {
                        $('.total-todo').html(response.total);
                    });
            }

            async function totalUncompletedTodo() {
                fetch('http://127.0.0.1:8000/api/todos/total_uncompleted?user_id=' + user_id)
                    .then(response => response.json())
                    .then(response => {
                        $('.total-uncompleted-todo').html(response.total);
                    });

            }

            async function totalCompletedTodo() {
                fetch('http://127.0.0.1:8000/api/todos/total_completed?user_id=' + user_id)
                    .then(response => response.json())
                    .then(response => {
                        $('.total-completed-todo').html(response.total);
                    });

            }

            function todoCard(val) {
                let date = moment(val.created_at);

                let is_complete_button = '';
                let complete_button = `<button type="button" class="btn btn-sm btn-success btn-complete-todo" data-id="${val.id}"><i class="fas fa-check-circle"></i></button>`;
                let uncomplete_button = `<button type="button" class="btn btn-sm btn-warning btn-uncomplete-todo" data-id="${val.id}"><i class="fas fa-times-circle"></i></button>`;

                if (val.is_complete == completed_status) {
                    is_complete_button = uncomplete_button;
                } else {
                    is_complete_button = complete_button;
                }

                return `
                    <div class="col-12 col-sm-12 col-md-12" data-todo-id="${val.id}" data-todo-status="${val.is_complete}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        ${val.body} 
                                        <div class="mt-2">
                                            ${is_complete_button}
                                            <button type="button" class="btn btn-sm btn-primary btn-edit-todo" data-id="${val.id}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-todo" data-id="${val.id}"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                    <div>
                                        ${date.fromNow()}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            function fetchAllTodos() {
                fetch("http://127.0.0.1:8000/api/todos?user_id="+user_id+"&token=23423")
                .then(response => response.json())
                .then(response => {
                    let card = '';
                    let section_completed = $('.completed-todo');
                    let section_uncompleted = $('.uncompleted-todo');
                    section_completed.html('');
                    section_uncompleted.html('');
                    // section_completed.addClass('d-none');
                    response.todos.forEach(val => {
                        card = todoCard(val);
                        if (val.is_complete == completed_status) {
                            section_completed.prepend(card);
                        } else {
                            section_uncompleted.prepend(card);
                        }
                    });
                });
            }

            // run functions
            totalTodo();
            totalUncompletedTodo();
            totalCompletedTodo();
            fetchAllTodos();

            $('.btn-show-completed').click(function(e) {
                e.preventDefault();
                $('.completed-todo').removeClass('d-none');
                $('.uncompleted-todo').addClass('d-none');
            });

            $('.btn-show-uncompleted').click(function(e) {
                e.preventDefault();
                $('.uncompleted-todo').removeClass('d-none');
                $('.completed-todo').addClass('d-none');
            });

            $(document).on('click', '.btn-submit-todo', function(e) {
                e.preventDefault();

                let btn_store = $(".btn-submit-todo");
                let text_btn_store = btn_store.html();

                let body = $('#body');
                let body_value = body.val();

                if(body.summernote('isEmpty')) {
                    toastr.error('Write something before submit!', 'Failed');
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/todos/store",
                    data: {
                        body: body_value,
                        user_id: user_id,
                    },
                    beforeSend: () => {
                        btn_store.addClass("disabled btn-progress");
                    }
                }).done((response, textStatus) => {
                    totalTodo();
                    totalUncompletedTodo();
                    // add into list
                    let cards = todoCard(response.todo);
                    $('#todo-list-content div.uncompleted-todo').prepend(cards);
                    body.summernote('reset');
                    toastr.success(response.message, 'Success');
                }).fail(ajaxFailHandler)
                .always(response => {
                    btn_store.removeClass("disabled btn-progress");
                    btn_store.html(text_btn_store);
                });
            });

            $(document).on('click', '.btn-complete-todo', function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');

                let btn = $(this);
                let text_btn = btn.html();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/todos/" + id + "/complete",
                    data: {
                        _method: 'PUT',
                    },
                    beforeSend: () => {
                        btn.addClass("disabled btn-progress");
                    }
                }).done((response, textStatus) => {
                    totalTodo();
                    totalCompletedTodo();
                    totalUncompletedTodo();
                    toastr.success(response.message, 'Success');
                    // refresh todo list
                    fetchAllTodos();
                }).fail(ajaxFailHandler)
                .always(response => {
                    btn.removeClass("disabled btn-progress");
                    btn.html(text_btn);
                });
            });

            $(document).on('click', '.btn-uncomplete-todo', function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');

                let btn = $(this);
                let text_btn = btn.html();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/todos/" + id + "/uncomplete",
                    data: {
                        _method: 'PUT',
                    },
                    beforeSend: () => {
                        btn.addClass("disabled btn-progress");
                    }
                }).done((response, textStatus) => {
                    totalTodo();
                    totalCompletedTodo();
                    totalUncompletedTodo();
                    toastr.success(response.message, 'Success');
                    // refresh todo list
                    fetchAllTodos();
                }).fail(ajaxFailHandler)
                .always(response => {
                    btn.removeClass("disabled btn-progress");
                    btn.html(text_btn);
                });
            });

            $(document).on('click', '.btn-edit-todo', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                fetch("http://127.0.0.1:8000/api/todos/" + id + "/specific-show?user_id=" + user_id + "&token=" + token)
                .then(response => response.json())
                .then(response => {
                    $("#edit_todo_id").val(response.todo.id);
                    $("#edit_body").summernote('code',response.todo.body);
                });

                $('#editTodoModal').modal('show');
            });

            $(document).on('click', '.btn-save-todo', function(e) {
                e.preventDefault();

                let btn = $(this);
                let text_btn = btn.html();

                let id = $("#edit_todo_id").val();
                let body = $("#edit_body");

                if(body.summernote('isEmpty')) {
                    toastr.error('Write something before submit!', 'Failed');
                    return false;
                }
                
                let body_value = body.summernote("code");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/todos/" + id + "/update?user_id=" + user_id + "&token=" + token,
                    data: {
                        _method: 'PUT',
                        body:body_value,
                    },
                    beforeSend: () => {
                        btn.addClass("disabled btn-progress");
                    }
                }).done((response, textStatus) => {
                    fetchAllTodos();
                    toastr.success(response.message, 'Success');
                    $('#editTodoModal').modal('hide');
                }).fail(ajaxFailHandler)
                .always(response => {
                    btn.removeClass("disabled btn-progress");
                    btn.html(text_btn);
                });
            });

            $(document).on('click', '.btn-delete-todo', function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');

                const btn_delete = $(this);
                const text_btn_delete = btn_delete.html();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/todos/" + id + "/destroy",
                    data: {
                        _method: 'DELETE',
                    },
                    beforeSend: () => {
                        btn_delete.addClass("disabled btn-progress");
                    }
                }).done((response, textStatus) => {
                    totalTodo();
                    totalCompletedTodo();
                    totalUncompletedTodo();
                    toastr.success(response.message, 'Success');
                    // remove from list
                    $(this).closest('div.col-12').remove();
                }).fail(ajaxFailHandler)
                .always(response => {
                    btn_delete.removeClass("disabled btn-progress");
                    btn_delete.html(text_btn_delete);
                });
            });

        });

    </script>

@endsection
