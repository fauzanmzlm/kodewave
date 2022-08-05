@extends('layouts.master')

@section('title')
    Manage Users
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Users</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Manage Users</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Users</h2>
      <p class="section-lead">
        On this page you can manage all users susch as create, edit, update and delete.
      </p>

      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
                <h4>All Users</h4>
                <div class="card-header-action">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class=" float-left">
                            <form action="" method="get">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" name="name" class="form-control" placeholder="Search user name" aria-label="" value="{{ $_GET['name'] ?? '' }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive ">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Total Todo Lists</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + $users->firstItem() }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->todo_lists->count() }}</td>
                                            <td class="py-2">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary mb-1"><i class="fas fa-eye"></i> View</a>
                                                <br>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary mb-1"><i class="fas fa-edit"></i> Edit</a>
                                                <br>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection