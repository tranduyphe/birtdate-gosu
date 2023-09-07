<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <router-link to="/" class="logo logo-dark">
                        <span class="logo-sm pe-1">
                            <img src="../../../assets/images/sinhnhat11nam/img_main/logo-white.png" alt="" height="30" >
                        </span>
                        <span class="logo-lg">
                            <img src="../../../assets/images/sinhnhat11nam/img_main/logo-white.png" alt="" height="30">
                        </span>
                    </router-link>
                    <router-link to="/home" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="../../../assets/images/sinhnhat11nam/img_main/logo-white.png" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="../../../assets/images/sinhnhat11nam/img_main/logo-white.png" alt="" height="30">
                        </span>
                    </router-link>
                </div>

                
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-search-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                        aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="ri-search-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                

                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="/assets/images/users/avatar-2.jpg"
                            alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1">{{UserForm.name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">

                        <!-- <router-link class="dropdown-item" :to="{ name: 'Profile User' }"><i
                                class="ri-user-line align-middle mr-1"></i> Profile</router-link> -->
                        <!-- <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle mr-1"></i> My
                            Wallet</a>
                        <a class="dropdown-item d-block" href="#"><span
                                class="badge badge-success float-right mt-1">11</span><i
                                class="ri-settings-2-line align-middle mr-1"></i> Settings</a>
                        <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle mr-1"></i> Lock
                            screen</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" @click="logoutSubmit"><i
                                class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout</a>
                    </div>
                </div>

                <!-- <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="ri-settings-2-line"></i>
                    </button>
                </div> -->

            </div>
        </div>
    </header>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    created() {
        const body = document.querySelector('body');
        if (body.getAttribute('data-sidebar') === 'light') {
            body.setAttribute('data-sidebar', 'dark');
        }
    },
    methods: {
        ...mapActions(["oLogout"]),
        logoutSubmit() {
            this.oLogout("");
            
        },
        reloadPage() {
            location.reload();
        },

    },
    computed:{
        // authUser() {
        //     let user = this.$store.getters.infoUser;
        //     if (user !== undefined) {
        //         console.log("user",user);
        //         return user;
        //     }
        //     return JSON.parse(localStorage.getItem('infoUser'));
        // },
        UserForm() {
            let user = JSON.parse(this.$store.getters.infoUser);
            return {
                name: user ? user.name : ""
            }
        },
    }

};
</script>