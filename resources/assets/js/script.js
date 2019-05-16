window.show = function (count, page, token) {

    var table = document.getElementById('table');
    var inputs = table.getElementsByTagName("tr");
    var i = inputs.length - 1;
    var arr1 = [];
    var k = 1;
    while (i >= 0) {
        var input1 = inputs[i];
        k++;
        arr1[i - 1] = input1.getAttribute('id');
        i--;
    }
    $.ajax({
      type: 'POST',
      url: "update",
      data: {_token: token, time: t, arr: arr1},
      dataType: 'json',
      success: function (data) {


        if (data.leads != "" && page == 1) {
          for (var k = 0; k < (data.leads.length); k++) {
            var n = document.getElementById('n');

            var tr = document.createElement('tr');
            tr.id = i;
            tr.setAttribute('class', ' tr');
            tr.setAttribute('class', 'no-color-tr');
            n.insertBefore(tr, n.firstChild);
            //выдача
            var td = document.createElement('td');
            td.innerHTML = data.leads[k].transaction_status.name;

            tr.insertBefore(td, tr.firstChild);
            //проверка

            var td = document.createElement('td');
            var a = document.createElement('a');
            var linkText = document.createTextNode(data.leads[k].status.name);
            a.appendChild(linkText);
            a.setAttribute('data-toggle', 'modal');
            if (data.leads[k].status.name == 'Не обработан' && data.takeOn == 1) {
              a.setAttribute('onclick', 'showTakeModal("' + data.leads[k].id + '","' + data.leads[k].last_name + '","' + data.leads[k].first_name + '","' + data.leads[k].surname + '","' + data.leads[k].money + '","' + data.leads[k].phone + '")');
              a.href = "#take-on-check-" + data.leads[k].id;
            }
            td.insertBefore(a, td.firstChild);
            tr.insertBefore(td, tr.firstChild);

            //фио
            var td = document.createElement('td');
            var a = document.createElement('a');
            var linkText = document.createTextNode(data.leads[k].last_name + ' ' + data.leads[k].first_name + ' ' + data.leads[k].surname);
            a.href = 'lead/' + data.leads[k].id;
            a.appendChild(linkText);
            td.insertBefore(a, td.firstChild);
            tr.insertBefore(td, tr.firstChild);

            //Су
            var td = document.createElement('td');
            td.innerHTML = data.leads[k].money;
            tr.insertBefore(td, tr.firstChild);

            //Город
            var td = document.createElement('td');
            td.innerHTML = data.leads[k].city.name;
            tr.insertBefore(td, tr.firstChild);
            //Андеррайтер
            var td = document.createElement('td');
            if (data.leads[k].underwriter == null) {
              td.innerHTML = 'Нет';
            } else {

              td.innerHTML = data.leads[k].underwriter.first_name;

            }

            tr.insertBefore(td, tr.firstChild);
            //Лидогенератор

            var td = document.createElement('td');
            var a = document.createElement('a');
            if ((data.leads[k].user.first_name) == null) {
              var linkText = document.createTextNode("Пусто");
            } else {
              var linkText = document.createTextNode(data.leads[k].user.first_name);
            }

            a.appendChild(linkText);
            a.href = "admin/user/" + data.leads[k].user.id + "/leads";
            td.insertBefore(a, td.firstChild);
            tr.insertBefore(td, tr.firstChild);
            //Дата

            var td = document.createElement('td');
            var ds = data.leads[k].created_at;
            ds = moment.tz(ds, "Europe/Moscow");
            d = moment.tz(ds, data.timezone);
            var res = moment(d).format('DD.MM.YYYY HH:mm:ss');
            td.innerHTML = res;
            tr.insertBefore(td, tr.firstChild);

            //тип залога
            var td = document.createElement('td');
            if (data.leads[k].type == 1) {
              td.innerHTML = '<img width="20px" src="img/home.svg" alt="">';
            } else {
              td.innerHTML = '<img width="20px" src="img/car.svg" alt="">';
            }
            tr.insertBefore(td, tr.firstChild);

            i++;
            sound();

            t = data.last_leads[0].created_at;
          }
        }

        del(count);

        if (data.leads != "" && page > 1) {
          var new_lead = document.getElementById('new_lead');
          new_lead.innerHTML = '';
          var a = document.createElement('a');
          var linkText = document.createTextNode('Есть новые лиды');
          a.appendChild(linkText);
          a.href = "";
          new_lead.insertBefore(a, new_lead.firstChild);
          t = data.last_leads[0].created_at;
          sound();
        }
      }
    });
  }


