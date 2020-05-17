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

                <h3 class="card-title text-center text-primary">REGISTRATION</h3>

                <form action="{{ base_url() }}/user/signup" method="post">

                  <div class="form-group mt-3">
                    <label class="text-secondary">Nickname</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text text-white bg-primary border-0">
                          <i class="fa fa-user"></i>
                        </div>
                      </div>
                      <input class="form-control rounded-0" type="text" name="nickname" required>
                    </div>
                    {% for error in errors.nickname %}
                    <small class="form-text text-danger">{{error}}</small>
                    {% endfor %}
                  </div>

                  <div class="form-group mt-3">
                    <label class="text-secondary">Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text text-white bg-primary border-0">
                          <i class="fa fa-envelope"></i>
                        </div>
                      </div>
                      <input class="form-control rounded-0" type="email" name="email" required>
                    </div>
                    {% for error in errors.email %}
                    <small class="form-text text-danger">{{error}}</small>
                    {% endfor %}                  
                  </div>

                  <div class="form-group mt-3">
                    <label class="text-secondary">Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text text-white bg-primary border-0">
                          <i class="fa fa-key"></i>
                        </div>
                      </div>
                      <input class="form-control rounded-0" type="password" name="password" required>
                    </div>                
                  </div>

                  <div class="form-group mt-3">
                    <label class="text-secondary">Confirm Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text text-white bg-primary border-0">
                          <i class="fa fa-key"></i>
                        </div>
                      </div>
                      <input class="form-control rounded-0" type="password" name="password_confirm" required>
                    </div>
                    {% for error in errors.password %}
                    <small class="form-text text-danger">{{error}}</small>
                    {% endfor %}                  
                  </div>

                  <div class="form-group mt-4">
                    <button class="btn btn-primary btn-block rounded-0" type="submit">SIGNUP</button>
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
{% endblock %}


