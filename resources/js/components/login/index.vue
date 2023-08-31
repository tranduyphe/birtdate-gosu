<script>
import { login } from '../../helper/auth.js';
export default {
    components: {
    }, 
    data() {
        return {
            dataLogin: {
                email: '',
                password: '',
            },
        };
    },
    methods: {
        async login(){
            let data = await login(this.dataLogin);
            console.log(data);
            // if(data.status == 200){
            //     data = data.data;
            //     sessionStorage.setItem("author", JSON.stringify(data.data));
            // }
        },

        async logout(){
            let data = await axios
                .post('/api/logout', );
            console.log(data);
            // if(data.status == 200){
            //     data = data.data;
            //     sessionStorage.setItem("author", JSON.stringify(data.data));
            // }
        }
    },
    created() {
    },
    mounted() {
    },
};
    
</script>
<template>
    <form @submit.prevent="login">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" v-model="dataLogin.email" class="form-control" id="email" placeholder="Enter email" />
        </div>

        <div class="form-group auth-form-group-custom mb-4">
            <label for="userpassword">Password</label>
            <input v-model="dataLogin.password" type="password" class="form-control"
                id="userpassword" placeholder="Enter password" />
        </div>

        <div class="mt-4 text-center">
            <button class="btn btn-primary"
                type="submit">Log In</button>
        </div>
    </form>
</template>