<!-- BEGIN UNSTYLED LISTS PORTLET-->
<div class="portlet box red" id="properties">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Properties
        </div>
            <a href="{{ url('land/property/create?land_id='.$land->id)}}"><button type="button" class="btn btn-success bnt-lg pull-right"><i class="fa fa-plus"></i> Add Property</button></a>

    </div>
    <div class="portlet-body">
        @if(count($properties))
            <table class="table table-border">
                <?php $i = 1; ?>
                @foreach($properties as $row)
                    <tr>
                        <td>{{ $i++ }}.</td>
                        <td>
                            <span class="pull-left"><a href="{{ url('land/property/'.$row->id) }}"> {{$row->title}} </a></span>
                        </td>
                        <td>
                            {{ $row->propertyType->title or '' }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            No files uploaded!
        @endif
        @include('Land::land.new-document-modal')
    </div>
</div>