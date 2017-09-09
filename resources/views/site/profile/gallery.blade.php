@extends('site.master')
@section('content')

    <div class="user profile">
        @if($gallery->photos)
        <div class="gallery-preview">
            <ul>
                @foreach($gallery->photos as $photo)
                    <li style="background-image: url('{{ $photo->photo->photo }}')"></li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="content-element" @if($gallery->content) data-content-id="{{ $gallery->content->id }}" @endif>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ $gallery->name }}</h4>
                        <div class="description">
                            {{ $gallery->description }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($gallery->content)
                            <ul class="comments_list">
                            @foreach($gallery->content->comments as $comment)
                                @if($comment->active > 0)
                                <li data-comment-id="{{ $comment->id }}">
                                    <p>{{ $comment->user->username }}</p>
                                    <p>{{ $comment->text }}</p>
                                    <button class="btn replayComment">Replay</button>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Edit you gallery</p>
                        <p>Only images</p>
                    </div>
                </div>
                <br><br>
                <p>Follow users</p>
                <div class="row">
                    @foreach($users as $userSingle)
                        <div class="col-md-6">
                            <div class="name">{{ $userSingle->username }}</div>
                            <div class="name">{{ $userSingle->email }}</div>
                            <div class="follow-status @if(in_array($userSingle->id, $user->following_list_ids)) following @endif">
                                <button class="followUser btn" data-user="{{ $userSingle->id }}">Follow</button>
                                <button class="followUser btn followed" data-user="{{ $userSingle->id }}">Following</button>
                            </div>
                            <br><br>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>

        $(".replayComment").on('click', function () {
            $(this).closest('li').append('' +
                '<form class="submitComment" enctype="multipart/form-data"  method="POST" data-response="'+ $(this).closest('li').data('comment-id') +'">' +
                    '<input type="text" id="text-comment" placeholder="Message">' +
                    '<input type="file" class="checkImageUpload form-control" id="comment-image" name="comment-image">' +
                    '<button type="submit">Create comment</button>'+
                '</form>' +
            '');
        });
        $('.site').delegate('.submitComment', 'submit', function (event) {
            event.preventDefault();
            var $this = $(this);
            var formData = new FormData();
            formData.append('replay_id', $this.data('response'));
            formData.append('content_id', $(".content-element").data('content-id'));
            formData.append('text', $("#text-comment").val());
            formData.append('comment-image', $("#comment-image")[0].files[0]);
//            if($("#comment-image").hasClass('hasImage')){
//
//            }

            console.log( $("#comment-image")[0].files[0] );

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/api/create/comment',
                data: formData,
                type: 'post',
                dataType : 'JSON',
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $('.site').delegate('.checkImageUpload', 'change', function (event) {
            var file = $(this).val().split('.').pop();
            console.log(file);
            if(file=='png' || file=='jpg' || file=='PNG' || file=='JPG'){
                $(this).addClass('hasImage');
            } else{
                $(this).val('');
                alert('El archivo no es valido, por favor intenta con un archivo PNG o JPG');
            }
        });

        $(".followUser").on('click', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var _$this = $(this);
            var followUSer  = _$this.data('user');
            var data = {};
            data.user_id = followUSer;
            $.ajax({
                url: '/api/follow/user',
                data: data,
                type: 'post',
                success: function (data) {
                    console.log(data);
                    if(_$this.hasClass('followed')){
                        _$this.closest('follow-status').removeClass('following');
                        _$this.text('Follow');
                    }else{
                        _$this.closest('follow-status').addClass('following');
                        _$this.text('Following');
                    }
//                    document.location.href = '/profile'
                },
                error: function () {
//                    alert("Error al crear galería");
                }
            })
        });
    </script>
@endsection