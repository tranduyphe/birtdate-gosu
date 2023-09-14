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
            btn_login: '/images/sinhnhat11nam/img_main/button-login.png',
            title_login: '/images/sinhnhat11nam/img_main/title-login.png',
            logo_login: '/images/sinhnhat11nam/img_main/GOSU-2023.png',
            date_login: '/images/sinhnhat11nam/img_main/date-login.png',
            line_login: '/images/sinhnhat11nam/img_main/line-login.png',
            closeimgUrl: '/images/sinhnhat11nam/img_main/close.png',
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
    <div class="effect">
        <div class="content-login d-flex flex-column align-items-center justify-content-center">
            <img :src="logo_login" alt="" class="mb-5" data-aos="fade-down">
            <img class="mb-5" :src="title_login" alt="" data-aos="fade-down">
            <img class="mb-3" :src="date_login" alt="" data-aos="fade-down">
            <img class="mb-3" :src="line_login" alt="" data-aos="fade-up">
            <div class="banner-login text-center">
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#modalLogin" data-aos="fade-up">
                    <img :src="btn_login" alt="" width="" class="banner">
                </button>
            </div>
        </div>
    </div>
    <div class="main-login h-100vh w-100vw">
        <div class="modal fade modalcustom" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" ref="closeModal" class="btn close-button" data-bs-dismiss="modal" aria-label="Close"><img :src="closeimgUrl" alt=""></button>
                    <div class="modal-body">
                        <form @submit.prevent="signIn" class="frmLogin">
                            <h4 class="my-5 text-center">ĐĂNG NHẬP EMAIL GOSU TẠI ĐÂY</h4>
                            <div class="mb-5 form-group d-flex flex-row">
                                <label for="email" class="w-25">ID:</label>
                                <input type="email" v-model="dataLogin.email" class="form-control" id="email" placeholder="Nhập Email GOSU tại đây" />
                            </div>
                            <div class="mb-5 form-group auth-form-group-custom d-flex flex-row">
                                <label for="userpassword" class="w-25">Password:</label>
                                <input v-model="dataLogin.password" type="password" class="form-control"
                                    id="userpassword" placeholder="Nhập mật khậu Email GOSU tại đây" />
                            </div>
                            <span class="text-center error mb-4" v-if="message">{{ message }}</span>
                            <div class="text-center">
                                <button class="btn mt-3"
                                    type="submit"><img :src="btn_login" alt="" width="256" class=""></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

.frmLogin h4{
    font-weight: bold;
    color: #66494E;
}

.frmLogin input{
    border-radius: 5px;
}

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

/* .banner-login{
    position: absolute;
    top: 600px;
    left: 450px;
} */

.content-login{
    padding-top: 65px;
}

.banner-login button:focus,.banner-login button:active,.banner-login button:focus-visible,
.main-login button:focus,.main-login button:active,.main-login button:focus-visible{
    box-shadow: none;
    border: none;
    transform: none;
    outline: none;
}

.banner-login button{
    border: none;
    background-color: transparent;
    transition: all 300ms linear !important;
}

.banner-login button:hover{
    filter: brightness(120%);
}

#modalLogin button.close-button{
    position: absolute;
    right: -53px;
    top: 160px;
    z-index: 999;
    transition: all 200ms linear;
}

#modalLogin button.close-button:hover{
    filter: brightness(120%);
    cursor: pointer;
}

</style>