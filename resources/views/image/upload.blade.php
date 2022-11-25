@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pujar Imatge') }}</div>
                        <div class="card-body">
                            <form action="{{ route('upload-image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                @if (session('ok'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('ok') }}
                                    </div>
                                @elseif (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <label for="imatge" class="col-md-4 col-form-label text-md-end">Imatge</label>
                                    <div class="col-md-6">
                                        <input name="imatge" type="file" class="form-control @error('imatge') is-invalid @enderror" id="imatge"
                                        placeholder="imatge">
                                        @error('imatge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="descripcio" class="col-md-4 col-form-label text-md-end">Descripció</label>
                                    <div class="col-md-6">
                                        <input name="descripcio" type="text" class="form-control @error('descripcio') is-invalid @enderror" id="descripcio"
                                        placeholder="descripcio">
                                        @error('descripcio')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button class="btn btn-primary">Upload!</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection