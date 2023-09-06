<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";

export default {
    components: {
    }, 
    data: () => {
        return {}
    },
    computed: {
        ...authGetters
    },
    methods: {
        ...authMethods,
        async signOut(){
            console.log("signOut");
            await this.logout();
        }
    },
    created: () => {
    },
    mounted: () =>{    
        console.log(this);    
    },
};
    
</script>
<template>
    <h2> Xin chào bạn! đã login thành công</h2>
    <div>
        <button class="btn btn-error" @click="signOut">Logout</button>
    </div>
</template>