<template>
    <div class="landscape-notification">
        <img src="https://dl.dir.freefiremobile.com/common/web_event/common/images/scape.png" alt="" width="300">
        <p>Vui lòng xoay thiết bị của bạn sang chế độ nằm ngang để có trải nghiệm tốt hơn.</p>
    </div>
    <div class="popup-start" v-if="isDivVisible && readInstructions == 0">
        <button type="button" ref="closePopup" class="btn close-button popup" @click="toggleDivVisibility"><img
                :src="closeimgUrl" alt=""></button>
    </div>
    <div class="wrapper-content" :style="{ backgroundImage: backgroundImageUrl() }">
        <div class="div-content">
            <div class="div-img mui-ten" v-if="readInstructions == 0" :class="{ 'd-none': clickedThanhThanhTuu }">
                <img :src="muitenimgUrl" alt="">
            </div>
            <div class="div-img thap-thanh-tuu" data-aos="fade-down">
                <div class="group-img">
                    <button class="" data-bs-toggle="modal" data-bs-target="#ThapThanhTuuModal" @click="clickThanhThanhTuu">
                        <img :src="thapthanhtuuimgUrl" alt="Tháp Thành Tựu" width="485" @click="getDataPhapThanhTuu">
                    </button>
                    <div class="bubble-content">
                        <p>Điểm danh và làm nhiệm vụ ngày.</p>
                    </div>
                </div>
            </div>
            <!-- <button class="div-img thap-thanh-tuu" @click="showMedalPopupCKT"> <img :src="thapthanhtuuimgUrl" alt="Tháp Thành Tựu" width="485"></button> -->
            <div class="div-img thu-vien-toan-tri" data-aos="fade-right">
                <div class="group-img">
                    <!-- <button class="" data-bs-toggle="modal" data-bs-target="#ThuVienModal" @click="activeQuest"> -->
                    <button class="" data-bs-toggle="modal" data-bs-target="#ThuVienModal">
                        <img :src="thuvienimgUrl" alt="Thư Viện Toàn Tri" width="295">
                    </button>
                    <div class="bubble-content">
                        <p>Săn nguyên liệu.</p>
                    </div>
                </div>
            </div>
            <div class="div-img nha-thi-dau" data-aos="fade-up">
                <div class="group-img">
                    <button class="" data-bs-toggle="modal" data-bs-target="#NhaThiDauModal">
                        <img :src="nhathidauimgUrl" alt="Nhà Thi Đấu" width="290">
                    </button>
                    <div class="bubble-content">
                        <p>Thu thập Lông Phượng Hoàng.</p>
                    </div>
                </div>

            </div>
            <div class="div-img sanh-hop-hep" data-aos="fade-left">
                <div class="group-img">
                    <button class="" data-bs-toggle="modal" data-bs-target="#SanhHopHepModal" @click="clickSanhHopHep">
                        <img :src="sanhhophepimgUrl" alt="Sảnh Họp Hẹp" width="295">
                    </button>
                    <div class="bubble-content">
                        <p>Thắp sáng GOSU11.</p>
                    </div>
                </div>
            </div>
            <div class="div-img items thongbao" data-aos="fade-left">
                <button class="" data-bs-toggle="modal" data-bs-target="#ThapThanhTuuModal" v-if="completedQuestCount > 0"
                    @click="openThuThach = 1">
                    <img :src="thongbaoimgUrl" alt="Thông báo" width="" @click="getDataPhapThanhTuu">
                    <span class="font-size-16 text-white">{{ completedQuestCount }}</span>
                </button>
                <button class="" data-bs-toggle="modal" data-bs-target="" v-else>
                    <img :src="thongbaoimgUrl" alt="Thông báo" width="" @click="getDataPhapThanhTuu">
                    <span class="font-size-16 text-white">{{ completedQuestCount }}</span>
                </button>
                <div class="bubble-content">
                    <p>Thông báo</p>
                </div>
            </div>
            <div class="div-img items kimcuong" data-aos="fade-left">
                <img :src="kimcuongimgUrl" alt="Thông báo" width="">
                <span class="font-size-16 text-white">{{ attrKimcuong }}</span>
                <div class="bubble-content">
                    <p>Đá Mặt Trăng</p>
                </div>

            </div>
            <div class="div-img items longvu" data-aos="fade-left">
                <img :src="longvuimgUrl" alt="Thông báo" width="">
                <span class="font-size-16 text-white">{{ attrLongvu }}</span>
                <div class="bubble-content">
                    <p>Lông Phượng Hoàng</p>
                </div>
            </div>
        </div>
        <div class="banner-name" data-aos="fade-up-right">
            <img :src="bannerNameimgUrl" alt="" width="425" class="banner">
            <div class="infor-user d-flex align-items-center justify-content-between">
                <div class="group-info d-flex align-items-center">
                    <img :src="avatar" alt="" class="avatar" width="65" height="65">
                    <p class="mb-0">&nbsp;Xin chào&nbsp;<strong>{{ user_name }} </strong></p>
                </div>
                <a href="javascript:void(0)" @click="logoutSubmit" class="logout">Thoát</a>
            </div>
        </div>

        <div class="modal fade modalNhaThiDau" id="NhaThiDauModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" ref="closeModal" class="btn close-button" data-bs-dismiss="modal"
                            aria-label="Close"><img :src="closeimgUrl" alt=""></button>
                        <ModalNhaThiDau :attrKimcuong="attrKimcuong" :attrLongvu="attrLongvu"
                            @updateAttrKimcuong="updateAttrKimcuong" @updateAttrLongvu="updateAttrLongvu"></ModalNhaThiDau>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modalThuVien" id="ThuVienModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" ref="closeModal" class="btn close-button" data-bs-dismiss="modal"
                            aria-label="Close"><img :src="closeimgUrl" alt=""></button>
                        <ModalThuVienToanTri :attrKimcuong="attrKimcuong" :attrLongvu="attrLongvu"
                            @updateAttrKimcuong="updateAttrKimcuong" @updateAttrLongvu="updateAttrLongvu">
                        </ModalThuVienToanTri>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modalSanhHopHep" id="SanhHopHepModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" ref="closeModal" class="btn close-button" data-bs-dismiss="modal"
                            aria-label="Close"><img :src="closeimgUrl" alt=""></button>
                        <ModalSanhHopHep :dataPuzzle="dataPuzzle" @updateDataSanhHopHep="updateDataSanhHopHep">
                        </ModalSanhHopHep>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modalThapThanhTuu" id="ThapThanhTuuModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button @click="openThuThach = 0" type="button" ref="closeModal" class="btn close-button"
                            data-bs-dismiss="modal" aria-label="Close"><img :src="closeimgUrl" alt=""></button>
                        <ModalThapThanhTuu :nhiemvu="nhiemvu" @updateNhiemvu="updateNhiemvu" :logActivity="logActivity"
                            @updateLogActivity="updateLogActivity" :topFeathers="topFeathers"
                            @updateTopFeathers="updateTopFeathers" :attrKimcuong="attrKimcuong"
                            @updateAttrKimcuong="updateAttrKimcuong" :attrLongvu="attrLongvu"
                            @updateAttrLongvu="updateAttrLongvu" :user_code="user_code" :readInstructions="readInstructions"
                            :muitenimgUrl="muitenimgUrl" :openThuThach="openThuThach"></ModalThapThanhTuu>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<!-- <p class="date mt-4 font-size-24 text-white">18/9/2023 - 31/12/2023</p> -->