window.select_view = function(x, token, user,i, start, end) {
    var table = document.getElementById('n');
    x_select = x;

    table.innerHTML = '';
    var select_link ='';
    if(i == undefined){ select_link = 'select_view?count='+page_count+'&page=1';}else {
      select_link = 'select_view?count='+page_count+'&page='+i;
    }
    $.ajax({
        type: 'POST',
        url: select_link,
        data: { _token: token, select: x, user: user, start: start, end: end},
        dataType: 'json',
        success: function (data) {

            add_lead(data);
            createPagination(data, i);
        }
    });
}

window.changeCountOnPage = function(count){
  page_count = count;
  var c = '"'+ csrf + '"';
  select_view(x_select, csrf, notification_user_id, '1');

}

window.createPagination = function (data, current_page){

  $(document).ready(function() {
    $('#pagination-block').empty();
    var pagination = document.getElementById('pagination-block');
    var ul = document.createElement('ul');
    ul.setAttribute('role', 'navigation');
    ul.setAttribute('class', 'pagination');
    pagination.insertBefore(ul, pagination.firstChild);
    for (var i = data.leads.last_page; i > 0 ; i--) {

      var li = document.createElement('li');
      li.setAttribute('class', 'page-item');
      if(current_page == i){li.setAttribute('class', 'page-item active');}
      if((current_page == undefined) && (i == 1) ){li.setAttribute('class', 'page-item active');}
      var a = document.createElement('a');
      a.setAttribute('class', 'page-link');
      a.setAttribute('onclick', 'select_view('+x_select+',"'+csrf+'",'+notification_user_id+','+i+')');
      a.innerHTML=i;
      li.insertBefore(a, li.firstChild);
      ul.insertBefore(li, ul.firstChild);
    }

    $('#dropdown-menu').empty();
    $('#dropdown-menu').append('<a onclick="changeCountOnPage(15)" class="dropdown-item">15</a>'+
      '<a onclick="changeCountOnPage(25)" class="dropdown-item">25</a>'+
      '<a onclick="changeCountOnPage(50)" class="dropdown-item">50</a>'+
      '<a onclick="changeCountOnPage(100)" class="dropdown-item">100</a>');

  });
}

window.changeTelegramId = function (telegram, id, telegram_confirmed, telegram_notification_id) {
  $('#error-list').html('');
  if(telegram != ''){
    $.ajax({
        type: 'POST',
        url: change_telegram_id,
        data: { _token: csrf, id: id, telegram: telegram, confirmed: telegram_confirmed, notification_id:telegram_notification_id },
        dataType: 'json',
        success: function (data) {
            $('#telegram-step-2').addClass('d-none');
            $("#telegram-step-3").removeClass('d-none');
        }
    });
  }else {
    $('#telegram-step-2').addClass('d-none');
    $("#telegram-step-3").removeClass('d-none');
  }
}

window.notificationAjax = function (id, notification_id, confirmed, telegram) {
  if (confirmed == null){confirmed = 0;}
  $.ajax({
      type: 'POST',
      url: notification_ajax,
      data: { _token: csrf, id: id, confirmed: confirmed, telegram:telegram, notification_id:notification_id },
      dataType: 'json',
      success: function (data) {
        if(telegram != null) {
        if(data.error == undefined){
          $('#telegram-step-3').addClass('d-none');
          $("#telegram-done").removeClass('d-none');
          $("#button-telegram").addClass('d-none');
          $('#button-telegram-off').removeClass('d-none');
      }else{
        $('#back-to-step-2').removeClass('d-none');
        $("#step-3").addClass('d-none');
        $('#error-list').html('<p class="test-c">Ошибка: ' + data.error +'</p>');
      }
    }
      }
  });
}

