<!DOCTYPE html>
<html lang="en">
<head>
{% include 'templates/partials/main/head.php' %}
{% block neck %}

{% endblock %}
</head>
<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    {% include 'templates/partials/main/sidebar.php' %}
    <!-- End Sidebar -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <!--Navbar-->
      {% include 'templates/partials/main/navbar.php' %}
      <!--End Navbar-->

      <!--==================================== CONTENT ======================================-->
        {% block breadcrumb %}

        {% endblock %}
        {% block content %}

        {% endblock %}
      <!--================================ END CONTENT ======================================-->
      
    </div>
  </div>
  {% include 'templates/partials/main/feet.php' %}
</body>

</html>
