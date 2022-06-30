
  <div class="container">
    <?php
      $compData=unserialize($this->session->userdata('logged_company'));
      
    ?>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Post New Job</h1>
                <hr>
              </div>
              <form class="user" id="postNewJob">
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Job Title" name="job_title" value="">
                  </div>
                  <!-- <div class="col-sm-6 mb-3 mb-sm-0"> -->
                     <!-- <select class="form-control " name="exp"> -->
                      <!-- <option>Experience</option>
                      <?php for($i=1; $i<=20;$i++): ?>
                        <option value="<?=$i?>"><?=$i?></option>
                      <?php endfor;?>
                    </select>
                  </div>
                   -->
                </div>
                <div class="form-group row">
                  <label>Job Description</label>
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <textarea class="form-control form-control-user" rows="5"placeholder="Job Description" name="job_desc" >
                      
                    </textarea>
                   
                  </div>
                  
                  
                </div>
                
                <div class="form-group row">
                  <div class="col-md-3">
                    <label>Vaccancies</label>
                    <select class="form-control " name="vacancy">
                      <!-- <option>Vacancy</option> -->
                      <?php for($i=1; $i<=20;$i++): ?>
                        <option value="<?=$i?>"><?=$i?></option>
                      <?php endfor;?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Job Category</label>
                    <select class="form-control " name="job_cat">
                      <!-- <option>Category</option> -->
                       <?php foreach($Categories as $cat): ?>
                        <option value="<?=$cat->category_id?>"><?=$cat->category_name?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Job Type</label>
                    <select class="form-control " name="job_type">
                      <!-- <option>Job Type</option> -->
                      <?php foreach($Type as $ty): ?>
                        <option value="<?=$ty->type_id?>"><?=$ty->type_name?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Last Date</label>
                    <input type="date" id="field" name="last_Date" class="form-control ">
                  </div>
                </div>
                <div class="form-group row">
                  <label>Skills Need</label>
                </div>
                <div class="form-group row">
                  <?php foreach($Skills as $skill): ?>
                    <div class="col">
                      <input type="checkbox" name="skills[]" value="<?=$skill->skill_id?>"> <?=$skill->skill_name?>
                    </div>
                      
                  <?php endforeach;?>
                  
                </div>
                <div class="form-group row">
                   <div class="col-md-12"> 
                   <label>Work Experience</label>
                     <div class="row">
                            <div class="col-md-3">
                            <select class="form-control"  required name="minimumwork">
                              <option selected>Minimum</option>
                              <option  value="0">0</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                               <option value="29">29</option>
                                <option value="30">30</option>
                            </select>
                          </div>
                             <h6 class="mt-2">to</h6>
                              <div class="col-md-3">
                                <select class="form-control" required name="maximumwork">
                              <option selected>Maximum</option>                             
                              <option  value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                               <option value="29">29</option>
                                <option value="30">30</option>
                            </select>  
                            </div>
                            
                      </div> 
                     
                  </div>
                  
  
                </div>
                 <div class="form-group row">
                  <label>Annual CTC</label>
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <div class="row">
                                   <div class="col-md-4" >
                                      <fieldset class="form-group" id="currencyrefresh">
                                      
                                    <select class="form-control"   required name="currencytype">
                                     <option selected>Currency</option> 
                                      <?php
                                        foreach($currency as $currencytype)
                                        { 
                                          // print_r($company);?>  
                                        <option value="<?=$currencytype->curr_id?>"><?=$currencytype->currency_name?></option>
                                         <?php
                                       }?>
                                       </select>
                                    <button type="button"  data-toggle="modal" data-target="#modalPush" id="acount" class=" btn-light " title="New Accounts"><i class="fa fa-plus"></i></button>
                                                  
                                  </fieldset>
                               </div>
                               <div class="col-md-4" >
                                  <fieldset class="form-group" id="minsalaryrefresh">
                                      
                                    <select class="form-control"   required name="minisalary">
                                     <option selected>Min Annual Salary</option> 
                                      <?php
                                        foreach($min_salary as $min_sal)
                                        { 
                                          // print_r($company);?>  
                                        <option value="<?=$min_sal->min_sal_id?>"><?=$min_sal->min_salary?></option>
                                         <?php
                                       }?>
                                       </select>
                                    <button type="button"  data-toggle="modal" data-target="#min_salary_modal" id="acount" class=" btn-light " title="New Min Salary"><i class="fa fa-plus"></i></button>
                                                 
                                  </fieldset>
                                </div>
                                    <div class="col-md-4 ">
                                   <fieldset class="form-group"  id="maxsalaryrefresh"> 
                                    <select class="form-control"   required name="maxxsalary">
                                     <option selected>Max Annual Salary</option> 
                                      <?php
                                        foreach($max_salary as $max_sal)
                                        { 
                                          // print_r($company);?>  
                                        <option value="<?=$max_sal->max_sal_id?>"><?=$max_sal->max_sal?></option>
                                         <?php
                                       }?>
                                       </select>
                                    <button type="button" data-toggle="modal" data-target="#max_salary_modal" id="acount" class=" btn-light " title="New Accounts"><i class="fa fa-plus"></i></button>
                                                 
                                  </fieldset>
                                </div>
                             
                                   </div>
                   
                  </div>
                  
                  
                </div>
                       <div class="form-group col-md-12 ">
                         <label>Job Location</label>
                          <fieldset class="form-group row">
                          <input type="text" class="form-control" required  name="joblocation">   </fieldset>
                      </div>  
                      <div class="form-group ">
                            <label>Specify UG Qualifications</label>
                           <fieldset class="form-group">
                              <p class="text-danger">(Mandatory)**</p> 
                                <input type="text" class="form-control" required  name="ugqualification">                         
                          </fieldset>
                      </div>
                      <div class="form-group ">
                        <label>Specify PG Qualifications</label>
                         <fieldset class="form-group">
                           <p class="text-danger">(If Not Type None)**</p> 
                          <input type="text" class="form-control" required  name="pgqualification">                         
                      </fieldset>
                      </div>
                      <div class="form-group ">
                        <label>Specify Doctorate/Ph.D</label>
                        <fieldset class="form-group">
                          <p class="text-danger">(If Not Type None)**</p> 
                        <input type="text" class="form-control" required  name="doctorate_phd"> 
                      </fieldset>
                      </div>

                <input type="submit" name="" value="Post Job" class="btn btn-primary btn-user btn-block">
       
              
              </form>
              <hr>
              
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex btn btn-info justify-content-center">
        <h3 class="heading text-white"><i>Add New Currency</i></h3>
      </div>

      <!--Body-->
      <div class="modal-body">

         <i class="fa fa-money fa-4x animated rotateIn mb-4"></i> 
       
         <form id="currency" >
        <h5 class="mt-2">New Currency</h5>
        <fieldset class="form-group">
            
            <input type="text" class="form-control" required  name="newcurrency">                         
        </fieldset>
        <div class="modal-footer flex-center">
           <button type="submit" class=" btn btn-success btn-min-width mr-1 mb-1">Add</button>
        <a type="button" class="btn btn-danger btn-min-width mr-1 mb-1 text-white" data-dismiss="modal">Cancel</a>
      </div>
    </div>