window.add_lead = function (data) {
  for (var k = data.leads.data.length - 1; k >= 0; k--) {

    var n = document.getElementById('n');
    var tr = document.createElement('tr');
    tr.id = i;
    tr.setAttribute('class', 'no-color-tr');
    if (data.leads.data[k].transaction_status.id == 4 || data.leads.data[k].status.id == 4) {
      tr.setAttribute('class', 'table-danger tr no-color-tr');
    }
    if (data.leads.data[k].transaction_status.id == 3 && data.leads.data[k].status.id == 3) {
      tr.setAttribute('class', 'table-success tr no-color-tr');
    }
    n.insertBefore(tr, n.firstChild);
    //выдача
    var td = document.createElement('td');
    td.innerHTML = data.leads.data[k].transaction_status.name;

    tr.insertBefore(td, tr.firstChild);
    //проверка
    var td = document.createElement('td');
    var a = document.createElement('a');
    var linkText = document.createTextNode(data.leads.data[k].status.name);
    a.appendChild(linkText);
    a.setAttribute('data-toggle', 'modal');
    if (data.leads.data[k].status.name == 'Не обработан' && data.takeOn == 1) {
      a.setAttribute('onclick', 'showTakeModal("' + data.leads.data[k].id + '","' + data.leads.data[k].last_name + '","' + data.leads.data[k].first_name + '","' + data.leads.data[k].surname + '","' + data.leads.data[k].money + '","' + data.leads.data[k].phone + '")');
      a.href = "#take-on-check-" + data.leads.data[k].id;
    }
    td.insertBefore(a, td.firstChild);
    tr.insertBefore(td, tr.firstChild);

    //фио
    var td = document.createElement('td');
    var a = document.createElement('a');
    var linkText = document.createTextNode(data.leads.data[k].last_name + ' ' + data.leads.data[k].first_name + ' ' + data.leads.data[k].surname);
    a.href = 'lead/' + data.leads.data[k].id;
    a.appendChild(linkText);
    td.insertBefore(a, td.firstChild);
    tr.insertBefore(td, tr.firstChild);

    if(lead == 1){
      //выданная сумма
      var td = document.createElement('td');
      if(data.leads.data[k].total_amount == null){
        td.innerHTML = 'Пусто';
      }else {
        td.innerHTML = data.leads.data[k].total_amount;
      }
      tr.insertBefore(td, tr.firstChild);
    }

    //Су
    var td = document.createElement('td');
    td.innerHTML = data.leads.data[k].money;
    tr.insertBefore(td, tr.firstChild);
    //Город
    var td = document.createElement('td');
    td.innerHTML = data.leads.data[k].city.name;
    tr.insertBefore(td, tr.firstChild);
    if(lead != 1){
      //Андеррайтер
      var td = document.createElement('td');
      if (data.leads.data[k].underwriter == null) {
        td.innerHTML = 'Нет';
      } else {
        td.innerHTML = data.leads.data[k].underwriter.first_name;
      }
      tr.insertBefore(td, tr.firstChild);
        }
      //Лидогенератор
      var td = document.createElement('td');
      var a = document.createElement('a');

      if ((data.leads.data[k].user.first_name) == null) {
        var linkText = document.createTextNode("Пусто");
      } else {
        var linkText = document.createTextNode(data.leads.data[k].user.first_name);
      }
      a.appendChild(linkText);
    //  a.href = "admin/user/" + data.leads.data[k].user.id + "/leads";
      td.insertBefore(a, td.firstChild);
      tr.insertBefore(td, tr.firstChild);

  var td = document.createElement('td');
  var ds = data.leads.data[k].created_at;
  ds = moment.tz(ds, "Europe/Moscow");
  d = moment.tz(ds, data.timezone);
  var res = moment(d).format('DD.MM.YYYY HH:mm:ss');
td.innerHTML = res;
tr.insertBefore(td, tr.firstChild);

//тип залога
var td = document.createElement('td');
if (data.leads.data[k].type == 1) {
  td.innerHTML = '<img width="20px" src="img/home.svg" alt="">';
} else {
  td.innerHTML = '<img width="20px" src="img/car.svg" alt="">';
}
tr.insertBefore(td, tr.firstChild);
i++;
}
}

var temp_id = 'take-on-check-';

window.del = function del(count) {
    var table = document.getElementById('table');

    var inputs = table.getElementsByTagName("tr");
    var i = inputs.length;

    if (inputs.length > count + 1) {
        var input = inputs[inputs.length - 1];

        var tr = input.parentNode.parentNode;
        table.deleteRow(inputs.length - 1);
    }
}


