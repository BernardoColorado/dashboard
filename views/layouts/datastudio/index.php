{% extends 'templates/globals/main.php' %}
{% block breadcrumb %}
<div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-dark mt-3 shadow">
            <li class="breadcrumb-item text-light"><a href="{{ base_url() }}/">Inicio</a></li>
            <li class="breadcrumb-item text-light">Dashboard</li>
          </ol>
        </nav>
</div>
{% endblock %}
{% block content %}
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="card bg-dark">
        <div class="row no-gutters">
          <div class="col-lg-1">
            <img src="{{ base_url() }}/img/google-logo.png"class="card-img">
          </div>
          <div class="col-lg-11">
            <div class="card-body text-center">
              <h1 class="card-title text-light mt-4">Dashboard</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
  {% for dashboard in dashboards %}
    <div class="col-lg-3 mx-auto mt-4">
      <div class="card bg-dark shadow">
        <div class="card-header">
          <h3 class="text-info text-center">{{ dashboard.title }}</h3>
        </div>
        <img class="card-img" src="{{ base_url() }}/img/data-studio.png" alt="">
        <div class="card-footer p-0">
          <a href="{{ base_url() }}/dashboard/{{ dashboard.id }}" class="btn btn-success btn-block text-light">DASHBOARD</a>
        </div>
      </div>
    </div>
  {% endfor %}
  </div>
</div>
{% endblock %}