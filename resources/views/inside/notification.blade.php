@can('telegram')
    @if(!empty($notification_user))
        @foreach($notification_user as $key => $notification_user)
        <!-- Modal Add-lead -->
        <div class="modal fade" id="telegram-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Настройка уведомлений</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="margin-right: 7px">
                            <div id="telegram-step-1" class="d-none ">
                                <p style="font-weight: bold"> Шаг 1. Узнайте свой телеграм ID </p>
                                <p>Для этого введите в поиск <a href="https://teleg.run/userinfobot" target="_blank">@userinfobot</a>  и нажмите на кнопку /start. Бот пришлет Вам сообщение, в котором будет содержаться ID.
                                    <video poster="{{asset('images/step1.jpg')}}" style="margin: 10px 10px" width="100%" height="428" src="{{asset('video/step1.mp4')}}" controls></video>
                                </p>

                                <button id="step-1" class="btn btn-lg btn-success fl-right ">Далее</button>
                            </div>
                            <div id="telegram-step-2" class="d-none">
                                <p style="font-weight: bold">Шаг 2. Сохранение  ID в настройках аккаунта</p>
                                <div style="margin-top:20px;" class="form-group test-c">
                                    <label style="margin-right: 10px" for="telegram-input">Введите полученный телеграм ID: </label>
                                    @foreach($notification_user->notification as $key => $notification)
                                        @if((!! $notification->pivot->confirmed == false) and ($notification->pivot->notification_id == 1) )
                                            <div style="margin-right: 7px">
                                                <input id="telegram-notification_id" value="{{ $notification->id }}" name="notification_id" type="text" hidden >
                                                <input id="telegram-confirmed" value="1" name="confirmed" type="text" hidden>
                                                <input id="telegram-input" class="notification-button form-control" type="text" name="" value="{{$notification_user->telegram}}">
                                            </div>
                                        @endif
                                        @if(( !! $notification->pivot->confirmed == true) and ($notification->pivot->notification_id == 1) )
                                            <div style="margin-right: 7px">
                                                <input id="telegram-notification_id" value="{{ $notification->id }}" name="notification_id" type="text" hidden >
                                                <input id="telegram-confirmed" value="0" name="confirmed" type="text" hidden>
                                                <input id="telegram-input" type="text" name="" value="{{$notification_user->telegram}}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button style="margin-top: 50px;" id="step-2" class="btn btn-lg btn-success fl-right">Далее</button>
                            </div>
                            <div id="telegram-step-3" class="d-none">
                                <p style="font-weight: bold">Шаг 3. Добавление бота </p>
                                <p>Последним шагом будет добавление бота, который производит рассылку лидов. Для этого введите в поиске <a href="https://teleg.run/LikeLeadsBot" target="_blank">@LikeLeadsBot</a> и нажмите /start.
                                    <video poster="{{asset('images/step3.jpg')}}" style="margin: 10px 10px" width="100%" height="428" src="{{asset('video/step3.mp4')}}" controls></video>
                                <div id="error-list">
                                </div>
                                <button id="step-3" class="btn btn-lg btn-success fl-right">Включить</button>
                                <button id="back-to-step-2" class="btn btn-lg btn-success fl-right d-none ">Назад</button>
                            </div>
                            <div id="telegram-done" class="d-none">
                                <div class="test-c">
                                    <img width="200px" src="{{asset('img/round-done-button.png')}}" alt="">
                                    <div>
                                        <p class="test-c done-text">Готово!</p>
                                    </div>
                                </div>
                                <button id="done" class="btn btn-lg btn-success fl-right ">Закрыть</button>
                            </div>
                            @can('underwriter')
                                <div id="email-menu" class="d-none">
                                    <div class="test-c">
                                        @foreach($notification_user->notification as $key => $notification)
                                            @if($notification->pivot->notification_id == 2 )
                                                <div style="margin-right: 7px">
                                                    <input id="email-notification_id" value="{{ $notification->id }}" name="notification_id" type="text" hidden >
                                                    <input id="email-confirmed-off" value="0" name="confirmed" type="text" hidden>
                                                    <input id="email-confirmed" value="1" name="confirmed" type="text" hidden>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <button id="done-email" class="btn btn-lg btn-success fl-right ">Закрыть</button>
                                </div>
                            @endcan
                            <div id="notification-menu">
                                @foreach($notification_user->notification as $key => $notification)
                                    @if((!! $notification->pivot->confirmed == false) and ($notification->pivot->notification_id == 1) )
                                        <button id="button-telegram" class="btn btn-lg  notification-button ">Telegram</button>
                                        <button id="button-telegram-off" class="btn btn-lg btn-success notification-button d-none ">Telegram</button>
                                        <br>
                                    @endif
                                    @if(( !! $notification->pivot->confirmed == true) and ($notification->pivot->notification_id == 1) )
                                        <button id="button-telegram-off" class="btn btn-lg btn-success notification-button ">Telegram</button>
                                        <button id="button-telegram" class="btn btn-lg  notification-button d-none">Telegram</button><br>
                                    @endif
                                    @can('underwriter')
                                        @if((!! $notification->pivot->confirmed == false) and ($notification->pivot->notification_id == 2) )
                                            <button style="margin-top: 10px;" id="button-email" class="btn btn-lg  notification-button">Email</button>
                                            <button style="margin-top: 10px;" id="button-email-off" class="btn btn-lg btn-success notification-button d-none">Email</button>
                                        @endif
                                        @if(( !! $notification->pivot->confirmed == true) and ($notification->pivot->notification_id == 2) )
                                            <button style="margin-top: 10px;" id="button-email" class="btn btn-lg  notification-button d-none">Email</button>
                                            <button style="margin-top: 10px;" id="button-email-off" class="btn btn-lg btn-success notification-button">Email</button>
                                        @endif
                                    @endcan
                                @endforeach
                            </div>
                        </div>
                        <test-telegram-message></test-telegram-message>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
@endcan
