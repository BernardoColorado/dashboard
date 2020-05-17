{% extends 'templates/globals/main.php' %}
{% block neck %}
<link rel="stylesheet" href="{{ base_url() }}/css/parallax.css">
{% endblock %}
{% block breadcrumb %}
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-dark mt-3 shadow">
      <li class="breadcrumb-item text-light"><a href="{{ base_url() }}/">Inicio</a></li>
      <li class="breadcrumb-item text-light">Archivos</li>
    </ol>
  </nav>
</div>
{% endblock %}
{% block content %}
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card border-0">
        <div class="card-body bg-dark">
          <form action="{{base_url()}}/file/upload" method="POST" class="form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" name="file_upload" class="form-control-file bg-dark text-light">
            </div>
            <div class="form-group">
              <button class="btn btn-primary rounded-0" type="submit">Subir</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{% endblock %}