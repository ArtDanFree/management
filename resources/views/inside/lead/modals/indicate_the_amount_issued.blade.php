<div class="modal fade" id="specified-amount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Укажите выданную сумму</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ Route('lead.update', $lead->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input hidden name="transaction_status" value="3">

                    <div class="form-group">
                        <input id="total_amount" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" type="text" name="total_amount" value="">
                        <input hidden type="text" name="date_of_issue" value="{{ \Carbon\Carbon::now() }}">
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
</div>