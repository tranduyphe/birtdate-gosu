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
            databachnhat: {
                email: '',
                password: '',
            },
            show:false,
            message: false,
            title_bachnhat: '/images/sinhnhat11nam/img_main/title-bachnhat.png',
            seconds: "",
            minutes: "",
            hours: "",
            days: "",
            targetDate: new Date("2023-09-18T00:00:00"), // Ngày đích đến
            countdown: "", // Chuỗi đếm ngược
        }
    },
    computed: {
    },
    methods: {
        ...authMethods,
        async signIn(){
            let data = await this.bachnhat(this.databachnhat);
            if (data) {
                this.message = data.message;
            }else{
                this.$refs.closeModal.click();
            }
        },
        handleModal() {
            this.show = true;
        },

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
                this.seconds = 0;
                this.minutes = 0;
                this.hours = 0;
                this.days = 0;
            }
        },
    },
    created() {
        this.updateCountdown();
        setInterval(this.updateCountdown, 1000); // Cập nhật đếm ngược mỗi giây
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
    <div class="main-bachnhat h-100vh w-100vw">
        <div class="content-bachnhat">
            <div class="banner-bachnhat" data-aos="fade-down">
                <img :src="title_bachnhat">
            </div>
        </div>
        <div class="countdown-parts d-flex align-items-center mt-4 justify-content-center" data-aos="fade-up">
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


.main-bachnhat .countdown-value{
    font-size: 50px;
    line-height: 1.3;
}

.main-bachnhat .countdown-label{
    font-size: 25px;
    color: #a0874f;
    line-height: initial;
}
</style>