<div class="mb-3">
    <label class="form-label">{{__('Full Name')}}</label>
    <input type="text" class="form-control" name="name" value="{{$user_management->name}} ">
</div>
<div class="mb-3">
    <label class="form-label">{{__('Email')}}</label>
    <input type="email" autocomplete="off" class="form-control" name="email" value="{{$user_management->email}}">
</div>
<div class="mb-3">
    <label class="form-label">{{__('Password(To update password)')}}</label>
    <input type="password" autocomplete="off" class="form-control" name="password">
</div>
<div class="mb-3">
    <label class="form-label">{{__('User Type')}}</label>
    <select class="form-select" name="user_type">
        <option {{$user_management->user_type == 'admin' ? 'selected' : ''}} value="admin">Admin</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">{{__('Status')}}</label>
    <label class="form-check form-switch status-wrp">
        <input type="checkbox"  class="form-check-input status" name="status" value="1" {{isset($user_management->status)&&$user_management->status != 0 ? 'checked' : ''}}/>
        <span class="form-check-label">{{isset($user_management->status)&&$user_management->status != 0 ? 'Active' : 'Inactive'}}</span>
    </label>
</div>
<div class="col-md-12 text-center">
    <button type="button" class="btn btn-primary" id="update-button">{{__('Update')}}</button>
    <button type="button" class="btn btn-outline-danger" id="cancel-button" data-bs-dismiss="modal">{{__('Cancel')}}</button>
</div>
<input type="hidden" id="edit-id" value="{{$user_management->id}}">
<script>
    $('.status').on('change',function (){
        if($(this).is(':checked'))
            $(this).closest('.status-wrp').find('.form-check-label').html('Active');
        else
            $(this).closest('.status-wrp').find('.form-check-label').html('Inactive');
    });
</script>
