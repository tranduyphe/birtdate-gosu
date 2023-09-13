<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";

export default {
    components: {
    }, 
    data: () => {
        return {
            
        }
    },
    computed: {
    },
    methods: {
        ...authMethods,
        ...authGetters,
        async signOut(){
            await this.logout();
        },
        async infoUser(){
            let user = await this.users();
        }
    },
    created () {
        this.infoUser();
        // this.user = this.users();
        
    },
    mounted: () =>{    
        // console.log(this);    
    },
};
    
</script>
<template>
    <h2> Xin chào bạn! đã login thành công</h2>
    <div>
        <button class="btn btn-error" @click="signOut">Logout</button>
    </div>
</template>