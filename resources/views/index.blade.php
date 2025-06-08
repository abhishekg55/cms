@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="content">

    <div id="addNewContactModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" name="addContact" id="addContact" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="name">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Name" id="name" name="name" class="form-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="email">Email ID <span
                                        class="text-danger">*</span></label>
                                <input type="email" placeholder="Enter Email ID" id="email" name="email"
                                    class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="phone_number">Contact Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter Contact Number" name="phone_number"
                                    class="form-control" id="phone_number">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label me-3">Gender <span class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="male" name="gender" value="0"
                                        checked>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="female" name="gender" value="1">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="profile_image">Profile Image <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image">
                            </div>
                        </div>

                        <div id="custom_field">

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button"
                                    class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill btn-sm"
                                    onclick="addNewContact()">
                                    <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                                        <i class="icon-plus-circle2"></i>
                                    </span>
                                    Add Custom Field
                                </button>
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
    <!-- /basic modal -->

    <div class="card">
        <div class="page-header page-header-default">
            <div class="page-header-content border-top">
                <div class="breadcrumb">
                    <span class="breadcrumb-item  py-2">Home</span>
                    <span class="breadcrumb-item active py-2">Manage Contacts</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center py-0">
            <h6 class="py-3 mb-0">Manage Contacts</h6>
            <div class="ms-auto my-auto">
                <button type="button" class="btn btn-primary btn-labeled btn-labeled-start rounded-pill"
                    data-bs-toggle="modal" data-bs-target="#addNewContactModal">
                    <span class="btn-labeled-icon bg-black bg-opacity-20 rounded-pill">
                        <i class="icon-plus-circle2"></i>
                    </span>
                    Add New Contact
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

        $(document).ready(function() {
            const validator = $('#addContact').validate({
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
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone_number: {
                        required: true,
                        number: true,
                        maxlength:10,
                        minlength:10
                    },
                    gender: {
                        required:true,
                        range: [0,1]
                    },
                    profile_image:{
                        required: true,
                    },
                    'field_names[]':{
                        required: true
                    },
                    'field_values[]':{
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: 'Please Enter Name'
                    },
                    email: {
                        required: 'Please Enter Email ID',
                        email: 'Please Enter valid Email ID'
                    },
                    phone_number: {
                        required: 'Please Enter Contact Number',
                        number: 'Please enter valid Contact Number',
                        maxlength: 'Contact Number should be of 10 digits only',
                        minlength: 'Contact Number should be of 10 digits only'
                    },
                    gender: {
                        required: 'Please choose gender',
                        range: 'Invalid gender'
                    },
                    profile_image: {
                        required: 'Please upload profile image',
                    },
                    'field_names[]':{
                        required: "Please enter Field Name"
                    },
                    'field_values[]':{
                        required: "Please enter Field Value"
                    }
                },

                submitHandler: function (form) {
                    
                    let formData = new FormData(form);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax({
                        url: "{{ route('contact.store') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);                    
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.message;
                            swal("Information", errors, "error");
                        }
                    });
                }
            });

            
        })

        function addNewContact() {
            let html = '';

            html += `
                    <div class="row" id="custom_field_row_${count}">
                        <div class="col-md-5 mb-2">
                            <label class="form-label" for="field_name${count}">Field Name</label>
                            <input type="text" placeholder="Enter Field Name" id="field_name${count}" class="form-control" name="field_names[]">
                        </div>
                        <div class="col-md-5 mb-2">
                            <label class="form-label" for="field_value${count}">Field Value</label>
                            <input type="text" placeholder="Enter Field Value" id="field_value${count}" class="form-control" name="field_values[]">
                        </div>
                        <div class="col-md-2 mb-2 mt-auto">
                            <button type="button" class="btn btn-danger btn-icon rounded-pill btn-sm" onclick="removeCustomField(${count})">
                                <i class="icon-cross3"></i>
                            </button>
                        </div>
                    </div>`;

            $('#custom_field').append(html);

            count++;

        }

        function removeCustomField(field) {
            $('#custom_field_row_' + field).remove();
        }
</script>
@endpush