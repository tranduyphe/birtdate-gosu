<template>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    
                    <li>
                        <router-link :class="{ 'mm-active': $route.name === 'Admin Dashboard' }" :to="{ name: 'Admin Dashboard' }" class="waves-effect" exact active-class="active">
                            <i class="ri-dashboard-line"></i>
                            <!-- <span class="badge badge-pill badge-success float-right">3</span> -->
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :class="{ 'mm-active': $route.name === 'All Vote' }" :to="{ name: 'All Vote' }" class="waves-effect" exact active-class="active">
                            <i class="ri-file-list-3-fill"></i>
                            <!-- <span class="badge badge-pill badge-success float-right">3</span> -->
                            <span>Quản lý biểu mẫu</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :class="{ 'mm-active': $route.name === 'Statistic Vote' }" :to="{ name: 'Statistic Vote' }" class="waves-effect" exact active-class="active">
                            <i class="ri-pie-chart-fill"></i>
                            <!-- <span class="badge badge-pill badge-success float-right">3</span> -->
                            <span>Thống kê lượt vote</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'All User' }" class=" waves-effect" exact tag="li" active-class="active"
                            v-if="checkPermission(['User Manager'])">
                            <i class="ri-calendar-2-line"></i>
                            <span>User manager</span>
                        </router-link>
                    </li>
                    <li :class="{ 'mm-active': $route.name === 'All Roles' || $route.name === 'Add Role' }"
                        v-if="checkPermission(['Role Manager'])">
                        <a href="javascript: void(0);"
                            :class="{ 'mm-active': $route.name === 'All Vote' || $route.name === 'Add Vote' }"
                            class="has-arrow waves-effect">
                            <i class="ri-store-2-line"></i>
                            <span>Vote</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <router-link :to="{ name: 'All Vote' }" exact tag="li" exact-active-class="active">Vote</router-link>
                            </li>
                            <!-- <li>
                                <router-link :to="{ name: 'Add Language' }" exact tag="li" exact-active-class="active">Add
                                    Languages</router-link>
                            </li> -->
                        </ul>
                    </li>
                    <li class="menu-title">Pages</li>
                    
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
</template>
<script>
export default {
    data() {
        return {
            isExpanded: false
        }
    },
    created() {
    },
    methods: {
        checkPermission(permissions) {
            true;
            // return checkPermissionAccess(permissions);
        }
    },
    mounted() {
        // Đặt lại thuộc tính aria-expanded khi component được tải lại
        // const element = document.getElementsByClassName('has-arrow');
        // if (element) {
        //     element.setAttribute('aria-expanded', this.isExpanded);
        // }
        const element = document.querySelector('.has-arrow');
        if (element instanceof Element) {
            element.setAttribute('aria-expanded', 'true');
        }
    },
    computed: {
        userHasAdmin() {
            return checkRolesAccess(['admin'])
        },
    }
}
</script>
