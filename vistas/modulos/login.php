
    <!-- Preloader -->
    <div class="preloader">
      <img src="vistas/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="vistas/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->      <div class="position-relative overflow-hidden radial-gradient min-vh-100">
        <div class="position-relative z-index-5">
          <div class="row">
            <div class="col-xl-7 col-xxl-8">
              <a href="./index.html" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                <img src="vistas/dist/images/logos/dark-logo.svg" width="180" alt="">
              </a>
              <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                <img src="vistas/dist/images/backgrounds/login-security.svg" alt="" class="img-fluid" width="500">
              </div>
            </div>
            <div class="col-xl-5 col-xxl-4">
              <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                <div class="col-sm-8 col-md-6 col-xl-9">
                  <h2 class="mb-3 fs-7 fw-bolder">Welcome to Modernize</h2>
                  <p class=" mb-9">Your Admin Dashboard</p>
                  <div class="row">
                    <div class="col-6 mb-2 mb-sm-0">
                      <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                        <img src="vistas/dist/images/svgs/google-icon.svg" alt="" class="img-fluid me-2" width="18" height="18">
                        <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>Google
                      </a>
                    </div>
                    <div class="col-6">
                      <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                        <img src="vistas/dist/images/svgs/facebook-icon.svg" alt="" class="img-fluid me-2" width="18" height="18">
                        <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>FB
                      </a>
                    </div>
                  </div>
                  <div class="position-relative text-center my-4">
                    <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">or sign in with</p>
                    <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                  </div>
                  <form method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label" name>Username</label>
                      <input type="text" class="form-control" aria-describedby="emailHelp" name="ingUsuario" required >
                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label" >Password</label>
                      <input type="password" class="form-control" name="ingPassword" required >
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                          Remeber this Device
                        </label>
                      </div>
                      <a class="text-primary fw-medium" href="./authentication-forgot-password.html">Forgot Password ?</a>
                    </div>
                    <button class="btn btn-primary w-100 py-8 mb-4 rounded-2" type="submit">Sign In</button>
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-medium">New to Modernize?</p>
                      <a class="text-primary fw-medium ms-2" href="./authentication-register.html">Create an account</a>
                    </div>
                    <?php

                            $login = new ControladorUsuarios();
                            $login-> ctrIngresoUsuario();

                    ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>