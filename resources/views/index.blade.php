@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="content">

    <!-- Basic modal -->
    <div id="modal_default" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Basic modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Name</label>
                                <input type="text" placeholder="Eugene" class="form-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Email</label>
                                <input type="text" placeholder="eugene@kopyov.com" class="form-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Contact Number</label>
                                <input type="text" placeholder="Enter Contact Number" class="form-control"
                                    id="phone_number">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Profile Image</label>
                                <input type="file" class="form-control" accept="image/*">
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
                        <button type="button" class="btn btn-success btn-labeled btn-labeled-start rounded-pill">
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
                    data-bs-toggle="modal" data-bs-target="#modal_default">
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
    const maskPhoneElement = document.querySelector('#phone_number');
    if(maskPhoneElement) {
        const maskPhone = IMask(maskPhoneElement, {
        mask: '00-00000000'
    });
    }
</script>
@endpush