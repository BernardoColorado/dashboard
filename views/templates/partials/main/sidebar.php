    <div class="bg-white" id="sidebar-wrapper">
      <div class="sidebar-heading text-center"><h4 class="font-weight-bolder text-primary">Pit Sistemas</h4></div>
      <div class="sidebar-heading"><img class=" img-fluid mx-0 my-0 rounded-circle" src="{{ base_url() }}/img/sp-stan-face.png" style="max-width: 200px; margin: 5px;"></div>
      <div class="sidebar-heading text-center">
        <small class="text-muted" >{{ user.getNickname() }}</small>
      </div>
      <ul class="list-group list-group-flush">
        <li>
          <span class="list-group-item list-group-item-action bg-white text-secondary text-left" >Menu</span>
        </li>
        <li>
          <a href="{{ base_url() }}/" class="list-group-item list-group-item-action bg-white text-dark">
            <i class="fas fa-home"></i>
            <span class="ml-2">Inicio</span>
          </a>
        </li>
      </ul>
    </div>