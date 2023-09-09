<script>

import {
    authMethods,
} from "@/store/store";

export default {
    components: {
        
    }, 
    data: () => {
        return{
            dataLogin: {
                email: '',
                password: '',
            },
            show:false,
            message: false
        }
    },
    computed: {
    },
    methods: {
        ...authMethods,
        async signIn(){
            let data = await this.login(this.dataLogin);
            if (data) {
                this.message = data.message;
            }else{
                this.$refs.closeModal.click();
            }
        },
        handleModal() {
            this.show = true;
        }
    },
    created: () => {
    },
    mounted: () => {       
    },
};
    
</script>
<template>    
    <div class="main-login h-100vh">
        <div class="content-login">
            <div class="d-flex h-100vh flex-column justify-content-center">
                <div class="content w-50 mx-auto text-center mt-10">
                    <h1>GOSU 11</h1>
                    <h2>make a wish</h2>
                    <span class="date">18.09.23</span>
                </div>
                <div class="text-center w-50 mx-auto">
                    <button type="button" class="btn btn-custom mt-1" data-bs-toggle="modal" data-bs-target="#modalLogin">Đăng nhập</button>
                </div>
            </div>
        </div>
        <div class="modal fade modalcustom" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-header d-none">
                    <button type="button" ref="closeModal" class="" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content">
                    <div class="modal-body">
                        <form @submit.prevent="signIn" class="frmLogin">
                            <h4 class="mb-4 text-center">Đăng nhập ID GOSU tại đây</h4>
                            <div class="mb-4 form-group d-flex flex-row">
                                <label for="email" class="w-25">ID:</label>
                                <input type="email" v-model="dataLogin.email" class="form-control" id="email" placeholder="Nhập ID GOSU tại đây" />
                            </div>
                            <div class="mb-4 form-group auth-form-group-custom d-flex flex-row">
                                <label for="userpassword" class="w-25">Password:</label>
                                <input v-model="dataLogin.password" type="password" class="form-control"
                                    id="userpassword" placeholder="Nhập mật khậu ID GOSU" />
                            </div>
                            <span class="text-center error mb-4" v-if="message">{{ message }}</span>
                            <div class="text-center">
                                <button class="btn btn-custom mt-1"
                                    type="submit">Tiếp theo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>