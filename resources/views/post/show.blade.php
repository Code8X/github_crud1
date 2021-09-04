@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>View Posts</div>
                            <div><a href="{{ route('posts.index') }}" class="btn btn-success">Back</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr align="center">
                                    <th >Field name</th>
                                    <th >Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Title</td>
                                    <td>{{ $posts->title }}</td>

                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ $posts->description }}</td>

                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>{{ $posts->category->name }}</td>
                                </tr>
                               <tr>
                                    <td>tags</td>
                                    <td>
                                        @if (count($posts->tags))
                                            @foreach ($posts->tags as $tag)
                                                {{ $tag->name }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td>
                                        <img width="100%" src="{{asset('post_images/'.$posts->image)}}">
                                    </td>

                                  </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
