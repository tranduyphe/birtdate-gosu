<template>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <HeaderLayout />

        <!-- ========== Left Sidebar Start ========== -->
        <LeftSidebar />
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-start"
                                style="padding-bottom: 0px;">
                                <h4 class="mb-0 d-none d-md-block">
                                    <!-- {{ pageName }} -->
                                </h4>
                                <div class="page-title-right d-none">
                                    <ol class="breadcrumb" v-if="crumbs && crumbs.length > 0">
                                        <li class="breadcrumb-item" v-for="(crumb, index) in crumbs" :key="index">
                                            
                                            <router-link :to="{ path: crumb.link}">
                                                {{ crumb.title }}
                                            </router-link>
                                        </li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <router-view></router-view>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <FooterLayout />
        </div>
        <!-- end main content-->

    </div>

    <!-- END layout-wrapper -->
</template>
<script>

import LeftSidebar from './LeftSidebar.vue';
import HeaderLayout from './HeaderLayout.vue';
import FooterLayout from './FooterLayout.vue';
export default {
    components: {
        LeftSidebar,
        HeaderLayout,
        FooterLayout
    },

    computed: {
        crumbs() {
            const routes = this.$route.matched
            const crumbs = routes.map(route => ({
                title: route.name,
                link: route.path,
                breadcrumb: route.breadcrumb
            }))
            if (crumbs.length > 0 && crumbs[crumbs.length - 1].title === 'Admin Dashboard') {
                crumbs.pop()
            }
            return crumbs
        },
        pageName() {
            if (this.crumbs.length > 0) {
                return this.crumbs[this.crumbs.length - 1].title
            } else {
                return "Dashboard"
            }
        }
    },
}
</script>

<style>
.page-content{
    min-height: 809px;
}

</style>