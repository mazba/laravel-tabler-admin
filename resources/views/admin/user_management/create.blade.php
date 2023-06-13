<div class="mb-3">
    <label class="form-label">{{__('Full Name')}}</label>
    <input type="text" class="form-control" name="name" placeholder="{{__('Thomas Andersen')}}">
</div>
<div class="mb-3">
    <label class="form-label">{{__('Email')}}</label>
    <input type="email" autocomplete="off" class="form-control" name="email" placeholder="{{__('thomas@example.com')}}">
</div>
<div class="mb-3">
    <label class="form-label">{{__('Password')}}</label>
    <input type="password" autocomplete="off" class="form-control" name="password">
</div>
<div class="mb-3">
    <label class="form-label">{{__('Confirm Password')}}</label>
    <input type="password" class="form-control" name="password_confirmation">
</div>
<div class="mb-3">
    <label class="form-label">{{__('User Type')}}</label>
    <select class="form-select" name="user_type">
        <option value="admin">Admin</option>
    </select>
</div>
<div class="col-md-12 text-center">
    <button type="button" class="btn btn-primary" id="submit-button">{{__('Submit')}}</button>
    <button type="button" class="btn btn-outline-danger" id="cancel-button" data-bs-dismiss="modal">{{__('Cancel')}}</button>
</div>
<script>

</script>
