@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Profile') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                            @csrf

                            @if (session('ok'))
                            <div class="alert alert-success" role="alert">
                                {{ session('ok') }}
                            </div>
                            @endif

                            <!-- nom_________________________ -->
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- cognom_________________________ -->
                            <div class="row mb-3">
                                <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Cognom') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" required autocomplete="surname" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- nick_________________________ -->
                            <div class="row mb-3">
                                <label for="nick" class="col-md-4 col-form-label text-md-end">{{ __('Nick') }}</label>

                                <div class="col-md-6">
                                    <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror" name="nick" value="{{ Auth::user()->nick }}" required autocomplete="nick" autofocus>

                                    @error('nick')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- email_________________________ -->
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- avatar_________________________ -->
                            <div class="row mb-3">
                                <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>

                                <!--preview-->
                                <div class ="col-md-3 p-2">
                                    <img id="pre" src="{{ route('get-avatar', Auth::user()->image) }}" class ="img-thumbnail" >
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" value="" autocomplete="avatar"
                                    onchange="preview()">

                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- botó -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update!') }}
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--js per preview avatar-->
<script type="text/javascript">
    //per preview al seleccionar imatge
    function preview() {pre.src=URL.createObjectURL(event.target.files[0]);}
</script>

@endsection
