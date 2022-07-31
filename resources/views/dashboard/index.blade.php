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
                    </div>
                    <div class="card-body" id="todo-list-content">
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
                                <input type="text" name="name" class="form-control" placeholder="Search user name" aria-label="" value="https:dasdsadasdsa">
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
@endsection

@section('scripts')

    <script type="text/javascript">

        async function totalTodo() {
            let user_id = 941;
            const URL = 'http://127.0.0.1:8000/api/todos/total?user_id=' + user_id;
            fetch(URL)
                .then(response => response.json())
                .then(response => {
                    $('.total-todo').html(response.total);
                });
        }

        async function totalUncompletedTodo() {
            let user_id = 941;
            const URL = 'http://127.0.0.1:8000/api/todos/uncompleted?user_id=' + user_id;
            fetch(URL)
                .then(response => response.json())
                .then(response => {
                    $('.total-uncompleted-todo').html(response.total);
                });

        }

        async function totalCompletedTodo() {
            let user_id = 941;
            const URL = 'http://127.0.0.1:8000/api/todos/completed?user_id=' + user_id;
            fetch(URL)
                .then(response => response.json())
                .then(response => {
                    $('.total-completed-todo').html(response.total);
                });

        }

        // Run Functions
        totalTodo();
        // totalUncompletedTodo();
        // totalCompletedTodo();

        $(document).ready(function() {

            const USER_TODO_URL = "http://127.0.0.1:8000/api/todos?user_id=941&token=23423";

            $(document).on('click', '.btn-submit-todo', function(e) {
                e.preventDefault();
                const STORE_TODO_URL = "http://127.0.0.1:8000/api/todos/store";

                const btn_store = $(".btn-submit-todo");
                const text_btn_store = btn_store.html();

                let body = $('#body');
                let body_value = body.val();

                $.ajax({
                    type: "POST",
                    url: STORE_TODO_URL,
                    data: {
                        body:body_value, 
                        user_id:941, 
                    },
                    beforeSend: () => {
                        btn_store.addClass("disabled btn-progress");
                    } 
                }).done((response, textStatus) => {
                    // update total todo
                    totalTodo();
                    // add into list
                    let cards = showTodoList(response.todo);
                    $('#todo-list-content').prepend(cards);
                    body.summernote('reset');
                    toastr.success(response.message, 'Success');
                }).fail((XMLHttpRequest, textStatus, errorThrown) => {
                    toastr.error(XMLHttpRequest, 'Failed');
                }).always(response => {
                    btn_store.removeClass("disabled btn-progress");
                    btn_store.html(text_btn_store);
                });
            });

            $(document).on('click', '.btn-delete-todo', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                const DELETE_TODO_URL = "http://127.0.0.1:8000/api/todos/" + id + "/destroy";

                const btn_delete = $(this);
                const text_btn_delete = btn_delete.html();

                $.ajax({
                    type: "POST",
                    url: DELETE_TODO_URL,
                    data: {
                        _method: 'DELETE',
                    },
                    beforeSend: () => {
                        btn_delete.addClass("disabled btn-progress");
                    } 
                }).done((response, textStatus) => {
                    // update total todo
                    totalTodo();
                    toastr.success(response.message, 'Success');
                    // remove from list
                    $(this).closest('div.col-12').remove();
                }).fail((XMLHttpRequest, textStatus, errorThrown) => {
                    toastr.error(XMLHttpRequest, 'Failed');
                }).always(response => {
                    btn_delete.removeClass("disabled btn-progress");
                    btn_delete.html(text_btn_delete);
                });
            });

            function showTodoList(val) {
                let date = moment(val.created_at);
                return  `
                    <div class="col-12 col-sm-12 col-md-12" data-todo-id="${val.id}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        ${val.body} 
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-success"><i class="fas fa-check-circle"></i></button>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                            <button data-id="${val.id}" type="button" class="btn btn-sm btn-danger btn-delete-todo"><i class="fas fa-trash-alt"></i></button>
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


            fetch(USER_TODO_URL)
                .then(response => response.json())
                .then(response => {
                    let cards = '';
                    response.todos.forEach(val => cards += showTodoList(val));
                    $('#todo-list-content').html(cards);
                });

            

            // async function getUserTodoDataFromApi(USER_TODO_URL) {
            //     const response = await fetch(USER_TODO_URL);
            //     var data = await response.json();
            //     var data_todos = '';
            //     $.each(data.todos, function(key, val) { 
            //         let date = moment(val.created_at);
            //         var isLastElement = key == data.todos.length -1;
            //         data_todos += `
            //             <div class="d-flex justify-content-between pt-2 pb-4 ${ (!isLastElement) ? 'line-todo' : ' '}">
            //                 <div>
            //                     ${val.body} 
            //                     <div class="mt-2">
            //                         <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
            //                         <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
            //                     </div>
            //                 </div>
            //                 <div>
            //                     ${date.fromNow()}
            //                 </div>
            //             </div>
                        
            //         `;
            //     })
            //     // ${ (!isLastElement) ? "<hr>" : "" }
            //     $('#todo-list-content').html(data_todos);
            // }

            // getUserTodoDataFromApi(USER_TODO_URL);

        });

    </script>

@endsection