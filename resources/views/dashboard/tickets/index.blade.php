@extends('admin.layouts.master')
@section('title','Tickets')
@push('styles')
@endpush
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{$title}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <x-forms.buttons.text.add>Add {{$title}}</x-forms.buttons.text.add>
                </div>
                <!-- /.Data -->
                <x-tables.regular-table><tr id="tableHeaders"></tr></x-tables.regular-table>
                <!-- /.end Data-->

                <!-- Create Or Edit Modal -->
                <x-modals.modal-edit-create :$title></x-modals.modal-edit-create>
                <!-- Create Or Edit Modal -->



                <!--Delete MODAL -->
                <x-modals.modal-delete></x-modals.modal-delete>
                <!-- MODAL CLOSED -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
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
                {data: 'issued_date', name: 'issued_date'},
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

            showModal('{{route('dashboard.tickets.show',':id')}}');
            editScript();
        });
    </script>
@endpush


