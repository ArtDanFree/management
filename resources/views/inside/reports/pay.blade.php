@extends('layouts.inside')

@section('content')


<div class="container main-content">
  <h1><b>Оплата</b></h1>
  @can('admin')
  <h4><a href="{{ Route('report_month', $date) }}">Все лиды</a>
    <u> Комиссии</u>
  </h4>
  @endcan

  <table id="table" class="table ">
    <thead class="bg-success">
      <tr>
        <th scope="col">Лидогенератор</th>

        <th scope="col">Передано лидов</th>
        <th scope="col">Одобрено</th>
        <th scope="col">Выдано займов</th>
        <th scope="col">Комиссия</th>
        <th scope="col">Процент</th>
        <th scope="col">Оплата</th>
      </tr>
    </thead>
    <tbody>
      @if(!empty($users))
      @php
      $i=0;
      @endphp
      @foreach($users as $key => $user)
      @if(($leads->where('user_id',$user->id)->where('transaction_status',3)->count())!=0)
    </tr>
    <td>{{ $user->first_name }}</td>
    <td>{{$leads->where('user_id',$user->id)->count()}}</td>
    <td>{{$leads->where('user_id',$user->id)->where('transaction_status',3)->count()}}</td>
    <td>{{$leads->where('user_id',$user->id)->where('transaction_status',3)->sum('money')}}</td>
    <td> {{($leads->where('user_id',$user->id)->where('transaction_status',3)->sum('money'))/100*($user->commission)}}</td>
    <td>{{$user->commission}}</td>
    @if(($payment->where('user_id',$user->id)->where('dat',$date)->count())==0)
    <td><a data-toggle="modal" data-target="#form-pay-{{$user->id}}" href="#">Оплатить</a>   </td>
    @else
    <td > Оплачено
      <a style="display:inline" href="{{asset('storage/folder/pay/' . $date . '/' . $user->id . '/'. $user->payment->doc) }}"><img src="{{asset('img/eyes.svg')}}" alt="" width='17' height='17'></a>
      <a style="display:inline" onclick="deletePayments( '{{$date}}' , {{$user->id}})" ><img src="{{asset('img/delete.svg')}}" alt="" width='15' height='15'></a>
    </td>
  </tr>
  @endif
  @endif
  @php
  $i++;
  @endphp
  @endforeach
  @endif
</tbody>
</table>

@foreach($users as $key => $user)

<div class="modal fade" id="form-pay-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
<div class="modal-dialog custom-modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Оплата</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <p>Номер банковской карты:</p>
      <input class='form-control' name='n_bank' value='{{ $user->credit_card_number}}' disabled>

      <p>Лицевой или расчетный счет:</p>
      <input class='form-control' name='personal_acc' value='{{ $user->personal_acc}}' disabled>
      <p>Корр. сч.:</p>
      <input class='form-control' name='kor' value='{{ $user->correspondent_acc}}' disabled>
      <p>БИК банка:</p>
      <input class='form-control' name='bik' value='{{ $user->bic_bank}}' disabled>
      <p>Наименование банка:</p>
      <input class='form-control' name='bank' value='{{ $user->name_bank}}' disabled>
      <br>
      <form enctype='multipart/form-data' action="{{'payment/'.$date}}"  method='post'>
        {{ csrf_field() }}
        <input id="hide"  class='form-control' name='id' value='{{ $user->id}}' >
        <div class="file-upload">
          <label>
            <input name="file[]" id="inp" type="file" alt="Загрузить" multiple />
          </label>
        </div>
        <div <p class="text-center">    <input class="btn btn-warning btn-custom" id="yellow_btn" type="submit" value="Отправить" />    </p></div>
      </form>
    </div>
  </div>
</div>
</div>

    @endforeach
    <script type="text/javascript">
    function deletePayments(date, id){
      if (confirm("Вы уверены, что хотите удалить квитанцию?")) {
        parent.location='delete_ticket/'+date+'/'+id;
      }
      else {
      }
    }

    </script>
    @endsection
