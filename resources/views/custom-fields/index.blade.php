@extends('layouts.app')
@section('title', 'Custom Fields')

@section('content')

<div class="content">

    <div id="addNewCustomFieldModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Custom Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" name="addCustomField" id="addCustomField">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="field_name">Field Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Field Name" id="field_name" name="field_name"
                                    class="form-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="field_type">Field Type <span
                                        class="text-danger">*</span></label>
                                <select name="field_type" id="field_type" class="form-control select">
                                    <option value="">Select Field Type</option>
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">

                        <button type="button" class="btn btn-danger btn-labeled btn-labeled-start rounded-pill"
                            data-bs-dismiss="modal">
                            <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                                <i class="icon-cross3"></i>
                            </span>
                            Close
                        </button>
                        <button type="submit" class="btn btn-success btn-labeled btn-labeled-start rounded-pill">
                            <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                                <i class="icon-check"></i>
                            </span>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="EditCustomFieldModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Custom Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" name="editCustomFieldForm" id="editCustomFieldForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="edit_field_name">Field Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Field Name" id="edit_field_name" name="field_name"
                                    class="form-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="edit_field_type">Field Type <span
                                        class="text-danger">*</span></label>
                                <select name="field_type" id="edit_field_type" class="form-control select">
                                    <option value="">Select Field Type</option>
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="date">Date</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="edit_status">Status <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-control select">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">

                        <button type="button" class="btn btn-danger btn-labeled btn-labeled-start rounded-pill"
                            data-bs-dismiss="modal">
                            <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                                <i class="icon-cross3"></i>
                            </span>
                            Close
                        </button>
                        <button type="submit" class="btn btn-success btn-labeled btn-labeled-start rounded-pill">
                            <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                                <i class="icon-check"></i>
                            </span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="page-header page-header-default">
            <div class="page-header-content border-top">
                <div class="breadcrumb">
                    <span class="breadcrumb-item  py-2">Home</span>
                    <span class="breadcrumb-item active py-2">Manage Custom Fields</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center py-0">
            <h6 class="py-3 mb-0">Manage Custom Fields</h6>
            <div class="ms-auto my-auto">
                <button type="button" class="btn btn-primary btn-labeled btn-labeled-start rounded-pill"
                    data-bs-toggle="modal" data-bs-target="#addNewCustomFieldModal">
                    <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                        <i class="icon-plus-circle2"></i>
                    </span>
                    Add New Custom Field
                </button>
            </div>
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
{!! $dataTable->scripts(attributes: ['type' => 'module']) !!}

<script>
    var count = 1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
           $('#addCustomField').validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                rules: {
                    field_name: {
                        required: true
                    },
                    field_type: {
                        required: true,
                    },
                },
                messages: {
                    field_name: {
                        required: 'Please Enter Name'
                    },
                    field_type: {
                        required: 'Please choose field type',
                    },
                },

                submitHandler: function(form) {

                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('custom-fields.store') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swal({
                                title: "Information",
                                text: response.message,
                                type: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function() {
                                location.reload(true);
                            })
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.message;
                            swal("Information", errors, "error");
                        }
                    });
                }
            });
            
            $('#editCustomFieldForm').validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                rules: {
                    field_name: {
                        required: true
                    },
                    field_type: {
                        required: true,
                    },
                    status:{
                        required: true
                    }
                },
                messages: {
                    field_name: {
                        required: 'Please Enter Name'
                    },
                    field_type: {
                        required: 'Please choose field type',
                    },
                    status: {
                        required: 'Please choose Status',
                    },
                },

                submitHandler: function(form) {

                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('custom-fields.update') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swal({
                                title: "Information",
                                text: response.message,
                                type: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function() {
                                location.reload(true);
                            })
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.message;
                            swal("Information", errors, "error");
                        }
                    });
                }
            });


        })

        function editCustomField(params) {
            $.ajax({
                url: params,
                dataType: "json",
                type: 'GET',
                success: function(data) {
                    window[data.method](data);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.message;
                    swal("Information", errors, "error");
                }
            });
        }

        function editCustomFieldDetail(params){
            let data = params.data;

            $('#edit_field_name').val(data.field_name);
            $('#edit_field_type').val(data.field_type).trigger('change');
            $('#edit_status').val(data.status).trigger('change');
            $('#edit_id').val(data.rowid);

            $('#EditCustomFieldModal').modal('show');
            
        }
</script>
@endpush