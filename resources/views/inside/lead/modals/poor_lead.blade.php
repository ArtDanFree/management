@if($lead->lead_status != 4 or Auth::user()->role->name == 'Администратор')
    <div class="modal fade" id="poor-lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Выберите причину</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('lead.update', $lead->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input hidden name="lead_status" value="4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Причина</label>
                            <select class="form-control" name="rejection_reason" required>
                                <option hidden label=" "></option>
                                @foreach($rejectionReason as $reason)
                                    <option value="{{ $reason->name }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Комментарий</label>
                            <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg btn-block">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif