<template>
    <div class="wrapper-content" :style="{ backgroundImage:backgroundImageUrl() }">
        <div class="div-content">
            <div class="div-img thap-thanh-tuu" data-aos="fade-down" @click="openModalThapThanhTuu">
                <img :src="thapthanhtuuimgUrl" alt="Tháp Thành Tựu" width="485">
            </div>
            <!-- <button class="div-img thap-thanh-tuu" @click="showMedalPopupCKT"> <img :src="thapthanhtuuimgUrl" alt="Tháp Thành Tựu" width="485"></button> -->
            <div class="div-img thu-vien-toan-tri" @click="openModalThuVien" data-aos="fade-right">
                <img :src="thuvienimgUrl" alt="Thư Viện Toàn Tri" width="295">
            </div>
            <div class="div-img nha-thi-dau" data-aos="fade-up">
                <img :src="nhathidauimgUrl" alt="Nhà Thi Đấu" width="290">
            </div>
            <div class="div-img sanh-hop-hep" data-aos="fade-left">
                <img :src="sanhhophepimgUrl" alt="Sảnh Họp Hẹp" width="295">
            </div>
            <div class="div-img items thongbao" data-aos="fade-left">
                <img :src="thongbaoimgUrl" alt="Thông báo" width="">
                <span class="font-size-16 text-white">{{ attrThongbao }}</span>
            </div>
            <div class="div-img items kimcuong" data-aos="fade-left">
                <img :src="kimcuongimgUrl" alt="Thông báo" width="">
                <span class="font-size-16 text-white">{{ attrKimcuong }}</span>
            </div>
            <div class="div-img items longvu" data-aos="fade-left">
                <img :src="longvuimgUrl" alt="Thông báo" width="">
                <span class="font-size-16 text-white">{{ attrLongvu }}</span>
            </div>
        </div>
        <div class="banner-name" data-aos="fade-up-right">
            <img :src="bannerNameimgUrl" alt="" width="425" class="banner">
            <div class="infor-user d-flex align-items-center justify-content-between">
                <div class="group-info d-flex align-items-center">
                    <img :src="sanhhophepimgUrl" alt="" class="avatar" width="65" height="65">
                    <p class="mb-0">&nbsp;Xin chào&nbsp;<strong>{{user_name}}</strong></p>
                </div>
                <a href="javascript:void(0)" @click="logoutSubmit" class="logout mb-0 pl-2">Thoát</a>
            </div>
        </div>
        <b-modal v-model="showModalThuVien" id="ThuVienModal2" hide-footer centered hide-header>
            <button class="btn-close btn" @click="closeModalThuVien"><img :src="closeimgUrl" alt=""></button>
            <ModalThuVien ></ModalThuVien>
        </b-modal>
        <b-modal v-model="showModalThapThanhTuu" id="ThapThanhTuuModal" hide-footer centered hide-header>
            <button class="btn-close btn" @click="closeModalThapThanhTuu"><img :src="closeimgUrl" alt=""></button>
            <ModalThapThanhTuu></ModalThapThanhTuu>
        </b-modal>
        
        <!-- Modal -->
        <!-- <div class="modal fade" id="ThuVienModal" tabindex="-1" role="dialog" aria-labelledby="medalModalLabel"
            aria-hidden="true">
            
            
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <ModalThapThanhTuu></ModalThapThanhTuu>
                        
                    </div>
                    <div class="modal-footer">
                            <button class="btn-close btn" @click="closeMedalPopupCKT"><img :src="closeimgUrl" alt=""></button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    
</template>
<!-- <p class="date mt-4 font-size-24 text-white">18/9/2023 - 31/12/2023</p> -->
<script>

import AOS from 'aos';
import 'aos/dist/aos.css';

import ModalThuVien from './modal-detail/thuvien-modal.vue';
import ModalThapThanhTuu from './modal-detail/thapthanhtuu-modal.vue';

