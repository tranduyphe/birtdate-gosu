<script>
export default {
    components: {
    }, 
    data: () => {
        return {}
    },
    computed: {
    },
    methods: {
        // ...authMethods,
        // async signOut(){
        //     console.log("signOut");
        //     await this.logout();
        // }

        handleLinkClick() {
            this.$router.push('/bachnhatgosu2023');
        }
    },
    created: () => {
    },
    mounted: () =>{    
    },
};
</script>
<template>
    <div class="navbar_home">
        <nav class="navbar navbar-expand-lg justify-content-between">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                <router-link to="/site-map" class="logo logo-dark d-block text-center">
                    <span class="logo-lg">
                        <img src="../../../assets/images/sinhnhat11nam/img_main/logo-white.png" alt="" height="35" />
                    </span>
                </router-link>
                </div>
            </div>
            <div class="d-flex pe-0 pe-lg-3">
                <ul class="nav-items-link pr-4">
                <li>
                    <router-link to="wall">Padlet</router-link>
                </li>
                <li>
                    <a target="_blank" href="https://gosucorp.vn/">gosucorp</a>
                </li>
                <li>
                    <a target="_blank" href="https://s20.gosu.vn/">S20</a>
                </li>
                <li>
                    <a target="_blank" href="/bachnhatgosu2023">bách nhật gosu</a>
                </li>
                <li>
                    <a target="_blank" href="https://www.facebook.com/groups/gosu.s20">facebook</a>
                </li>
                </ul>
            </div>
        </nav>
    </div>
</template>


<style>
.navbar_home{
  font-family: 'UVNLacLongQuan';
}

.navbar_home .nav-items-link{
  list-style: none;
  display: flex;
  margin-bottom: 0;
  text-transform: uppercase;
  font-size: 20px;
  
}

.navbar_home ul.nav-items-link li{
  /* padding: 0 20px; */
  color: #fdf3db;
  /* border-right: 2px solid #fdf3db; */
}


.navbar_home ul.nav-items-link li::after{
  content: "|";
  color: #fdf3db;
  margin: 0 20px;
}

.navbar_home ul.nav-items-link li:last-child::after{
  content: none;
}

.navbar_home ul.nav-items-link li a{
  color: #fdf3db;
  text-shadow: #FC0 1px 0 10px;
  text-decoration: none;
}

.navbar_home .navbar-brand-box{
    background: transparent !important;
}
</style>
