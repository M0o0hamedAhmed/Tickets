@extends('admin.layouts.master')
@section('title','Tickets')
@push('styles')
@endpush
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{$title}}</li>
@endsection
@section('content')
    <!-- Create Or Edit Modal -->
    {{--    <x-modals.modal-show :$title></x-modals.modal-show>--}}
    <!-- Create Or Edit Modal -->

    <!-- Create Or Edit Modal -->
    <x-modals.modal-edit-create :$title></x-modals.modal-edit-create>
    <div class="col-md-4">
        <!-- Widget: user widget style 2 -->
        <div class="card card-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning bf">
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{$ticket->subject}}</h3>
            </div>
            <div class="card-footer p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link">
                            Status <span
                                class="float-right badge {{$ticket->sub_type->background()}}">{{$ticket->sub_type->name}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            Type <span class="float-right badge bg-info">{{$ticket->type->name}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            Client Name <span class="float-right badge bg-success">{{$ticket->client_id}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            Issued Date <span
                                class="float-right badge bg-danger">{{$ticket->created_at->diffForHumans()}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            Closed Date <span
                                class="float-right badge bg-danger">{{$ticket->closed_at?->diffForHumans()}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>

    <!-- Create Or Edit Modal -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
                <!-- timeline time label -->
                <!-- /.timeline-label -->
                <!-- timeline item -->
                @forelse($ticket->replies as $reply)

                    <div>
                        <i class="fas fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                            {{--                            <span class="time"><i class="fas fa-clock"></i> {{$reply->created_at->diffForHumans()}}</span>--}}

                            <div class="timeline-body">{{$reply->message}}</div>

                        </div>
                    </div>
                @empty
                    <div>
                        <i class="fas fa-circle-notch bg-blue"></i>
                        <div class="timeline-item">

                            <div class="timeline-body">No replies yet</div>

                        </div>
                    </div>
                @endforelse
                <!-- END timeline item -->

            </div>
        </div>
        <!-- /.col -->

    </div>
    <div>
        @if($ticket->sub_type->isOpen())
            <form method="POST" action="{{route('dashboard.tickets.update',$ticket->id)}}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <x-forms.inputs.message></x-forms.inputs.message>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>
                </div>
            </form>
        @else
            <div class="col-12">
                <div class="info-box shadow-lg">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">Unfortunately, you are unable to create replies at this time. The ticket status must be 'open' in order to create a reply</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        @endif
    </div>

@endsection
@push('scripts')
@endpush
@push('ajaxCalls')
    <script>
        $(document).ready(function () {
            var columns = [
                {data: 'id', name: 'id'},
                {data: 'type', name: 'image'},
                {data: 'sub_type', name: 'name'},
                {data: 'issuer_name', name: 'issuer_name'},
                {data: 'client_name', name: 'client_name'},
                {data: 'issuer_date', name: 'issuer_date'},
                {data: 'closed_date', name: 'closed_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            columns.map(function (column) {
                $('#tableHeaders').append(`<th>${column.data}</th>`)
            });

            showData('{{route('dashboard.tickets.index')}}', columns);

            // Delete Using Ajax
            {{--deleteScript('{{route('dashboard.delete_tickets')}}');--}}
            // Add Using Ajax
            showAddModal('{{route('dashboard.tickets.create')}}');
            addScript();
            // Add Using Ajax
            showEditModal('{{route('dashboard.tickets.edit',':id')}}');

            {{--showModal('{{route('dashboard.tickets.show',':id')}}');--}}
            editScript();
        });
    </script>
@endpush


