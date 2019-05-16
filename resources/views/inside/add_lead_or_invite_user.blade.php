@can('add-lead')
    <!-- Modal Add-lead -->
    <div class="modal fade" id="add-lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Добавление лида</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('lead.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Тип залога <span class="color-red">*</span></label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customControlValidation2"
                                       name="collateral" value="1" required>
                                <label class="custom-control-label" for="customControlValidation2">Недвижимость</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" class="custom-control-input" id="customControlValidation3"
                                       name="collateral" value="2" required>
                                <label class="custom-control-label" for="customControlValidation3">Автомобиль</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Имя</label>
                            <input name="first_name" value="{{ old('first_name') }}" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   placeholder="Имя">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Фамилия</label>
                            <input name="last_name" value="{{ old('last_name') }}" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                   placeholder="Фамилия">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Отчество</label>
                            <input name="surname" value="{{ old('surname') }}" type="text"
                                   class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                   placeholder="Отчество">
                            @if ($errors->has('surname'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Желаемая сумма </label>
                            <input name="money" type="text" value="{{ old('money') }}"
                                   class="form-control{{ $errors->has('money') ? ' is-invalid' : '' }}"
                                   placeholder="Желаемая сумма">
                            @if ($errors->has('money'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('money') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Телефон <span class="color-red">*</span></label>
                            <input name="phone" type="text" required value="{{ old('phone') }}"
                                   class="phone form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="Телефон">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                        @if(!empty($cities))
                            <div class="form-group">
                                <label>Город <span class="color-red">*</span></label>

                                <select id="add-lead-select" name="city_id" class="custom-select form-control-lg chosen-select" required>
                                    <option value="">Город</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <script>
                            $(document).ready(function () {
                                $(".chosen-select").chosen({width: "100%"});
                            });
                        </script>
                        <button type="submit" class="btn btn-warning btn-lg btn-block">Добавить</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Add-lead -->
@elsecan('invite-user')
    <!-- Modal Invite-user -->
    <div class="modal fade" id="invite-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Пригласить партнера</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('invite_user') }}">
                        @csrf

                        <div class="form-group">
                            <label>Роль</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customControlValidation2"
                                       name="collateral" value="3" required>
                                <label class="custom-control-label" for="customControlValidation2">Лидогенератор</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" class="custom-control-input" id="customControlValidation3"
                                       name="collateral" value="2" required>
                                <label class="custom-control-label" for="customControlValidation3">Частный инвестор</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Имя</label>
                            <input name="first_name" value="{{ old('first_name') }}" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   placeholder="Имя">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Электронная почта:</label>
                            <input name="email" value="{{ old('email') }}" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Электронная почта:">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-warning btn-lg btn-block">Пригласить</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Invite-user -->
@endcan
