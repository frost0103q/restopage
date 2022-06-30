<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Company Panel - Register</title>

  <!-- Custom fonts for this template-->
  <link href="<?=base_url('assets/comp_assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?=base_url('assets/comp_assets/')?>css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block " style="background-image: url('<?=base_url('assets/images/bg-two.jpeg')?>');background-size: cover;">></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" id="compRegister">
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Company Name" name="comp_name">
                  </div>
                  <!-- <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
                  </div> -->
                </div>
                <div class="form-group">
                  <input type="email" name="comp_email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Company Email Address">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="Phone Number" name="comp_phone">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Company Password" name="comp_pass">
                  </div>
                </div>
                <input type="submit" name="" value="Register Account" class="btn btn-primary btn-user btn-block">
                <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                  Register Account
                </a> -->
                <hr>
                <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a> -->
              </form>
              <hr>
              <!-- <div class="text-center">
                <a class="small" href="<?=base_url('CompLogin/forgotPassword')?>">Forgot Password?</a>
              </div> -->
              <div class="text-center">
                <a class="small" href="<?=base_url('CompLogin/')?>">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  
  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url('assets/comp_assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url('assets/comp_assets/')?>js/sb-admin-2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#compRegister').submit(function(e){
        var formData=new FormData($(this)[0]);
        e.preventDefault();
        $.ajax({
          url:"<?=base_url('CompLogin/registerCompany')?>",
          type:"post",
          cache:false,
          contentType:false,
          processData:false,
          data:formData,
          success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.code==1){
              swal("Great..","Registered Successfully.","success");
            }else if(response.code==2){
              swal("Ooops..","Account with same email id Already Exists","warning");
            }else{
              swal("Ooops..","Server Not Found","error");
            }
            setInterval(function(){
              location.reload();
            },2000)
          }
        });
      }); 
    });
  </script>
</body>

</html>