</form>
      </div>
  </div>
</div>
<!--Modal: currency modal-->

<!--Modal: Min Annual salary-->
<div class="modal fade" id="min_salary_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header btn btn-info d-flex justify-content-center">
        <h3 class="heading text-white"><i>Add Min Annual Salary</i></h3>
      </div>

      <!--Body-->
      <div class="modal-body">

         <i class="fa fa-money fa-4x animated rotateIn mb-4"></i> 
       
         <form id="minsalary" >
        <h5 class="mt-2 text-muted">Min Annual Salary</h5>
        <fieldset class="form-group">
            
            <input type="text" class="form-control" required  name="minannualsalary">                         
        </fieldset>
        <div class="modal-footer flex-center">
           <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1">Add</button>
        <a type="button" class="btn btn-danger btn-min-width mr-1 mb-1 text-white" data-dismiss="modal">Cancel</a>
      </div>
    </div>
</form>
      </div>
  </div>
</div>
<!--Min Annual salary-->

<div class="modal fade" id="max_salary_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header btn btn-info d-flex justify-content-center">
        <h3 class="heading text-white"><i>Add Max Annual Salary</i></h3>
      </div>

      <!--Body-->
      <div class="modal-body">

         <i class="fa fa-money fa-4x animated rotateIn mb-4"></i> 
       
         <form id="maxsalary" >
        <h5 class="mt-2">Max Annual Salary</h5>
        <fieldset class="form-group">
            
            <input type="text"  class="form-control" required  name="maxannualsalary">                         
        </fieldset>
        <div class="modal-footer flex-center">
           <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1">Add</button>
        <a type="button" class="btn btn-danger btn-min-width mr-1 mb-1 text-white" data-dismiss="modal">Cancel</a>
      </div>
    </div>