import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    components: {
        ModalThuVien,
        ModalThapThanhTuu
    },
    data() {
        return {
            targetDate: new Date("2023-09-18T00:00:00"), // Ngày đích đến
            countdown: "", // Chuỗi đếm ngược
            backgroundUrl: '/images/sinhnhat11nam/img_main/bg.png',
            thapthanhtuuimgUrl: '/images/sinhnhat11nam/img_main/thap-thanh-tuu.png',
            thuvienimgUrl: '/images/sinhnhat11nam/img_main/thu-vien.png',
            nhathidauimgUrl: '/images/sinhnhat11nam/img_main/nha-thi-dau.png',
            sanhhophepimgUrl: '/images/sinhnhat11nam/img_main/sanh-hop-hep.png',
            bannerNameimgUrl: '/images/sinhnhat11nam/img_main/banner-name.png',
            closeimgUrl: '/images/sinhnhat11nam/img_main/close.png',
            thongbaoimgUrl: '/images/sinhnhat11nam/img_main/thongbao.png',
            kimcuongimgUrl: '/images/sinhnhat11nam/img_main/kimcuong.png',
            longvuimgUrl: '/images/sinhnhat11nam/img_main/longvu.png',
            user_name: "minhtam.nguyen",
            showModalThuVien: false,
            showModalThapThanhTuu: false,
            attrKimcuong: 67,
            attrLongvu: 15,
            attrThongbao: 340,
        };
    },
    created() {

    },
    mounted() {
        // Khởi tạo AOS và cấu hình tùy chọn theo ý muốn
        AOS.init({
            duration: 1000, // Thời gian hoàn thành hiệu ứng (milliseconds)
            easing: 'ease', // Thuật toán điều chỉnh (có thể sử dụng các giá trị khác nhau)
        });
    },
    computed: {
        
    },
    methods: {
        ...mapActions(["oLogout"]),

        logoutSubmit() {
            this.oLogout("");
        },

        backgroundImageUrl() {
            return `url(${this.backgroundUrl})`;
        },
        openModalThuVien() {
            this.showModalThuVien = true;
        },
        closeModalThuVien(){
            this.showModalThuVien = false;
        },
        openModalThapThanhTuu() {
            this.showModalThapThanhTuu = true;
        },
        closeModalThapThanhTuu(){
            this.showModalThapThanhTuu = false;
        },
        showMedalPopupCKT() {
            $('#ThuVienModal').modal('show');
        },
        closeMedalPopupCKT() {
            $('#ThuVienModal').modal('hide');
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
    position: relative;
    transition: all 500ms linear;
}


.wrapper-content .div-img{
    position: absolute;
}

.wrapper-content .div-img img,.banner-name{
    transition: all 300ms linear;
    cursor: pointer;
}

.wrapper-content .div-img img:hover{
    filter: brightness(140%);
}

.banner-name:hover{
    filter: brightness(120%);
}

.wrapper-content .div-img.thap-thanh-tuu{
    top: 50px;
    right: 275px;
}    

.wrapper-content .div-img.thu-vien-toan-tri{
    top: 350px;
    right: 710px;
} 

.wrapper-content .div-img.nha-thi-dau{
    top: 615px;
    right: 525px;
} 

.wrapper-content .div-img.sanh-hop-hep{
    top: 512px;
    right: 215px;
}

.wrapper-content .div-img.thongbao{
    top: 315px;
    right: 135px;
}

.wrapper-content .div-img.kimcuong{
    top: 425px;
    right: 165px;
}

.wrapper-content .div-img.longvu{
    top: 525px;
    right: 205px;
}

.wrapper-content .div-img.items span{
    position: absolute;
    bottom: 26px;
    right: 50%;
    text-align: center;
    transform: translate(50%, 0%);
}

.banner-name{
    position: absolute;
    top: 650px;
    left: 523px;
}

.banner-name .infor-user{
    position: absolute;
    top: 60px;
    left: 45px;
    width: 80%;
}

.banner-name p,.banner-name a{
    color: #66494e;
    font-size: 16px;
}

.banner-name a{
    border-left: 2px solid #66494e;
}

.banner-name img.avatar{
    border-radius: 50%;
    border: 2.5px solid #ffffff;
}

button.btn-close{
    position: absolute;
    right: -13px;
    top: 111px;
    transition: all 200ms linear;
}

button.btn-close:hover{
    filter: brightness(130%);
}

button.btn-close:focus{
    box-shadow: none;
}

#ThapThanhTuuModal button.btn-close{
    right: -53px;
    top: 155px;
}
/* .div-img img.chibi-img{
    position: absolute;
} */
/* Định dạng cho phần giao diện của component (CSS có phạm vi scoped) */
</style>
