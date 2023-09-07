<template>
    <div class="wrapper-content" :style="{ backgroundImage:backgroundImageUrl() }">
        <div class="div-content container d-flex flex-column justify-content-between align-items-center">
            <div class="div-img">
                <img class="image-launch" :src="imagelaunchUrl" alt="" width="870">
            </div>
            <div class="countdown-parts d-flex align-items-center mt-4" v-if="!countdownExpired">
                <div class="countdown-part text-center p-3 mx-3">
                    <div class="countdown-value">{{ days }}</div>
                    <div class="countdown-label">Ngày</div>
                </div>
                <div class="countdown-part text-center p-3 mx-3">
                    <div class="countdown-value">{{ hours }}</div>
                    <div class="countdown-label">Giờ</div>
                </div>
                <div class="countdown-part text-center p-3 mx-3">
                    <div class="countdown-value">{{ minutes }}</div>
                    <div class="countdown-label">Phút</div>
                </div>
                <div class="countdown-part text-center p-3 mx-3">
                    <div class="countdown-value">{{ seconds }}</div>
                    <div class="countdown-label">Giây</div>
                </div>
            </div>
            <p class="date mt-4 font-size-24 text-white">18.9.2023 - 31.12.2023</p>
            <div class="login-action mt-3 text-center" v-if="countdownExpired">
                <p class="date-now mb-2 text-white">{{ formattedDateNow }}</p>
                <button class="btn btn-block p-0 btn-login" @click="showLoginModal"><img :src="loginbtnUrl" width="280"></button>
            </div>
            <b-modal :scrollable="false" id="modal-login" size="xl" hide-footer centered hide-header v-model="showModal">
                <button class="btn btn-check p-0 btn-close" @click="closeModal"><i class="fas fa-times fa-3x"></i></button>
                <h2 class="title text-center mb-4">Đăng nhập ID GOSU tại đây</h2>
                <form action="" class="form-login">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <label class="label-text mb-3">ID:<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <b-form-group id="id-gosu-text" class="">
                                <b-form-input for="text" v-model="id_gosu" name="id-gosu" id="id-gosu" placeholder="Nhập ID GOSU tại đây" required></b-form-input>
                            </b-form-group>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label class="label-text mb-3">Password:<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <b-form-group id="password-gosu" class="">
                                <b-form-input type="password" for="password" v-model="password" name="password" id="password" placeholder="Nhập ID GOSU tại đây" required></b-form-input>
                            </b-form-group>
                        </div>
                    </div>
                    <div class="next-action mt-4 text-center">
                        <button class="btn btn-block p-0 btn-login" @click=""><img :src="nextbtnUrl" width="250"></button>
                    </div>
                </form>
            </b-modal>
        </div>
    </div>
</template>
<!-- <p class="date mt-4 font-size-24 text-white">18/9/2023 - 31/12/2023</p> -->
<script>
export default {
    data() {
        return {
            targetDate: new Date("2023-09-18T00:00:00"), // Ngày đích đến
            countdown: "", // Chuỗi đếm ngược
            backgroundUrl: '/images/sinhnhat11nam/launch-bg.png',
            titlelaunchimgUrl: '/images/sinhnhat11nam/title-launch.png',
            backgroundUrl: '/images/sinhnhat11nam/launch-bg.png',
            backnhatimgUrl: '/images/sinhnhat11nam/bachnhat-2.png',
            chibiimgUrl: '/images/sinhnhat11nam/png-clipart-chibi.png',
            imagelaunchUrl: '/images/sinhnhat11nam/image-launch.png',
            loginbtnUrl: '/images/sinhnhat11nam/btn-login.png',
            nextbtnUrl: '/images/sinhnhat11nam/btn-next.png',
            seconds: "",
            minutes: "",
            hours: "",
            days: "",
            datenow: new Date(),
            showModal: false,
            id_gosu: "",
            password:"",
        };
    },
    created() {
        // Tính toán đếm ngược khi component được tạo
        this.updateCountdown();
        setInterval(this.updateCountdown, 1000); // Cập nhật đếm ngược mỗi giây
    },
    computed: {
        countdownExpired() {
            return this.days <= 0 && this.hours <= 0 && this.minutes <= 0 && this.seconds <= 0;
        },
        formattedDateNow() {
            const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
            return this.datenow.toLocaleDateString('vi-VN', options).replace(/\//g, '.');
        },
    },
    methods: {
        updateCountdown() {
            const now = new Date();
            const timeDifference = this.targetDate - now;
            
            if (timeDifference > 0) {
                this.seconds = Math.floor(timeDifference / 1000) % 60;
                this.minutes = Math.floor(timeDifference / (1000 * 60)) % 60;
                this.hours = Math.floor(timeDifference / (1000 * 60 * 60)) % 24;
                this.days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                
                // this.countdown = `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
            } else {
                this.countdown = "Countdown expired!";
            }
        },
        backgroundImageUrl() {
            return `url(${this.backgroundUrl})`;
        },
        showLoginModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        login() {
            // Xử lý đăng nhập tại đây
            console.log('Đăng nhập với email:', this.email, 'và mật khẩu:', this.password);
            // Sau khi xử lý xong, đóng modal
            this.closeModal();
        },
    },
};
</script>

<style scoped>

.wrapper-content{
    min-height: 100vh;
    height: auto;
    width: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-color: #000;
    font-family: 'UVNLacLongQuan';
}

.countdown-parts .countdown-part{
    background: #fff;
    min-width: 95px;
    min-height: 110px;
    color: #000;
    background-image: linear-gradient(180deg, rgba(156, 201, 155, 0.00) 0%, #9DCA9C 100%);;
}

.countdown-value{
    font-size: 32px;
    font-weight: 900;
}

.countdown-label{
    font-size: 20px;
}

.wrapper-content .div-img{
    position: relative;
    margin-left: -210px;
    margin-top: 65px;
}

.login-action img,.next-action img{
    transition: all 300ms linear;
    cursor: pointer;
}

.login-action img:hover,.next-action img:hover{
    filter: brightness(150%);
}

.login-action .btn,.next-action .btn{
    box-shadow: none;
}

.wrapper-content .date-now{
    font-size: 42px;
}

.btn-close{
    position: absolute;
    right: 30px;
    top: 20px;
    color: #000;
}

.btn-close:focus{
    box-shadow: none;
}

#modal-login .title, .form-login label{
    color: #0B2525;
    font-family: Inter;
    font-size: 32px;
    font-style: normal;
    font-weight: 400;
    line-height: 150%;
}

.form-login input{
    padding: 12px 25px;
    font-size: 16px;
    font-weight: 400;
    line-height: 150%; 
}

/* .div-img img.chibi-img{
    position: absolute;
} */
/* Định dạng cho phần giao diện của component (CSS có phạm vi scoped) */
</style>
