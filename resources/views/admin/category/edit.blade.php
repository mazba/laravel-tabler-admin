<div class="mb-3">
    <label class="form-label">{{__('Title')}}</label>
    <input type="text" class="form-control" name="title" value="{{$category->title}} ">
</div>
<div class="col-md-12 text-center">
    <button type="button" class="btn btn-primary" id="update-button">{{__('Update')}}</button>
    <button type="button" class="btn btn-outline-danger" id="cancel-button" data-bs-dismiss="modal">{{__('Cancel')}}</button>
</div>
<input type="hidden" id="edit-id" value="{{$category->id}}">
