<template>
    <div>
       <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="" alt="logo">
              </div>
              <h4>Welcome back!</h4>
              <h6 class="font-weight-light">Happy to see you again!</h6>
              <form class="pt-3" v-on:submit.prevent="processLogin">
                <div class="form-group">
                  <label for="exampleInputEmail">Email Address</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-user text-primary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" id="exampleInputEmail" v-model="email" placeholder="Email Address" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" v-model="password" placeholder="Password" required>                        
                  </div>
                </div>
                <div class="my-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button> 
                  <!-- <input type="submit" value="Submit"> -->
                </div>
                
              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2022  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  
    </div>
</template>

<script>
export default {
    data(){
      return {
        email :"",
        password:"",
      }
    },

    methods: {
      processLogin:function(){
        //console.log("Hello")
        this.$Progress.start()
            axios.post('api/login', {
                email: this.email,
                password:this.password,
            })
            .then((response) => {
                if(response.status === 201){
                  console.log(response);
                  // console.log(response.data.token);
                  token.$emit("authorization",response.data.token);
                  this.$router.replace({name:'Users'});
                }
            });
      }
    },
}
</script>
