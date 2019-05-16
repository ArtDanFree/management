@extends('layouts.inside')
@section('content')
    <div class="container" id="app">
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
    <div style="margin-top: 20px" class="container border-bottom">
        <h2>Список методов</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Тип запроса</th>
                <th scope="col">Описание</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>getCities()</td>
                <td>GET</td>
                <td>Возвращает список городов и их id в формате json.</td>
            </tr>
            <tr>
                <td>addLead()</td>
                <td>POST</td>
                <td>Добовляет нового лида.<br>
                    Принимает следующие параметры:<br>
                    <span class="hljs-string">phone</span><span class="color-red">*</span>: Телефон<br>
                    <span class="hljs-string">collateral</span><span class="color-red">*</span>: Тип залога: 1 = Недвижимость, 2 = Автомобиль<br>
                    <span class="hljs-string">city_id</span><span class="color-red">*</span> или <span class="hljs-string">city</span><span class="color-red">*</span>:&nbsp <span class="hljs-string">city_id</span>: получаем с помощью метода <span class="hljs-title">getCities</span><span class="hljs-params">()</span>,&nbsp <span class="hljs-string">city</span>:&nbsp принимает название города <br>
                    <span class="hljs-string">first_name</span>: Имя<br>
                    <span class="hljs-string">last_name</span>: Фамилия<br>
                    <span class="hljs-string">surname</span>: Отчество<br>
                    <span class="hljs-string">money</span>: Желаемая сумма<br>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2>Пример использования</h2>
        <p>
            В этом примере используется библиотека <a href="https://github.com/guzzle/guzzle">GuzzleHttp</a>
        </p><br>
        <p>скопируйте репозиторий <br>
            <pre><code>git clone https://github.com/ArtDanFree/api.git</code></pre>
        </p>
        <p>
            перейдите в папку и выполните команду
        <pre><code>composer install</code></pre>
        </p>
        <p>Создайте токен личного доступа, вставьте его вместо «your-token» в <span class="hljs-selector-tag">ApiController</span><span class="hljs-selector-class">.php</span>
        <pre><code>protected $accessToken = 'your-token';</code></pre>
        </p>
        <p>Теперь открыв сайт в select, вы увидите большой список городов, так же вы теперь можете добавить лида.<br>
        Если вы хотите сделать поиск по этому списку, используйте библиотеку <a href="https://github.com/harvesthq/chosen">chosen</a>.
        </p>
        Если вам не удобно работать с этим списком, вы можете отправлять нам название города, для этого замените в файле <span class="hljs-selector-tag">index</span><span class="hljs-selector-class">.php</span>
        <pre><code>&ltselect id="add-lead-select" name="city_id" class="custom-select form-control-lg" required>
    &ltoption value="">Город&lt/option>
    &lt?php foreach($cities['cities'] as $city){?>
        &ltoption value="&lt?php echo $city['id'];?>">&lt?php echo $city['name'];?>&lt/option>
    &lt?php }; ?>
&lt/select></code></pre>
        на
        <pre><code>&ltdiv class="form-group">
    &ltlabel>Город:&lt/label>
    &ltinput name="city" type="text" required class="phone form-control" placeholder="Город:">
&lt/div></code></pre>

        и в файле <span class="hljs-selector-tag">ApiController</span><span class="hljs-selector-class">.php</span> в методе <span class="hljs-title">addLead</span>()
        <pre><code>'city_id' => $request['city_id'],</code></pre>
        на
        <pre><code>'city' => $request['city'],</code></pre>
        Если вы хотите дополнительно отправлять имя, фамилию, отчество, и желаемую сумму лида, то для этого в <span class="hljs-selector-tag">index</span><span class="hljs-selector-class">.php</span> добавьте в форму эти поля:

        <pre><code>&ltdiv class="form-group">
    &ltlabel>Имя:&lt/label>
    &ltinput name="first_name" type="text" class="form-control" placeholder="Имя">
&lt/div>
&ltdiv class="form-group">
    &ltlabel>Фамилия:&lt/label>
    &ltinput name="last_name" type="text" class="form-control" placeholder="Фамилия">
&lt/div>
&ltdiv class="form-group">
    &ltlabel>Отчество:&lt/label>
    &ltinput name="surname" type="text" class="form-control" placeholder="Отчество">
&lt/div>
&ltdiv class="form-group">
    &ltlabel>Желаемая сумма:&lt/label>
    &ltinput name="money" type="text" class="form-control" placeholder="Желаемая сумма">
&lt/div></code></pre>
        В итоге форма будет выглядеть так:
        <pre><code>&ltform id="form" action="/" method="POST">
    &ltdiv class="form-group">
        &ltlabel>Тип залога&lt/label>
        &ltdiv class="custom-control custom-radio">
            &ltinput type="radio" class="custom-control-input" id="customControlValidation2"
                   name="collateral" value="0" required>
            &ltlabel class="custom-control-label" for="customControlValidation2">Недвижимость&lt/label>
        &lt/div>
        &ltdiv class="custom-control custom-radio mb-3">
            &ltinput type="radio" class="custom-control-input" id="customControlValidation3"
                   name="collateral" value="1" required>
            &ltlabel class="custom-control-label" for="customControlValidation3">Автомобиль&lt/label>
        &lt/div>
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Имя:&lt/label>
        &ltinput name="first_name" value="" type="text" class="form-control" placeholder="Имя">
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Фамилия:&lt/label>
        &ltinput name="last_name" value="" type="text" class="form-control" placeholder="Фамилия">
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Отчество:&lt/label>
        &ltinput name="surname" value="" type="text" class="form-control" placeholder="Отчество">
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Желаемая сумма:&lt/label>
        &ltinput name="money" type="text" value="" class="form-control" placeholder="Желаемая сумма">
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Телефон:&lt/label>
        &ltinput name="phone" type="text" required class="phone form-control" placeholder="Телефон:">
    &lt/div>
    &ltdiv class="form-group">
        &ltlabel>Город:&lt/label>
        &ltinput name="city" type="text" required class="phone form-control" placeholder="Город:">
    &lt/div>

    &ltbutton type="submit" id="form-button" class="btn btn-warning btn-lg btn-block">Добавить&lt/button>
&lt/form></code></pre>
        и в файле <span class="hljs-selector-tag">ApiController</span><span class="hljs-selector-class">.php</span> в методе <span class="hljs-title">addLead</span>() в массив <span class="hljs-string">'form_params'</span> добавьте
        <pre><code>'first_name' => $request['first_name'],
'last_name' => $request['last_name'],
'surname' => $request['surname'],
'money' => $request['money'],</code></pre>

    </div>
@endsection
