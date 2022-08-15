


 @if (Auth::user()->is_favorite($microgeniuse->id)){{--お気に入りしているかの確認--}}
        
        
        {!! Form::open(['route' => ['favorites.unfavorite', $microgeniuse->id], 'method' => 'delete']) !!}
       
            {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-sm"]) !!}
        {!! Form::close() !!}
    @else
       
        {!! Form::open(['route' => ['favorites.favorite', $microgeniuse->id]]) !!} 
            
        
            {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-sm"]) !!}
        
        {!! Form::close() !!}
    @endif
{{-- @endifユーザーが自分であれば表示しないという設定が入っている--}}