</form>
      </div>
  </div>
</div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#postNewJob').on('submit',function(e){
      e.preventDefault();
      var formData=new FormData($(this)[0]);
      console.log("Working Fine");
      $.ajax({
        url:"<?=base_url('CompanyLogic/postNewJob')?>",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
          
          response=JSON.parse(response);
          if(response.code==1){
            swal("Great..","Job Posted Successfully.","success");
          }else if(response.code==0){
            swal("Ooops..","Something went wrong","error");
          }else{
            swal("Ooops..","Job Already Exists","warning");
          }
          $('#postNewJob')[0].reset();
        }
      });
    });
  });
</script>
 <script type="text/javascript"> 
$(document).on('submit','#maxsalary',function(e){
     e.preventDefault();
         var formData= new FormData($(this)[0]);
         // alert('cas');
         $.ajax({
            url:"<?=base_url('Admin_Job/addMaxSalalry')?>",
             type:"post",
             catche:false,
             contentType:false,
             processData:false,
             data:formData,
             success:function(response)
            {
                 var obj=JSON.parse(response);
                  console.log(obj.status);
                 if(obj.status==0)
                 {
                    swal("Maximum Salary!", "Try Again", "error")
                 }
                 if(obj.status==1)
                 {
                  swal("Maximum Salary!", "Added", "success")
                 }
                 if(obj.status==2)
                 {
                 swal("Maximum Salary!", "Already Exist", "error")
                 }
                $("#maxsalaryrefresh").load(location.href + " #maxsalaryrefresh");
            }
        
             });    
       
});
</script>
     <script type="text/javascript"> 
$(document).on('submit','#minsalary',function(e){
     e.preventDefault();
         var formData= new FormData($(this)[0]);
         // alert('cas');
         $.ajax({
            url:"<?=base_url('Admin_Job/addMinSalary')?>",
             type:"post",
             catche:false,
             contentType:false,
             processData:false,
             data:formData,
             success:function(response)
            {
                 var obj=JSON.parse(response);
                  console.log(obj.status);
                 if(obj.status==0)
                 {
                    swal("Minimun Salary!", "Try Again", "error")
                 }
                 if(obj.status==1)
                 {
                  swal("Minimun Salary!", "Added", "success")
                 }
                 if(obj.status==2)
                 {
                 swal("Minimun Salary!", "Already Exist", "error")
                 }
                $("#minsalaryrefresh").load(location.href + " #minsalaryrefresh");
            }
        
             });    
       
});
</script>
    <script type="text/javascript"> 
$(document).on('submit','#currency',function(e){
     e.preventDefault();
         var formData= new FormData($(this)[0]);
         // alert('cas');
         $.ajax({
            url:"<?=base_url('Admin_Job/addNewCurrency')?>",
             type:"post",
             catche:false,
             contentType:false,
             processData:false,
             data:formData,
             success:function(response)
            {
                 var obj=JSON.parse(response);
                  console.log(obj.status);
                 if(obj.status==0)
                 {
                    swal("Currency!", "Try Again", "error")
                 }
                 if(obj.status==1)
                 {
                  swal("Currency!", "Added", "success")
                 }
                 if(obj.status==2)
                 {
                 swal("Currency!", "Already Exist", "error")
                 }
                $("#currencyrefresh").load(location.href + " #currencyrefresh");
            }
        
             });    
    

    
});
</script>
 <script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
    dd='0'+dd
    } 
    if(mm<10){
    mm='0'+mm
    } 
    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("field").setAttribute("min", today);
</script> 