<script>

import AOS from 'aos';
import 'aos/dist/aos.css';
import $ from 'jquery';
import ModalNhaThiDau from './modal-detail/nhathidau-modal.vue';
import ModalThapThanhTuu from './modal-detail/thapthanhtuu-modal.vue';
import ModalThuVienToanTri from './modal-detail/thuvien-modal2.vue';
import ModalSanhHopHep from './modal-detail/sanhhophep-modal.vue';

import {
    authGetters,
    authMethods,
} from "@/store/store";

export default {
    components: {
        ModalNhaThiDau,
        ModalThuVienToanTri,
        ModalThapThanhTuu,
        ModalSanhHopHep,
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
            muitenimgUrl: '/images/sinhnhat11nam/img_main/mui-ten.png',
            user_name: "",
            user_code: "",
            avatar: '/images/sinhnhat11nam/img_main/banner-name.png',
            showModalThuVien: false,
            showModalThapThanhTuu: false,
            attrKimcuong: 67,
            attrLongvu: 15,
            attrThongbao: 0,
            readInstructions: 0,
            friendCode: "",
            nhiemvu: [],
            logActivity: [],
            topFeathers: [],
            isDivVisible: true,
            clickedThanhThanhTuu: false,
            openThuThach: 0,
            dataPuzzle: []
        };
    },
    created() {
        this.getItemUser();
        this.user();
        this.getQuest();


        // Khai báo một biến để theo dõi trạng thái tab
        let tabActive = true;

        // Sử dụng sự kiện visibilitychange để kiểm tra trạng thái của tab
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                tabActive = true; // Tab đã trở lại trạng thái hiển thị
            } else {
                tabActive = false; // Tab không hoạt động
            }
        });
        setInterval(() => {
            console.log('tabActive', tabActive);
            if (tabActive) {

                this.getQuest();
            }
        }, 10000); // 10000 mili giây = 10 giây
    },
    mounted() {
        // Khởi tạo AOS và cấu hình tùy chọn theo ý muốn
        AOS.init({
            duration: 1000, // Thời gian hoàn thành hiệu ứng (milliseconds)
            easing: 'ease', // Thuật toán điều chỉnh (có thể sử dụng các giá trị khác nhau)
        });

        $(document).ready(function () {
            $('.nav-main').removeClass('hidden-header');
        });

    },
    computed: {
        questOpened() {
            let tabVisible = false;
            if (document.visibilityState === 'visible') {
                tabVisible = true; // Tab đang hiển thị
            } else {
                tabVisible = false; // Tab đã đóng hoặc không hiển thị
            }
            return tabVisible;
        },
        completedQuestCount() {
            // Tính toán số lượng nhiệm vụ đã hoàn thành dựa trên dữ liệu của bạn
            // Ví dụ:
            let completedQuest = 0;
            for (let i = 0; i < this.nhiemvu.length; i++) {
                if (this.nhiemvu[i].current_attempts >= this.nhiemvu[i].total_attempts && this.nhiemvu[i].is_reward == 0) {
                    completedQuest++;
                }
            }
            return completedQuest;
        }
    },
    methods: {
        ...authMethods,
        ...authGetters,
        async user() {
            let user = await this.users();
            this.user_name = user.name;
            this.user_code = user.user_code;
            this.avatar = user.avatar;
        },
        getDataPhapThanhTuu() {
            this.getQuest();
            this.getLogActivity();
            this.getTopFeathers();
        },
        getQuest() {
            let self = this;
            axios.get('/api/get-quests', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.nhiemvu = response.data.data.quests;
                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },

        getLogActivity() {
            let self = this;
            axios.get('/api/get-log-activity', {

            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        let dataLog = response.data.data.log_activity ?? [];

                        self.logActivity = [];
                        dataLog.forEach(element => {
                            self.logActivity.push({
                                "reason": element.reason,
                                "log_item": JSON.parse(element.log_item),
                                "name": element.name,
                                "formatted_created_at": element.formatted_created_at
                            });
                        });
                        // console.log("check logActivity",this.logActivity);
                        // self.logActivity = response.data.data.log_activity;
                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },
        getTopFeathers() {
            let self = this;
            axios.get('/api/get-top-feathers', {

            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.topFeathers = response.data.data.top_feathers;
                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },
        activeQuest() {
            let self = this;
            axios.post('/api/active-quest', {
                params: {
                    quest_id: 5
                },
            })
                .then(function (response) {
                    if (response.data.status === 200) {

                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();

        },
        getItemUser() {
            let self = this;
            axios.get('/api/get-item', {
            })
                .then(async function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.attrKimcuong = response.data.data.diamond;
                        self.attrLongvu = response.data.data.feathers;
                        self.readInstructions = response.data.data.read_instructions ?? 0;
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },

        async logoutSubmit() {
            console.log("signOut");
            await this.logout();
        },

        backgroundImageUrl() {
            return `url(${this.backgroundUrl})`;
        },

        updateAttrKimcuong(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            console.log("check updateAttrKimcuong: ", newValue);
            this.attrKimcuong = newValue;
        },
        updateAttrLongvu(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.attrLongvu = newValue;
        },
        updateNhiemvu(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.nhiemvu = newValue;
        },
        updateLogActivity(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            console.log("check updateLogActivity newValue", newValue)
            this.logActivity = newValue;
        },
        updateTopFeathers(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.topFeathers = newValue;
        },
        toggleDivVisibility() {
            this.isDivVisible = false;
        },

        clickThanhThanhTuu() {
            this.clickedThanhThanhTuu = true;
            this.openThuThach = 1;
        },

        updateDataSanhHopHep(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            console.log("check updateLogActivity newValue", newValue)
            this.dataPuzzle = newValue;
        },
        clickSanhHopHep() {
            this.getDataSanhTruongHopHep();

        },

        getDataSanhTruongHopHep() {

            let self = this;
            axios.get('/api/get-data-sanh-truong-hop-hep', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.dataPuzzle = response.data.data ?? [];
                        console.log(self.dataPuzzle);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },


    },
};
</script>

<style scoped>
.wrapper-content {
    height: 100vh;
    width: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-color: #000;
    font-family: 'UVNLacLongQuan';
    position: relative;
    transition: all 500ms linear;
}


.wrapper-content .div-img {
    position: absolute;
}

.wrapper-content .group-img {
    position: relative;
}

.wrapper-content .div-img button {
    transition: all 500ms linear;
    background: transparent;
    border: none;
}

.wrapper-content .div-img button:focus,
.wrapper-content .div-img button:active,
.wrapper-content .div-img button:focus-visible {
    box-shadow: none;
    border: none;
    transform: none;
    outline: none;
}



.wrapper-content .div-img img,
.banner-name {
    transition: all 300ms linear;
    cursor: pointer;
}

.wrapper-content .div-img img:hover {
    filter: brightness(140%);
}

.banner-name:hover {
    filter: brightness(120%);
}

.wrapper-content .div-img.thap-thanh-tuu {
    top: 50px;
    right: 275px;
}

.wrapper-content .div-img.thu-vien-toan-tri {
    top: 350px;
    right: 710px;
}

.wrapper-content .div-img.nha-thi-dau {
    top: 615px;
    right: 525px;
}

.wrapper-content .div-img.sanh-hop-hep {
    top: 512px;
    right: 215px;
}

.wrapper-content .div-img.thongbao {
    top: 315px;
    right: 135px;
}

.wrapper-content .div-img.kimcuong {
    top: 425px;
    right: 165px;
}

.wrapper-content .div-img.longvu {
    top: 525px;
    right: 205px;
}

.wrapper-content .div-img.items span {
    position: absolute;
    bottom: 26px;
    right: 50%;
    text-align: center;
    transform: translate(50%, 0%);
}

.wrapper-content .div-img.items.longvu span {
    position: absolute;
    bottom: 28px;
    right: 47%;
    text-align: center;
    transform: translate(50%, 0%);
}


.banner-name {
    position: absolute;
    top: 630px;
    left: 450px;
}

.banner-name .infor-user {
    position: absolute;
    top: 60px;
    left: 45px;
    width: 80%;
}

.banner-name p,
.banner-name a {
    color: #66494e;
    font-size: 16px;
    text-decoration: none;
}

.banner-name a::before {
    content: '|';
    color: #66494e;
    margin-right: 5px;
    font-weight: bold;
}

.banner-name img.avatar {
    border-radius: 50%;
    border: 2.5px solid #ffffff;
    object-fit: cover;
}

button.close-button {
    position: absolute;
    right: -53px;
    top: 120px;
    transition: all 200ms linear;
}

button.close-button.popup {
    position: absolute;
    right: 526px;
    top: 220px;
    transition: all 200ms linear;
}

button.close-button:hover {
    filter: brightness(130%);
}

button.close-button:focus,
button.close-button:active,
button.close-button:focus-visible {
    box-shadow: none;
    border: transparent;
    outline: none;
}

#ThapThanhTuuModal button.close-button {
    right: -53px;
    top: 155px;
}

/* .div-img img.chibi-img{
    position: absolute;
} */
/* Định dạng cho phần giao diện của component (CSS có phạm vi scoped) */

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


.popup-start {
    display: block;
    background: url('../../../../assets/images/sinhnhat11nam/img_main/popup.png');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9;
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

.landscape-notification img {
    animation: swingOne 1.5s ease infinite alternate;
    margin-bottom: 100px;
}

.landscape-notification p {
    font-size: 20px;
}

@keyframes swingOne {
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

.bubble-content {
    position: absolute;
    background-color: rgba(255, 187, 0, 0.6);
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1;
    /* display: none;  */
    opacity: 0;
    transition: all 300ms linear;
    color: #ffffff;
    border-radius: 10px;
    text-align: center;
}

.thap-thanh-tuu .bubble-content {
    top: 20%;
    right: -60px;
}

.thu-vien-toan-tri .bubble-content {
    bottom: 30%;
    left: -25%;
}

.sanh-hop-hep .bubble-content {
    top: 20%;
    left: -30%;
}

.nha-thi-dau .bubble-content {
    top: 15%;
    left: -55%;
}

.wrapper-content .div-img.items .bubble-content {
    width: 120px;
    top: 10%;
    left: 105%;
}

.wrapper-content .group-img:hover .bubble-content,
.wrapper-content .div-img.items:hover .bubble-content {
    /* display: block; */
    opacity: 1;
}

.bubble-content p {
    margin: 0;
}

.div-img.mui-ten img {
    transform: rotateZ(45deg);
}

.div-img.mui-ten {
    right: 35%;
    top: 10%;
}

.div-img.mui-ten {
    -webkit-animation: mover 0.5s infinite alternate;
    animation: mover 0.5s infinite alternate;
}

.div-img.mui-ten {
    -webkit-animation: mover 0.5s infinite alternate;
    animation: mover 0.5s infinite alternate;
}

@-webkit-keyframes mover {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-15px);
    }
}

@keyframes mover {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-15px);
    }
}</style>
