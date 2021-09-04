@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="mb-2">
                        <form class="form-inline" action="">
                            <label for="category_filter">Filter By Category &nbsp;</label>
                            <select class="form-control" id="category_filter" name="category">
                                <option value="">Select Category</option>
                            @if (@count($categories))
                            @foreach ($categories as $item )
                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                            @endforeach

                            @endif
                            </select>
                            <label for="keyword">&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" name="keyword" placeholder="Enter keyword" id="keyword">
                            <span>&nbsp;</span>
                            <button type="button" class="btn btn-primary">Search &nbsp;</button>
                            <div><a href="{{ url('/') }}" class="btn btn-success">Back</a></div>
                        </form>
                    </div>


                        <div class="form-group">
                            <label for="tags">Tags:</label>
                            <select class="form-control" id="tags" name="tags[]" multiple>
                                <option value="">Please select multi tag</option>
                                @if (@count($tags))
                                    @foreach ($tags as $item)
                                        <option value="{{ $item->id }}"  {{(old('tags') && in_array($item->id,old('tags')) )?'selected':''}}>{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                    <div>Master data : Tags</div>
                    <div class="table-responsive">
                        <table style="width: 100%;" class="table table-stripped ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!@empty($tags))
                                    @foreach ($tags as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">Please Select Category </option>
                            @if (!@empty($categories))
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category') && old('category') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>Master data : Categories</div>
                    <div class="table-responsive">
                        <table style="width: 100%;" class="table table-stripped ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!@empty($categories))
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection

        @section('javascripts')
    <script type="text/javascript">
        $("#category").select2({
            placeholder: "Select a category",
            allowClear: true
        });
        $("#tags").select2({
            placeholder: "Select a tags",
            allowClear: true
        });
    </script>
@endsection
