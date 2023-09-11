<script>
import AOS from 'aos';
import 'aos/dist/aos.css';
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
            message: false,
            btn_login: '/images/sinhnhat11nam/img_main/button-login.png'
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
        AOS.init({
            duration: 1000, // Thời gian hoàn thành hiệu ứng (milliseconds)
            easing: 'ease', // Thuật toán điều chỉnh (có thể sử dụng các giá trị khác nhau)
        });
    },
};
    
</script>
<template>
    <div class="landscape-notification">
        <img src="https://dl.dir.freefiremobile.com/common/web_event/common/images/scape.png" alt="" width="300">
        <p>Vui lòng xoay thiết bị của bạn sang chế độ nằm ngang để có trải nghiệm tốt hơn.</p>
    </div>
    <div class="main-login h-100vh w-100vw">
        <div class="content-login">
            <div class="banner-login" data-aos="fade-down-right">
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <img :src="btn_login" alt="" width="425" class="banner">
                </button>
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
                                <label for="email" class="w-25">ID GOSU:</label>
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

<style>

.landscape-notification {
  display: none;
  background-color: rgba(0, 0, 0, 0.9);
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  text-align: center;
  transform-origin: center;
  /* transform: rotate(90deg) translateY(-50%); */
  white-space: nowrap;
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  flex-direction: column;
}

.landscape-notification img{
    animation: swingOne 1.5s ease infinite alternate;
    margin-bottom: 100px;
}

.landscape-notification p{
    font-size: 20px;
}

@keyframes swingOne{
    0% {
        transform: rotate(-90deg);
    }
    30% {
        transform: rotate(-90deg);
    }
    70% {
        transform: rotate(0);
    }
    100% {
        transform: rotate(0);
    }
}

@media screen and (orientation: portrait) {
  .landscape-notification {
    display: flex;
  }
}

.banner-login{
    position: absolute;
    top: 600px;
    left: 450px;
}

.main-login button:focus,.main-login button:active,.main-login button:focus-visible{
    box-shadow: none;
    border: none;
    transform: none;
    outline: none;
}

.main-login button{
    border: none;
    background-color: transparent;
    transition: all 300ms linear;
}

.main-login button:hover{
    filter: brightness(120%);
}

</style>