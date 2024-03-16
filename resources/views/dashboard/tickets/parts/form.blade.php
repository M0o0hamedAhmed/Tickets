@if(isset($ticket->id))
    <form id="updateForm" class="addForm" method="post"
          action="{{route('dashboard.tickets.update',$ticket->id)}}">
        @method('PUT')
        @else
            <form id="addForm" class="addForm" method="post" action="{{route('dashboard.tickets.store')}}">
                @endif
                @csrf
                <div class="card-body">
                    <x-forms.inputs.subject :item="$ticket ?? new App\Models\Ticket"></x-forms.inputs.subject>
                    <x-forms.inputs.message :item="$ticket ?? new App\Models\Ticket"></x-forms.inputs.message>
                    <div class="form-group">
                        <label>Items</label>
                        <select class="form-control form-select  select2bs4" style="width: 100%;" name="type" >
                            @foreach($types as $type)
                                <option {{optional($ticket)->type == $type->value ? 'selected' : ''}}  value="{{$type->value}}">{{$type->name}}</option>
                            @endforeach
                        </select>

                    <div class="modal-footer justify-content-between">
                        <x-forms.buttons.text.close></x-forms.buttons.text.close>
                        <x-forms.buttons.text.save></x-forms.buttons.text.save>
                    </div>
                </div>
            </form>
