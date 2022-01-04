<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="container">

        <div class="card">
            <div class="card-header">
                <h2>{{$title}}</h2>
                <div class="d-flex flex-row-reverse">
                    <a href="/googlemap">
                        <button  class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" >
                            <i class="fas fa-road"></i>View Runway
                        </button>
                    </a>



                </div>
            </div>

            <div class="card-body">
                <div class="col-md-12">
{{--                    Uploading the dataset for training--}}
{{--                    <div class="table-responsive">--}}
                        <div class="row" >
                            <div class="col-lg-14">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Train and Test Data Import
                                    </header>
                                    <div class="panel-body">
                                        <!-- <h3 align="center">Import Sales Temp Excel File </h3> -->
                                        <br/>

                                        @if(count($errors) > 0)
                                            <div class="alert alert-danger">
                                                Upload Validation Error<br><br>
                                                <ul>

                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <table class="table">
                                                <form method="post" enctype="multipart/form-data" action="{{ url('/ml_input/train') }}">
                                                    {{ csrf_field() }}


                                                    <tr>



                                                    </tr>

                                                    <tr>
                                                        <td width="10%" align="left"><label><b>Select File for Training</b></label>
                                                        </td>
                                                        <td width="10">
                                                            <input type="file" name="select_file"/>
                                                        </td>
                                                        <td width="10%" align="left">
                                                            <input type="submit" name="upload" class="btn btn-primary"
                                                                   value="Upload">
                                                        </td>
                                                    </tr>

                                                </form>
                                                <form method="post" enctype="multipart/form-data" action="{{ url('/ml_input/test'), $regression ?? null }}">
                                                    {{ csrf_field() }}


                                                    <tr>


                                                    </tr>
                                                    <tr>
                                                        <td width="10%" align="left"><label><b>Select File for Testing</b></label>
                                                        </td>
                                                        <td width="10">
                                                            <input type="file" name="select_file"/>
                                                        </td>
                                                        <td width="10%" align="left">
                                                            <input type="submit" name="upload" class="btn btn-primary"
                                                                   value="Upload">
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td width="40%" align="right"></td>
                                                        <td width="30"><span class="text-muted">Please upload .CSV file only </span>
                                                        </td>
                                                        <td width="30%" align="left"></td>
                                                    </tr>
                                                    {{--                                    </table>--}}
                                                    {{--                                </div>--}}
                                                </form>
                                            </table>
                                        </div>





                                        <br/>

                                        <div class="panel panel-default">

                                            <div class="panel-heading" >
                                                <div class="table-responsive">
                                                  <h3 class="panel-title">
                                                    <a id="more2" href="#" onclick="$('.details2').slideToggle(function(){$('#more2').html($('.details2').is(':visible')?'Close Detection Results':'Landing Detection Results');});">Landing Detection Results</a>
                                                    </h3>
                                                    <div  class="details2" style="display:none">

                                                        <table class="table table-bordered table-striped">
                                                            <tr>

                                                                <th>Landing Id </th>
                                                                <th>Status</th>
                                                                <th> Show</th>


                                                            </tr>
                                                            @if(!empty($status))
                                                                @foreach($status as $row1 => $order1)
{{--                                                                    <p style="color:blue;font-size:10px;">--}}
                                                                    <tr>
                                                                        <td>{{ $order1[0]?? null}}</td>
                                                                        <td>{{ $order1[1] ?? null}}</td>
                                                                        <td><a href="/singlemap?param1={{ $order1[0]?? null}}">
                                                                                <button  class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" >
                                                                                    <i class="fas fa-plane-arrival"></i>View Airlines Trajectory
                                                                                </button>
                                                                            </a> </td>


                                                                    </tr>
{{--                                                                    </p>--}}
                                                                @endforeach
                                                            @endif

                                                        </table>
                                                        {{--                                <a style="text-align: right;"> Landing: {{ $status ?? null}}</a>--}}
                                                    </div>
{{--                                                </h3>--}}
                                            </div>

                                            </div>



                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <a id="more" href="#" onclick="$('.details').slideToggle(function(){$('#more').html($('.details').is(':visible')?'Close Showing Raw Data':'Open Raw Predicted Data');});">Open Raw Predicted Data</a>

                                                </h3>



                                            </div>

                                            <div  class="details" style="display:none">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <tr>

                                                            <th>Landing Id </th>
                                                            <th>Speed </th>
                                                            <th>Deceleration </th>
                                                            <th>Delta Distance</th>
                                                            <th>Delta Time</th>
                                                            <th>Detection Result</th>


                                                        </tr>

                                                        {{--                                            @foreach($predicted_value as $value)--}}
                                                        {{--                                            @endforeach    --}}

{{--                                                        @if($test_input!=null)--}}

                                                            @foreach($test_input as $row => $order)
                                                                <tr>
                                                                    <td>{{ $order[0] ?? null}}</td>
                                                                    <td>{{ $order[1] ?? null}}</td>
                                                                    <td>{{ $order[2] ?? null}}</td>
                                                                    <td>{{ $order[3] ?? null}}</td>
                                                                    <td>{{ $order[4] ?? null}}</td>
                                                                    <td>{{ $predicted_value[$row] ?? null}}</td>


                                                                </tr>
                                                            @endforeach
{{--                                                        @endif--}}
                                                    </table>


                                                </div>
                                            </div>
                                            </div>

                                </section>
                            </div>






                        </div>


{{--                        <table class="table" id="tableUser">--}}
{{--                            Hello--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    End of Uploading the dataset for training--}}



                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="modal-user" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Modal User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUser" name="formUser">
                    <div class="form-group">

                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama"><br>
                        <input type="email" name="email" class="form-control" id="email" placeholder="email"><br>
                        <select name="level" class="form-control" id="level">
                            <option value="-">Pilih Level</option>
                            <option value="1">Operator</option>
                            <option value="2">Member</option>
                        </select><br>
                        <input type="text" name="password" class="form-control" placeholder="password"><br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    $('document').ready(function () {
        // success alert
        function swal_success() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Something goes wrong !',
                showConfirmButton: true,
            })
        }
        // table serverside
        var table = $('#tableUser').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            ajax: "{{ route('users.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'level',
                    name: 'level'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // initialize btn add
        $('#openmap').click(function () {
            $('#saveBtn').val("create user");
            $('#user_id').val('');
            $('#formUser').trigger("reset");
            $('#modal-user').modal('show');
        });
        // initialize btn edit
        $('body').on('click', '.editUser', function () {
            var user_id = $(this).data('id');
            $.get("{{route('users.index')}}" + '/' + user_id + '/edit', function (data) {
                $('#saveBtn').val("edit-user");
                $('#modal-user').modal('show');
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#level').val(data.level);
            })
        });
        // initialize btn save
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#formUser').serialize(),
                url: "{{ route('users.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#formUser').trigger("reset");
                    $('#modal-user').modal('hide');
                    swal_success();
                    table.draw();

                },
                error: function (data) {
                    swal_error();
                    $('#saveBtn').html('Save Changes');
                }
            });

        });
        // initialize btn delete
        $('body').on('click', '.deleteUser', function () {
            var user_id = $(this).data("id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('users.store')}}" + '/' + user_id,
                        success: function (data) {
                            swal_success();
                            table.draw();
                        },
                        error: function (data) {
                            swal_error();
                        }
                    });
                }
            })
        });

        // statusing


    });

</script>
@endpush
