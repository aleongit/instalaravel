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
                                @php
                                $user_like = App\Http\Controllers\LikeController::userLike($imatge->id);
                                @endphp
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
                                
                            <a href="{{ route('new-comment', $imatge->id) }}"> <!-- link al detall -->
                                <i class="fas fa-comment px-1"></i></a>{{count($imatge->comments)}}
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

                        </p>
                        @endforeach
                        <hr>

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