window.showTakeModal = function(i, first_name, last_name, surname, money, phone) {

    var element = document.getElementById(temp_id);
    temp_id = 'take-on-check-' + i;

    element.id = temp_id;

    var firstname = document.getElementById('name1');
    firstname.innerHTML = first_name;
    var lastname = document.getElementById('name2');
    lastname.innerHTML = last_name;
    var sur_name = document.getElementById('name3');
    sur_name.innerHTML = surname;


    var mon = document.getElementById('name4');
    mon.innerHTML = money;
    var ph = document.getElementById('name5');
    ph.innerHTML = phone;

    var link1 = document.getElementById('link1');
    link1.setAttribute('action', 'lead/' + i + '/take_on_check');

}


window.sound = function () {
    var audio = new Audio();
    audio.src = 'sounds/alert.wav';
    audio.autoplay = true;
}


//

window.delete_city = function (token, id) {

    $.ajax({
        type: 'POST',
        url: "delete_city",
        data: {somefield: "Some field value", _token: token, id: id},
        dataType: 'json',
        success: function (data) {


        }
    });

}


window.conf_show = function (id, name, token) {
  if (confirm("Вы уверены, что хотите удалить город?")) {
    $.ajax({
      type: 'POST',
      url: "check_city",
      data: {somefield: "Some field value", _token: token, id: id},
      dataType: 'json',
      success: function (data) {
        if (data.check != '') {
          if (confirm("Внимание, к данному городу привязаны лиды, Вы уверены, что хотите выполнить это действие?")) {
            delete_city(token, id);
            var element = document.getElementById(name);
            element.remove();
          }
        } else {
          delete_city(token, id);
          var element = document.getElementById(name);
          element.remove();
        }
      }
    });
  }else {}
}

var global_id, global_name, global_token;

window.change_input = function change_input() {
    global_name = document.getElementById('input_new_name').value;
}

window.change_input_new_city = function () {
    global_name = document.getElementById('input_new_city').value;
}

window.gl_var = function (id, token) {
    global_id = id;
    global_token = token;
}

window.change_city_name = function () {
    //var name = document.getElementById(input_new_name).value;
    var element = document.getElementById('city-' + global_id);
    element.innerHTML = global_name;

    $.ajax({
        type: 'POST',
        url: "change_city_name",
        data: {somefield: "Some field value", _token: global_token, id: global_id, name: global_name},
        dataType: 'json',
        success: function (data) {
            update_table_cities(data, global_token);
        }
    });
}

window.add_new_city = function (token) {
    $.ajax({
        type: 'POST',
        url: "add_new_city",
        data: {somefield: "Some field value", _token: token, name: global_name},
        dataType: 'json',
        success: function (data) {
            update_table_cities(data, token);
        }
    });
}

window.update_table_cities = function (data, token) {
    var element = document.getElementById('input_new_city');
    element.innerHTML = '';
    var element = document.getElementById('table_content');
    element.innerHTML = "";

    for (var k = 0; k < (data.city.length); k++) {
        var n = document.getElementById('table_content');

        var tr = document.createElement('tr');
        tr.id = data.city[k].name;
        tr.setAttribute('class', ' tr');
        n.insertBefore(tr, n.firstChild);

        var td = document.createElement('td');
        var div1 = document.createElement('div');
        div1.innerHTML = 'Изменить';
        div1.setAttribute('onclick', "gl_var(" + data.city[k].id + ",'" + token + "')");
        div1.setAttribute('onclick', "gl_var(" + data.city[k].id + ",'" + token + "')");
        div1.setAttribute('data-toggle', "modal");
        div1.setAttribute('data-target', "#change_city");

        var div2 = document.createElement('div');
        div2.setAttribute('onclick', 'conf_show(' + data.city[k].id + ',"' + data.city[k].name + '" , "' + token + '")');
        div2.innerHTML = 'Удалить';
        td.insertBefore(div2, td.firstChild);
        td.insertBefore(div1, td.firstChild);
        tr.insertBefore(td, tr.firstChild);

        var td = document.createElement('td');
        td.setAttribute('id', 'city-' + data.city[k].id);
        td.innerHTML = data.city[k].name;
        tr.insertBefore(td, tr.firstChild);
    }
}

window.fun1 = function (id, token) {
    var rad = document.getElementsByName('collateral_' + id);
    for (var i = 0; i < rad.length; i++) {
        if (rad[i].checked) {
            $.ajax({
                type: 'POST',
                url: update_type,
                data: {_token: token, type: i+1, id: id},
                dataType: 'json',
                success: function (data) {
                }
            });
        }
    }
}

var city_array = [];
var x = 0;
var id_city = 0;
var city = '';
var id_user = 0;

