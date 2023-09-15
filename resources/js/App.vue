<script>

import Header from '@/components/layouts/Header';

export default {
    components: {
        Header
    },
    data() {},
    computed: {
    },
    methods: {
    },
    created(){       
    },
    mounted(){
    }
}
</script>
<template>
    <div class="nav-main container-fluid py-4 px-5">
        <Header></Header>
    </div>
    <router-view></router-view>
</template>

<style>
.nav-main{
    position: fixed;
    width: 100%;
    z-index: 2;
}
</style>