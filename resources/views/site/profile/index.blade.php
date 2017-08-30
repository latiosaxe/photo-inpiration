@extends('site.master')
@section('content')

    <div class="user profile">
        <div class="gallery-preview">
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        @if($user->premium)
        <div class="user-pro">
            <p>User Premium</p>
        </div>
        @endif
        <div class="meta">
            <div class="container">
                <div class="relative">
                    <div class="row margin-bottom-20">
                        <div class="col-md-12">
                            <div class="head">
                                <div class="avatar">
                                    <div class="avatar-zone">
                                        <div class="background" style="background-image: url('/assets/images/profile.png')"></div>
                                    </div>
                                </div>
                                <div class="text">
                                    <h2 class="name">{{ $user->name }} {{ $user->lastname }}</h2>
                                    <h3 class="username">{{ $user->username }}</h3>
                                    <div class="description">
                                        {{ $user->description }}
                                    </div>
                                    <div class="location">
                                        {{ $user->city }}, {{ $user->country }}
                                    </div>

                                    <div class="numbers">
                                        <div class="block">
                                            <strong>{{ $user->views }}</strong> Views
                                        </div>
                                        <div class="block">
                                            <strong>{{ $user->views }}</strong> Likes
                                        </div>
                                        <div class="block">
                                            <strong>{{ $user->views }}</strong> Followers
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="special">
                    <div class="row margin-bottom-20">
                        <div class="col-md-12">
                            <p class="subtitle">
                                Galleries
                            </p>
                        </div>
                    </div>
                    {{--@foreach($galleries as $element)--}}
                        {{--{{ dd($element) }}--}}
                    {{--@endforeach--}}
                    <div class="row">
                    @if($galleries)
                    @foreach($galleries as $gallery)
                        <div class="col-md-6">
                            <a href="/profile/gallery/{{ $gallery->id }}">
                                <div class="single-gallery">
                                    <div class="preview">
    {{--                                    <div class="image" style="background-image: url('{{ $gallery->cover }}')"></div>--}}
                                        <div class="image" style="background-image: url('/assets/images/profile.png')"></div>
                                    </div>
                                    <div class="name">
                                        <p>{{ $gallery->name }}</p>
                                        <span>{{ $gallery->photos }} photos</span>
                                    </div>
                                    <p>Comments @if($gallery->content) {{count( $gallery->content->comments )}} @else 0 @endif</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    @endif
                        <div class="col-md-6">
                            <div class="single-gallery">
                                <div class="add">
                                    <div class="msg">
                                        <button class="btn">Add a gallery</button>
                                    </div>
                                    <div class="create byebye">
                                        <form id="createGal" class="globalStyle">
                                            <fieldset>
                                                <label for="name">
                                                    <input type="text" id="name" placeholder="Name">
                                                </label>
                                            </fieldset>
                                            <fieldset>
                                                <label for="description">
                                                    <textarea id="description" placeholder="description"></textarea>
                                                </label>
                                            </fieldset>
                                            <fieldset>
                                                <button type="submit">Create</button>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(".single-gallery .add .msg .btn").on('click', function () {
            $(this).closest('.msg').addClass('byebye').closest(".single-gallery").find('.create').removeClass('byebye');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#createGal").on('submit', function(){
            event.preventDefault();
            var data = {};
            data.name = $("#name").val();
            data.description = $("#description").val();
            data._token = $('meta[name="csrf-token"]').attr('content');

            console.log(data);
            $.ajax({
                url: 'api/create/gallery',
                data: data,
                type: 'post',
                success: function () {
                    document.location.href = '/profile'
                },
                error: function () {
                    alert("Error al crear galería");
                }
            })
        });
    </script>
@endsection