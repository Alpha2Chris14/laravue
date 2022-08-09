<template>
    <div>
        <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <Top></Top>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <Side></Side>
      <!-- partial -->
      <div class="main-panel">

        
        <div class="row mt-4 mb-4">
          <div class="col-lg-6 col-sm-12">
            <div class="card ml-2 mr-4 pb-4">
              <div class="row">
                <div class="col-md-12">
                  <img v-bind:src="selectedImage()" v-bind:alt="user.name">
                </div>
                
                <div class="col-md-11 col-sm-10 mt-4 ml-4">
                  <form v-on:submit.prevent="updateUser">
                  <label for="">Name:</label>
                  <input type="text" v-model="user.name" class="form-control">
                  

                  <label for="" class="mt-3">Email:</label>
                  <input type="email" v-model="user.email" class="form-control" >

                  <label for="" class="mt-3">Role:</label>
                  <select v-model="user.role" id=""  class="form-control">
                      <option value="administrator">Administrator</option>
                      <option value="user">User</option>
                      <option value="regular">Regular</option>
                  </select>

                  <input type="file" v-on:change="onFileChange" class="form-control mt-3">

                  <button class="btn btn-outline-success btn-block mt-4">UPDATE PROFILE</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

    <!--Vuew Ends Here-->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.templatewatch.com/" target="_blank">Templatewatch</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
    </div>
</template>

<script>

export default {
    data() {
        return {
            user:{},
            heading:"This is the Profile page",
            img:"",
            file:'',
        }
    },

    methods: {
      fetchUser: function(){
        axios.get('api/profile',{
          headers:{
            Authorization:'Bearer '+localStorage.getItem("token"),
            Accept: 'application/json',
          }
        }).then((response)=>{
          this.user = response.data;
        });
      },

      onFileChange:function(e){
        this.file = e.target.files[0];
        console.log(this.file)
      },

      selectedImage:function(){
        return "upload/"+this.user.photo;
      },


      updateUser:function(){
        console.log(localStorage.getItem("token"))
          this.$Progress.start()

          // console.log("xxx"+this.img);

           let data = new FormData();
           data.append("_method","put");
            data.append('photo', this.file);
            data.append('name',this.user.name);
            data.append('email',this.user.email);
            data.append('role',this.user.role);
        

            console.log(data);

            axios.post('api/user/'+this.user.id, data,
            // {
            //     name: this.user.name,
            //     email: this.user.email,
            //     role:this.user.role,
            //     photo:this.img,
            // },
            {
              headers:{
                
                  'Accept':'application/json',
                  'content-type': 'multipart/form-data',   
                  Authorization:'Bearer '+localStorage.getItem("token"),
                  // 'content-type':"multipart/form-data; charset=uft-8; boundary="+Math.random().toString().substr(2),
                },
              },
            )
            .then((response) => {
                // console.log(response);
                fire.$emit("refreshUsers");
                this.$swal({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Your Profile Was Updated Successfully',
                  showConfirmButton: false,
                  timer: 1500
                })
                this.$Progress.finish()
            })
            .catch((error) => {
                let a = error.response.data.errors;
                this.err.name = a.name[0];
                this.err.email = a.email[0];
                this.err.role = a.role[0];
                // console.log(this.err.name);
                // this.$Progress.fail()
            });
            
            
        },
    },
    created() {
      this.fetchUser();
      this.selectedImage();
    },
}
</script>

<style scoped>
  img{
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    width: inherit;
  }

  .card{
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
  }
</style>                                                                                              