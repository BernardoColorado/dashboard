{% extends 'templates/globals/main.php' %}
{% block breadcrumb %}

<div class="container-fluid">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-dark mt-3 shadow">
            <li class="breadcrumb-item text-light"><a href="{{ base_url() }}/">Inicio</a></li>
            <li class="breadcrumb-item text-light"><a href="{{ base_url() }}/dashboard">Data Studio</a></li>
            <li class="breadcrumb-item text-light">{{ dashboard.title }}</li>
          </ol>
        </nav>
</div>
{% endblock %}
{% block content %}
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <iframe class="mx-auto" width="{{ dashboard.width }}" height="{{ dashboard.height }}" src="{{ dashboard.url }}" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
  </div>
</div>
{% endblock %}