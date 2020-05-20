{% extends 'templates/globals/user.php' %}

{% block content %}
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="card bg-dark rounded-0 shadow">
          <div class="row no-gutters">

            <div class="col-lg-4 bg-white">
              <img class="card-img rounded-0" src="{{ base_url() }}/img/logo-pit-escudo.jpg">
            </div>

            <div class="col-lg-5 mx-auto">
              <div class="card-body">

                <h4 class="card-title text-center text-primary">WELLCOME <b class="text-success">{{user.getNickname()}}</b></h4>

                <h5 class="card-title text-center text-primary">An email has been already sent to <b  class="text-success">{{user.getEmail()}}</b></h5>

                <form action="{{ base_url() }}/user/activation" method="POST">
                  <div class="form-group mt-3">
                    <label class="text-secondary">Activation Code</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text text-white bg-primary border-0">
                        <i class="fas fa-hashtag"></i>
                        </div>
                      </div>
                      <input class="form-control rounded-0" type="password" name="code" required>
                    </div>
                    {% for error in errors.code %}
                    <small class="form-text text-danger">{{error}}</small>
                    {% endfor %}
                  </div>
                  <div class="form-group mt-4">
                    <button class="btn btn-primary btn-block rounded-0" type="submit">ACTIVATE</button>
                  </div>

                  <div class="form-group mt-4">
                    <a href="{{base_url()}}/user/reactivation">Resend Email</a>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
{% endblock %}