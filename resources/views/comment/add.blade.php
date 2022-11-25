@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- imatge -->
                <div class="card m-4">
                    <div class="card-header">

                        <!-- img amb src ruta obtenir avatar-->
                        <img class= "rounded-circle" src="{{ route('get-avatar', $imatge->user->image) }}" 
                            width="40" height="40" class="d-inline-block align-top" alt="">

                        <!--nom i nick user imatge-->
                        {{$imatge->user->name.' '.$imatge->user->surname .' | @'.$imatge->user->nick }}

                    </div>

                    <div class="card-body" >
                        
                        <!-- img amb src ruta obtenir imatge-->
                        <img src="{{ route('get-imatge', $imatge->image_path) }}" class="img-thumbnail" alt="...">
                        
                        <!--likes i count comments-->
                        <p class="my-2">
                            <a href= "{{ route('like-image', $imatge->id) }}" >
                                @if($user_like)
                                    <i class="fas fa-heart like"></i></a>
                                @else
                                    <i class="fas fa-heart dislike"></i></a>
                                @endif

                                @php
                                $magradas = count($imatge->likes)
                                @endphp
                                {{$magradas}}
                                @if ($magradas == 1)
                                    {{' Liked by @'. $imatge->likes[0]->user->nick}}
                                @elseif ($magradas > 1)
                                    {{' Liked by @'. $imatge->likes[0]->user->nick. ' i '. ($magradas-1). ' més' }}
                                @endif
                            <i class="fas fa-comment px-1"></i>{{count($imatge->comments)}}
                        </p>

                        <!--nick i temps-->
                        <p>
                            <strong>{{ '@'.$imatge->user->nick.': '}}</strong>
                            {{ $imatge->description }}
                            {{ ' | ' . \FormatTime::LongTimeFilter($imatge->created_at) }} <!--crida helper-->
                        </p>
                        <hr>

                        <!--comentaris-->
                        @foreach ($imatge->comments as $comment)
                        <p class="my-2">
                            
                            <!--comentari-->
                            <strong>{{ '@'.$comment->user->nick.': '}}</strong>
                            {{ $comment->content }}
                            {{ ' | ' . \FormatTime::LongTimeFilter($comment->created_at) }} <!--crida helper-->

                            <!--link borrar, per get és perillós, potser millor fer form mètode delete amb butó -->
                            @if ( (Auth::id() == $comment->user_id) || (Auth::id() == $imatge->user_id) )
                                <a href="{{ route('del-comment', $comment->id) }}"><i class="fa fa-trash"></i></a>
                            @endif
                        </p>
                        @endforeach
                        <hr>

                        <!--form-->
                        <form action="{{ route('add-comment', $imatge->id) }}" method="POST">
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

                                <div class="row mb-2 px-2">
                                    <textarea name="comentari" class="form-control @error('comentari') is-invalid @enderror" id="comentari"
                                    placeholder="Escriu comentari..."></textarea>
                                    @error('comentari')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row mb-2 px-2">
                                    <button class="btn btn-primary">Envia!</button>
                                </div>
                            </form>

                    </div>
                </div>
                <!--fi imatge -->
             
            </div>
        </div>
    </div>
@endsection