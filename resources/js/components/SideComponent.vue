<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
                <router-link class="nav-link" to="/home">
                    <i class="ti-shield menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>

            <li class="nav-item" v-if="$gate.isAdmin()">
                <router-link class="nav-link" to="/users">
                    <i class="ti-gallery menu-icon"></i>
                    <span class="menu-title">Users</span>
                </router-link>
            </li>
          
            <li class="nav-item">
                    <router-link class="nav-link" to="/profile">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Profile</span>
                    </router-link>
            </li>

            <li class="nav-item" v-on:click="signOut">
                    <router-link class="nav-link" to="/logout">
                        <i class="ti-power-off menu-icon"></i>
                        <span class="menu-title">Sign Out</span>
                    </router-link>
            </li>

            
        </ul>
      </nav>
</template>

<script>
export default {
    methods: {
        signOut:function(){
            console.log("out")
            axios.delete("api/logout",{
                headers:{
                    Authorization:'Bearer '+localStorage.getItem("token"),
                }
            }).then(()=>{
                this.$router.replace({name:"Login"});
                localStorage.clear();
            });
        }
    },
    created(){
        console.log("Hello "+(this.$gate).isAdmin());
    }
}
</script>