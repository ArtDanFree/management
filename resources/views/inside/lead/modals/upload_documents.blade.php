<div class="modal fade" id="add-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Загрузить документы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('lead_image.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input name="documents[]" type="file" class="form-control-file" multiple>
                        @if ($errors->has('files'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('files') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <input hidden name="lead_id" value="{{ $lead->id}}">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Добавить</button>

                </form>
            </div>
        </div>
    </div>
</div>