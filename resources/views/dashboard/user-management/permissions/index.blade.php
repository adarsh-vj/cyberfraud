@extends('layouts.app')

@section('content')
    <!-- container -->
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div>
                <h4 class="content-title mb-2">
                    Hi, welcome back!
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">User Management</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Permission
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!-- /breadcrumb -->
        <!-- main-content-body -->
        <div class="main-content-body">



            <!-- row -->
            <div class="row row-sm">
                <div class="col-md-12 col-xl-12">
                    <div class="card overflow-hidden review-project">
                        <div class="card-body">
                            <div class=" m-4 d-flex justify-content-between">

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class=" m-4 d-flex justify-content-between">
                                <h4 class="card-title mg-b-10">
                                    All Permissions
                                </h4>
                                <div class="col-md-1 col-6 text-center">
                                    <div class="task-box primary  mb-0">
                                        <a class="text-white" href="{{ route('permissions.create') }}">
                                            <p class="mb-0 tx-12">Add </p>
                                            <h3 class="mb-0"><i class="fa fa-plus"></i></h3>
                                        </a>
                                    </div>
                                </div>
                            </div>



                            <div class="table-responsive mb-0">
                                <table id="users-table"
                                    class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Permission</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->


        </div>
        <!-- /row -->
    </div>

    {{-- <script>
        jQuery(document).ready(function() {

            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('get.permissions') }}', // Provide the route for fetching data
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        name: 'si_no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="/permissions/' + data.id +
                                '/edit" class = "btn btn-primary edit-btn"> Edit </a>' +
                                '<button class="btn btn-danger delete-btn"zzzz data - id = "' + data
                                .id + '">Delete</button>';
                        }
                    }
                ]
            });
        });
    </script> --}}

    <script>
       $(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('get.permissions') }}',
            data: function(d) {
                return d; // Sending all DataTable parameters
            }
        },
        columns: [{
                data: null,
                render: function(data, type, row) {
                    return type === 'display' && data.rowIndex + 1; // Add 1 to row index to start numbering from 1
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return '<a href="/permissions/' + data.id + '/edit" class="btn btn-primary edit-btn">Edit</a>' +
                        '<button class="btn btn-danger delete-btn" data-id="' + data.id + '">Delete</button>';
                }
            }
        ]
    }).on('error.dt', function(e, settings, techNote, message) {
        console.error('DataTables error:', message);
    });
});

    </script>

@endsection
