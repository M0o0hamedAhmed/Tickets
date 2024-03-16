<div class="form-group">
    <label for="exampleInputEmail1">Subject</label>
    <input name="subject" type="text"
           class="form-control {{$errors->get('subject') ?  'border-danger ': ''}}"
           id="subject" placeholder="Enter Name"
           value="{{$item->subject ?? old('Subject',"Enter Ticket Subject")}}">
    @error('subject')<div class="error">{{$message}}</div>@enderror

</div>
