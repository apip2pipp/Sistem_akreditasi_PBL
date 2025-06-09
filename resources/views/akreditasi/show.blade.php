@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mt-1">
                    <i class="fas fa-angle-double-right text-md text-primary mr-1"></i>
                    Show Accreditation Draft
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold">Title of PPEPP</label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $akreditasi->judul_ppepp }}</p>
                    </div>
                </div>

                <embed src="{{ url('storage/' . $fileAkreditasi->file_akreditasi) }}" type="application/pdf" width="100%"
                    height="600px">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