window.get_id = function (id2, token) {
    id_user = id2;
    get_city(token);
};

$(document).ready(function () {
  $('#add-city-select').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    id_city = this.value;
    city = $(e.target).find("option:selected").text();
  });
});

$(document).ready(function () {
  $( "#add-city-button" ).click(function() {
    if(city != ''){
    city_array[x] = id_city;
    $("#sel").append( $('<option value="'+id_city+'">'+ city+'</option>'));
    x++;
  }
  });
});

window.send = function(token){
  $.ajax({
    type: 'POST',
    url: update_cities,
    data: { _token: token, arr: city_array, user: id_user},
    dataType: 'json',
    success: function (data) {
    }
  });
}

function find(array, value) {
  for (var i = 0; i < array.length; i++) {
    if (array[i] == value) return i;
  }
  return -1;
}

window.deleteCity = function(){
  var city_selected =  $("#sel option:selected").val();
  var del = find(city_array, city_selected);
  city_array.splice(del, 1);
  $("#sel :selected").remove();
}

window.get_city = function (token) {
  $.ajax({
    type: 'POST',
    url: get_user_cities,
    data: {_token: token, user: id_user},
    dataType: 'json',
    success: function (data) {
      var sel = document.getElementById('sel');
      sel.innerHTML = '';
      city_array = [];
      for (var k = 0; k < data.user_city.length; k++) {
        var option = document.createElement('option');
        option.innerHTML = data.user_city[k].name;
        option.setAttribute('id', data.user_city[k].name);
        option.setAttribute('value', data.user_city[k].id);
        sel.insertBefore(option, sel.firstChild);
        city_array[k] = data.user_city[k].id;
        x = data.user_city.length;
      }
    }
  });

}
$(document).ready(function () {
    $.mask.definitions['h']='[0-9]';
    $.mask.definitions['t']='[0-9]';
    $(".phone").mask("+7 (hhh) hhh-hhhh");
});

$(document).ready(function() {
  $("#button-telegram-off").on("click", function () {
    notificationAjax(notification_user_id, $('#telegram-notification_id').val(),null, null);
    $("#button-telegram").removeClass('d-none');
    $('#button-telegram-off').addClass('d-none');
  });

  $("#button-email-off").on("click", function () {
    notificationAjax(notification_user_id, $('#email-notification_id').val(), null, null);
    $("#button-email").removeClass('d-none');
    $('#button-email-off').addClass('d-none');
  });

  $("#button-email").on("click", function () {
    notificationAjax(notification_user_id, $('#email-notification_id').val(), $('#email-confirmed').val(),null);
    $("#button-email-off").removeClass('d-none');
    $('#button-email').addClass('d-none');
  });

  $("#step-1").on("click", function () {
    $('#telegram-step-1').addClass('d-none');
    $("#telegram-step-2").removeClass('d-none');
  });

  $("#step-2").on("click", function () {
    changeTelegramId( $('#telegram-input').val(), notification_user_id, $('#telegram-confirmed').val(), $('#telegram-notification_id').val() );
  });

  $("#step-3").on("click", function () {
    notificationAjax(notification_user_id, $('#telegram-notification_id').val(), 1, $('#telegram-input').val());
  });

  $("#done").on("click", function () {
    $('#telegram-modal').modal('hide');
    $('#telegram-done').addClass('d-none');
  });

  $('#telegram-modal').on('hidden.bs.modal', function() {
    $("#notification-menu").removeClass('d-none');
  })

  $("#button-telegram").on("click", function () {
    $('#notification-menu').addClass('d-none');

    $("#telegram-step-1").removeClass('d-none');
    $('#notification-menu').addClass('d-none');
  });

  $("#done-email").on("click", function () {
    $('#email-menu').addClass('d-none');
    $("#notification-menu").removeClass('d-none');
  });

  $('#telegram-modal').on('hidden.bs.modal', function() {
    $('#telegram-step-1').addClass('d-none');
    $('#telegram-step-2').addClass('d-none');
    $('#telegram-step-3').addClass('d-none');
    $('#telegram-done').addClass('d-none');
  })

  $('#back-to-step-2').on("click", function(){
    $('#telegram-step-3').addClass('d-none');
    $("#telegram-step-2").removeClass('d-none');
    $('#back-to-step-2').addClass('d-none');
    $("#step-3").removeClass('d-none');
  });
});
