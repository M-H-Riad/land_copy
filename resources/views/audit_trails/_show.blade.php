@extends('main_layouts.app')

@section('content')

<div class="row animated flipInX">


    <div class="row animated zoomIn">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <!-- <i class="icon-settings font-green"></i> -->
                        <span class="caption-subject bold uppercase">{{$audit_trail->action_title }} by - {{ $audit_trail->access_by }}</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row" >
                        <div class="col-md-12">
                                        <p>IP : {{$audit_trail->ip}}</p>

                                        <p>Title : {{$audit_trail->action_title}}</p>

                                        <p>Access By : {{$audit_trail->access_by}}</p>

                                        <p>Type : {{$audit_trail->type}}</p>

                                        <p style="white-space: nowrap;">Date & Time : {{date("F jS, Y - h:i:s a", strtotime($audit_trail->created_at))}}</p>

                                        <p style="word-break:break-all"><pre>Details : {{$audit_trail->description ?? null }}</pre></p>

                                        <p style="word-break:break-all">Url :{{$audit_trail->url ?? null }}</p>

                                        <p style="word-break:break-all"><pre> Request : {{ $audit_trail->request ?? null }}</pre></p>
                        </div>

                    </div>

                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            highlight_nav('audit-trail');
        });
    </script>
@endsection