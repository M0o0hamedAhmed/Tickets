<div class="form-group">
    <label for="exampleInputEmail1">Message</label>
    <textarea name="message" type="text"
              class="form-control {{$errors->get('message') ?  'border-danger ': ''}}"
              id="message" placeholder="Enter Message"></textarea>
    @error('message')<div class="error">{{$message}}</div>@enderror

</div>
