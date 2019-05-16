<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});
Breadcrumbs::for('reports', function ($trail) {
    $trail->parent('home');
    $trail->push('Отчеты', route('reports'));
});
Breadcrumbs::for('report_month', function ($trail, $category) {
    $trail->parent('reports');
    $trail->push($category, route('report_month', $category));
});
Breadcrumbs::for('lead.show', function ($trail, $category) {
    $lead = \App\Models\Lead::find($category);
    $trail->parent('home');
    $trail->push('Лид: ' . $lead->first_name , route('lead.show', $category));
});
Breadcrumbs::for('lead.edit', function ($trail, $category) {
    $trail->parent('lead.show', $category);
    $trail->push('Редактировать');
});
Breadcrumbs::for('user.show', function ($trail, $category) {
    $trail->parent('home');
    $trail->push('Личные данные', route('user.show', $category));
});
Breadcrumbs::for('edit_change_password', function ($trail, $category) {
    $trail->parent('user.show', $category);
    $trail->push('Сменить пароль');
});
Breadcrumbs::for('user.edit', function ($trail, $category) {
    $trail->parent('user.show', $category);
    $trail->push('Редактировать');
});
Breadcrumbs::for('admin_user', function ($trail) {
    $trail->parent('home');
    $trail->push('Пользователи', route('admin_user'));
});

Breadcrumbs::for('admin_show_leads', function ($trail, $category) {
    $user = \App\Models\User::find($category);
    $trail->parent('admin_user', $category);
    $trail->push($user->role->name . ': ' .  $user->first_name, route('admin_show_leads', $category));
});

Breadcrumbs::for('admin_lead_statistic', function ($trail, $category) {
    $user = \App\Models\User::find($category);
    $trail->parent('admin_show_leads', $category);
    $trail->push(' Статистика');
});
Breadcrumbs::for('admin_user_edit', function ($trail, $category) {
    $trail->parent('admin_show_leads', $category);
    $trail->push('Личные данные', route('admin_user_edit', $category));
});
Breadcrumbs::for('underwriter_report_taken_on_check_leads', function ($trail, $category) {
    $user = \App\Models\User::find($category);
    $trail->parent('admin_user');
    $trail->push('Проверяемые Лиды: ' . $user->role->name . ' \'' . $user->first_name . '\'' , route('underwriter_report_taken_on_check_leads', $category));
});
Breadcrumbs::for('underwriter_report_invite_leads', function ($trail, $category) {
    $user = \App\Models\User::find($category);
    $trail->parent('admin_user');
    $trail->push('Приглашенные Лидогенераторы: ' . $user->role->name . ' \'' . $user->first_name . '\'', route('underwriter_report_invite_leads', $category));
});
Breadcrumbs::for('report_pay', function ($trail, $category) {
    $trail->parent('reports');
    $trail->push('Оплата' , route('report_pay', $category));
});

Breadcrumbs::for('leadgen_details', function ($trail, $category) {
    $trail->parent('reports');
    $trail->push('Лиды пользователя' , route('leadgen_details', $category));
});
Breadcrumbs::for('edit_change_email', function ($trail, $category) {
    $trail->parent('user.show', $category);
    $trail->push('Сменить почту');
});
Breadcrumbs::for('telegram_id', function ($trail) {
    $trail->parent('home');
    $trail->push('Как узнать свой телеграм id');
});
Breadcrumbs::for('api', function ($trail) {
    $trail->parent('home');
    $trail->push('API');
});

Breadcrumbs::for('admin_add_cities', function ($trail) {
    $trail->parent('home');
    $trail->push('Добавить город');
});

Breadcrumbs::for('cities_list', function ($trail, $category) {
    $trail->parent('user.show', $category);
    $trail->push('Список городов');
});
Breadcrumbs::for('admin_user_custom', function ($trail, $category) {
    $trail->parent('admin_user', $category);
    switch ($category) {
      case 1:
      $result = "Администраторы";
      break;
      case 2:
      $result = "Частные инвеcторы";
      break;
      case 3:
      $result = "Лидогенераторы";
      break;
      case 4:
      $result = "Руководители";
      break;
      case 5:
      $result = "Заблокированные";
      break;
    }
    $trail->push($result);
});

Breadcrumbs::for('user_history', function ($trail, $category) {
  $user = \App\Models\User::find($category);
    $trail->parent('admin_user', $category);
    $trail->push('История изменений данных пользователя: '.$user->last_name.' '.$user->first_name.' '.$user->surname);
});

Breadcrumbs::for('search_by_cities', function ($trail, $category) {
    $trail->parent('admin_user', $category);
    $trail->push($category);
});

Breadcrumbs::for('admin_search_name', function ($trail) {
    $trail->parent('admin_user', 'Поиск');
    $trail->push('Поиск');
});
