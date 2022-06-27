@extends('adminlte::page')
@section('title', 'Add FAQ')
@section('content_header')
@stop
@section('plugins.Datatables', false)
@section('plugins.Ckeditor', true)
@section('plugins.Select2', true)
@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="{{ route('faqs.store') }}" method="POST" id="faqForm">
    @csrf
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add FAQ</h3>
                  <a href="{{ route('faqs.index') }}" class="float-right btn btn-sm btn-dark"><b>Back</b></a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Question</label>
                        <span class="asterisk">*</span>
                        <input type="text" name="title" class="form-control" placeholder="Question">
                    </div>
                    <div class="form-group">
                        <div class="validate_description">
                            <label for="leftinputDescription">Answer</label>
                            <span class="asterisk">*</span>
                            <textarea class="form-control" style="height:100px" name="description" placeholder="Answer"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        @php
                            $options = array(
                            	1 => 'Active',
                            	0 => 'Inactive',
                            );
                        @endphp
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input type="submit" value="Save" class="btn btn-success m-2">
            <a href="{{route('faqs.index')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
    </form>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
@section('js')
<script>
    $(document).ready(function() {
        ckeditorWithoutImg();
    });
</script>

@stop