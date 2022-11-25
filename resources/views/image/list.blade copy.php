@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            @php
            //dump($imatges);
            @endphp

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @foreach ($imatges as $imatge)
                
                <!-- imatge -->
                <div class="card m-4">
                    <div class="card-header">
                        <!--avatar user imatge-->
                        @php
                            $avatar = $imatge->user->image;
                            if (!$avatar) {$avatar = 'NOIMG.png';} //si avatar null
                        @endphp

                        <!-- img amb src ruta obtenir avatar-->
                        <img class= "rounded-circle" src="{{ route('get-avatar', $avatar) }}" 
                            width="40" height="40" class="d-inline-block align-top" alt="">

                        <!--nom i nick user imatge-->
                        {{$imatge->user->name.' '.$imatge->user->surname .' | @'.$imatge->user->nick }}

                    </div>

                    <div class="card-body" >
                        
                        <a href="{{ route('new-comment', $imatge->id) }}"> <!-- link a la imatge -->
                            <!-- img amb src ruta obtenir imatge-->
                            <img src="{{ route('get-imatge', $imatge->image_path) }}" class="img-thumbnail" alt="...">
                        </a>

                        <p class="my-2">
                            <strong>{{ '@'.$imatge->user->nick.': '}}</strong>
                            {{ $imatge->description }}
                            {{ ' | ' . \FormatTime::LongTimeFilter($imatge->created_at) }} <!--crida helper-->
                        </p>
                    </div>
                </div>
                <!--fi imatge -->

            @endforeach

            <!--paginació-->
            <div class="pagination justify-content-center">
                {{ $imatges->onEachSide(0)->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
