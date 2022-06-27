@extends('adminlte::page')
@section('title', 'FAQ')
@section('content_header')
@stop

@section('content')
    <div class="card" id="faq-listing">
        <div class="card-header">
            <h3 class="card-title">FAQs - Listing</h3>
            <div class="card-header-right d-flex justify-content-end align-items-center">
                {{-- @can('role-create') --}}
                    <a href="{{ route('faqs.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>  Add FAQ
                    </a>
                {{-- @endcan --}}
            </div>
        </div>
        <div class="card-body">
            {{-- Display Faqs --}}
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    @foreach($faqs as $faq)
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                        <li class="dd-item" data-id="{{$faq->id}}">
                            <div class="dd-handle dd3-handle"></div>
                            {!! Form::model($faq, ['method' => 'PATCH','route' => ['faqs.update', $faq->id], 'files' => true, 'class' => 'mainMenuForm']) !!}
                            <div class="dd3-content">
                                    <span>{{$faq->title}}</span>
                                    <a class='btn btn-xs btn-danger float-right ml-1' onclick='deleteRow({{$faq->id}});' href='javascript:;' title='Delete'>Delete</a>
                                    <a href='{{route('faqs.edit',$faq->id)}}' class='btn btn-primary btn-xs mr-1 float-right'>Edit</a>
                                    @if($faq->status == 1)
                                        <span class='badge badge-success btn-xs mr-2  float-right p-2'>Active</span>
                                    @endif
                                    @if($faq->status == 0)
                                        <span class="badge badge-danger btn-xs mr-2 float-right p-2">Ina    ctive</span>
                                    @endif

                            </div>
                            {!! Form::close() !!}
                        </li>
                    @endforeach
                </ol>
            </div>
            {{-- End display Faq--}}
        </div>
    </div>
@stop

@section('css')
<style>
.dd {
    max-width: 100% !important;
}
.dd3-content {
    display: block;
    margin: 5px 0;
    padding: 5px 10px 5px 40px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    overflow: auto;
}

.dd3-content:hover {
    color: #2ea8e5;
    background: #fff;
}

.dd-dragel > .dd3-item > .dd3-content {
    margin: 0;
}

.dd3-item > button {
    margin-left: 30px;
}

.dd3-handle {
    position: absolute;
    margin: 0;
    left: 0;
    top: 0;
    cursor: pointer;
    width: 30px;
    height: 100%;
    text-indent: 30px;
    white-space: nowrap;
    overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background: linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.dd3-handle:before {
    content: '≡';
    display: block;
    position: absolute;
    left: 0;
    top: 3px;
    width: 100%;
    text-align: center;
    text-indent: 0;
    color: #000;
    font-size: 20px;
    font-weight: normal;
}
/* .dd3-handle:hover {
    background: #ddd;
} */
.badge{
    padding: 0.175rem 0.25rem !important;
    font-size: .75rem;
    line-height: 1.5;
    border-radius: 0.15rem;
}
/* .dd-handle,.dd-handle:hover, .dd-handle:active {
    border: none !important;
    background: none !important;
} */
.dd-handle {
    margin: 3px !important;
    background: none !important;
    border: none !important;
}
//sort by arrow with css

</style>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/dist/jquery.nestable.min.css"> --}}
<link rel="stylesheet" href="{{ asset('adminltefaq/css/jquery.nestable.min.css') }}" >
@stop
@section('js')
{{-- @include('backend.common.datatable') --}}
{{-- <script type="text/javascript" src="https://dbushell.github.io/Nestable/jquery.nestable.js"></script> --}}
<script src="{{ asset('adminltefaq/js/jquery.nestable.min.js') }}"></script>
 <script type="text/javascript">
   var Toast = '';
    $(function() {
        Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        $('.dd').nestable({
            expandBtnHTML: '',
            collapseBtnHTML: '',
            maxDepth: 1
        });

        // drag & drop faq
        $('.dd').nestable({
            maxDepth: 1,
            //includeContent: true,
            callback: function (l, e) {
                // l is the main container
                // e is the element that was moved

                widgetPositionsCorrect();

                var elementId = $(e).data('id');
                if ($(e).parents('li.dd-item').length > 0) {
                    var parentNode = $(e).parents('li.dd-item');
                    var parentId = parentNode.data('id');

                    console.log(elementId);
                    console.log(parentId);

                    $(e).find('input[name="item[' + elementId + '][parent]"]').val(parentId);
                } else {
                    $(e).find('input[name="item[' + elementId + '][parent]"]').val('');
                }
            }
        });


        $('.dd').on('change', function (e) {
            var id = $(this).find('li').data('id');
            $.post('{{ route('faqs.order_item') }}', {
                 order: JSON.stringify($('.dd').nestable('serialise')),
                _token: '{{ csrf_token() }}'
            }, function (data) {
                //toastr.success("{{ __('voyager::menu_builder.updated_order') }}");
                Toast.fire({
                    title: "Success!",
                    text: "FAQ order successfully changed!",
                    type: "success"
                })
            });
        });
        

    });

    // delete data
    function deleteRow(id) {
        debugger;
        var token = $("meta[name='csrf-token']").attr("content");
        bootbox.dialog({
            message : "Are you sure want to delete faq?",
            title : "Delete faq",
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn btn-danger",
                    callback: function() {
                        //window.location = $("#"+id).data('url');
                        var url = '{{ route("faqs.destroy", ":id") }}';
                        url = url.replace(':id', id );
                        $.ajax({
                            type:"POST",
                            url: url,
                            data: {
                              "_method" : 'DELETE',
                              "id": id,
                              "_token": token,
                            },
                            dataType: 'json',
                            success: function(res){
                                if( res.success == 1  ){
                                  //show toaster
                                  Toast.fire({
                                      title: "Success!",
                                      text: "FAQ deleted successfully!",
                                      type: "success"
                                    })

                                    window.setTimeout(
                                    function(){
                                       location.reload();
                                    },2000)
                                }
                            }
                        });
                    }
                },
                danger: {
                    label: "No",
                    className: "btn btn-primary"
                }
            }
        });
        return false;
    }
    //end

</script> 
@stop