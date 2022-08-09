<template>
<div class="container-scroller">
    <Top></Top>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <Side></Side>
      <!-- partial -->
      <div class="main-panel">


    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                        <h2 class="display-2">All Users</h2>
                    </div>
                  
                  <div class="col-md-4" id="create">
                    <a href="" class="btn btn-success" data-toggle="modal" data-target="#modal">Create New User</a>
                  </div>
                    </div>

                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form v-on:submit.prevent="saveUser">
                        <div class="modal-body">
                            <input type="text" name="name" v-model="user.name" class="form-control" placeholder="Username">
                            <p class="error">{{err.name}}</p>

                            <input type="email" name="email" v-model="user.email" class="form-control"  placeholder="Email Address">
                            <p class="error">{{err.email}}</p>

                            <input type="password" name="password" v-model="user.password" class="form-control"  placeholder="Password" autocomplete="password">
                            <p class="error">{{err.password}}</p>


                            <select class="form-control" v-model="user.role" name="role">
                            <option value="administrator">Administrator</option>
                            <option value="user">User</option>
                            <option value="regular">Regular</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create User</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>

                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>
                            User
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Role
                          </th>
                          <th>
                            Created At
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="use in users" v-bind:key="use.id">
                          <td class="py-1">
                            <img v-bind:src="displayImage(use.photo)" v-bind:alt="use.name">
                          </td>
                          <td>
                            {{use.name}}
                          </td>
                          <td>
                            {{use.email}}
                          </td>
                          <td>
                            {{use.role | capitalize}}
                          </td>
                          <td>
                            {{use.created_at | formatDate}}
                          </td>
                          <td>
                                <tr>
                                    <td>
                                        <button class="btn btn-success btn-rounded btn-icon">
                                        <i class="ti-pencil-alt"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button v-on:click="deleteUser(use.id)" class="btn btn-danger btn-rounded btn-icon">
                                        <i class="ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                          </td>
                        </tr>
                       
                      </tbody>
                    </table>
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
</template>

<script>
export default {
    data() {
        return {
            user:{
                name:"",
                email:"",
                password:"",
                role:"",
            },
            err:{
              name:"",
              email:"",
              password:"",
            },
            users:[],
            heading:"This is the User page",
        }
    },

    methods: {
        saveUser:function(){
          this.$Progress.start()
            axios.post('api/user', {
                name: this.user.name,
                email: this.user.email,
                password:this.user.password,
                role:this.user.role,
            })
            .then((response) => {
                // console.log(response);
                fire.$emit("refreshUsers");
                $('#modal').modal('hide');
                this.$swal({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Your work has been saved',
                  showConfirmButton: false,
                  timer: 1500
                })
                this.$Progress.finish()
            })
            .catch((error) => {
                let a = error.response.data.errors;
                this.err.name = a.name[0];
                this.err.email = a.email[0];
                this.err.password = a.password[0];
                // console.log(this.err.name);
                // this.$Progress.fail()
            });
            
            
        },

        displayUsers:function(){
            axios.get('api/user',{
              headers:{
                Authorization:'Bearer '+localStorage.getItem("token"),
                Accept: 'application/json',
              }
            }).then((response)=>{
                  this.users = response.data.data
                  console.log("Response "+response.data);
              });
        },

        deleteUser:function(id){
          this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('api/user/'+id).then((response)=>{
                  this.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'User was deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                      })
                  this.displayUsers();
                });
            }
          })
          
        },

        displayImage:function(data){
          return "upload/"+data;
        }
    },

    created() {
        fire.$on('refreshUsers',()=>{
            this.displayUsers();
        });
        
        userSearch.$on("user",(data)=>{
            this.users = data;
            console.log("Retrieved "+data)
        });
        this.displayUsers();
    },
}
</script>

<style scoped>
    .row{
        margin:2px!important;
        margin-top:20px !important;
    }

    #create{
        align-self: center;
    }

    .error{
      color:red;
    }
</style>