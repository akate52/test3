<!-- 所有的错误提示 -->
@if(count($errors))
    {{--显示第一条错误信息--}}
    <div class="alert alert-danger">
        <ul>
           <li>{{ $errors->first() }}</li>
        </ul>
    </div>
    {{--显示所有错误信息--}}
    {{--<div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>--}}
@endif